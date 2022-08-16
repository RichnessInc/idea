<?php

namespace App\Http\Controllers;

use App\Http\Traits\calculateCommission;
use App\Http\Traits\PointsSystem;
use App\Mail\CreatedRoom;
use App\Mail\mainEmail;
use App\Models\Address;
use App\Models\Bill;
use App\Models\chatGroup;
use App\Models\Client;
use App\Models\Gift;
use App\Models\GiftTicket;
use App\Models\Government;
use App\Models\Message;
use App\Models\Package;
use App\Models\PackageBuyer;
use App\Models\PaymentSetting;
use App\Models\Product;
use App\Models\ProductRequests;
use App\Models\Receipt;
use App\Models\Reesh;
use App\Models\singleRoom;
use App\Models\singleRoomMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class   PaypalController extends Controller
{
    use calculateCommission, PointsSystem;
    public function paypal_redirect(Request $request) {
        $bills          = [];
        $this_bills     = Bill::where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('status', '=', 0);
        $total_price    = $this_bills->sum('total_price');
        $total_shipping = $this_bills->sum('shipping');
        $this_bills = $this_bills->get();
        $client_id      = Auth::guard('clients')->user()->id;
        foreach ($this_bills as $bill) {

            $bills[] = [
                'item_data'         => $bill->item_data,
                'item_price'        => $bill->item_price,
                'shipping'          => $bill->shipping,
                'total_price'       => $bill->total_price,
                'reference_number'  => $bill->reference_number
            ];

            if (json_decode($bill->item_data)->model == Gift::class || json_decode($bill->item_data)->model == Reesh::class) {
                $sec = (json_decode($bill->item_data)->model == Gift::class ? ' صندوق حظ ' : ' ريشة مرح ');
                $get_room_id    = singleRoom::where('client_id', '=', $client_id)->first()->id;
                singleRoomMessage::create([
                    'client_id' => $client_id,
                    'room_id'   => $get_room_id,
                    'admin_id'  => 1,
                    'from'      => 1,
                    'message'   => 'لقد قمت بشراء ' . $sec . ' من الادارة '
                ]);
            } else if(json_decode($bill->item_data)->model == Product::class) {
                $product                    = Product::findOrFail( json_decode($bill->item_data)->product->id );
                $provieder                  = Client::findOrFail( $product->client_id );
                $address                    = Address::findOrFail(json_decode($bill->shipping_data)->address_id);
                $gov                        = Government::where('id', '=', $address->government_id)->first();
                $branch                     = Address::findOrFail(json_decode($bill->shipping_data)->branch_id);

                $req                        = ProductRequests::create([
                    'buyer_id'              => $client_id,
                    'provieder_id'          => $product->client_id,
                    'product_id'            => json_decode($bill->item_data)->product->id,
                    'payment_method_id'     => 1,
                    'payment_status'        => 1,
                    'shipping_method_id'    => json_decode($bill->shipping_data)->shipping_method_id,
                    'government_id'         => $gov->id,
                    'branch_id'         => $branch->government_id
                ]);
                $bill->update(['product_request_id' => $req->id]);
                $group = chatGroup::create([
                    'buyer_id'  => $client_id,
                    'provieder_id'  => $product->client_id,
                    'request_id'    => $req->id,
                ]);
                Mail::to($provieder->email)->send(new CreatedRoom($provieder->name, $group->id));
                Mail::to(Auth::guard('clients')->user()->email)->send(new CreatedRoom(Auth::guard('clients')->user()->name, $group->id));
                Mail::to('altaawus2020@gmail.com')->send(new CreatedRoom('الادمن', $group->id));
                Message::create([
                    'message'   => "تم انشاء المجموعة لمناقشة الطلب",
                    'type'      => 0,
                    'user_id'   => 1,
                    'group_id'  => $group->id
                ]);
            } elseif (json_decode($bill->item_data)->model == GiftTicket::class ) {
                GiftTicket::findOrFail(json_decode($bill->item_data)->item_id)->update([
                    'paid'  => 1,
                ]);
            } elseif (json_decode($bill->item_data)->model == Package::class ) {
                $package = Package::findOrFail(json_decode($bill->item_data)->item_id);
                PackageBuyer::create([
                    'status'        => 1,
                    'client_id'     => $client_id,
                    'package_id'    => $package->id,
                ]);
            }
        }

        Receipt::create([
            'bills_data'        => json_encode($bills),
            'total_price'       => $total_price,
            'total_shipping'    => $total_shipping,
            'payment_data'      => json_encode($request->all()),
            'client_id'         => Auth::guard('clients')->user()->id,
            'paymentmethod'     => 'paypal',
            'paymentmethod_id'  => 1,
            'status'            => 1,
            'reference_number'  => rand(100, 999).'-'.rand(100, 999).'-'.rand(100, 999)
        ]);
        Mail::to(['altaawus2020@gmail.com', Auth::guard('clients')->user()->email])->send(new mainEmail(config('app.name'), 'تم دفع فواتير الخزنة'));
        Bill::where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('status', '=', 0)->update(['status' => 1]);
        session()->flash('message', 'تم دفع الفواتير بنجاح.');

        return redirect('/');
    }

    public function paypal_cancel() {
        $content = " تم الغاء عملية الدفع عن طريق باي بال";
        $this->createNotification($content, Auth::guard('clients')->user()->id);
        return redirect('/');
    }
}
