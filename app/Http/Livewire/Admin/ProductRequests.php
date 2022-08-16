<?php

namespace App\Http\Livewire\Admin;

use App\Mail\snedmessage;
use App\Mail\standardEmail;
use App\Models\Bill;
use App\Models\chatGroup;
use App\Models\Client;
use App\Models\Message;
use App\Models\PaymentSetting;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ProductRequests extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $searchForm          = '';
    public $BillIbfoVisible = false;
    public $billInform;
    public $changeRequestStatus  = false;
    public $modelId;
    public $reqs;
    public $request;
    public $productStatus = null;
    public $senderAcceptRequest;
    public $senderStatus;
    use \App\Http\Traits\notifications;
    public function senderAcceptRequestFun() {
        $req = \App\Models\ProductRequests::findOrFail($this->modelId);
        $req->update([
            'sender_id' => Auth::guard('clients')->user()->id,
            'senderStatus'  => 1
        ]);
        chatGroup::where('request_id', '=', $req->id)->update([
            'sender_id' => Auth::guard('clients')->user()->id
        ]);
        $group = chatGroup::where('request_id', '=', $req->id)->first();

        Message::create([
            'message'   => "انضم المندوب الى المجموعة لمناقشة الطلب",
            'type'      => 0,
            'user_id'   => 1,
            'group_id'  => $group->id
        ]);
        $group = \App\Models\chatGroup::where('request_id', '=', $req->id)->first();
        $buyer = Client::findOrFail($group->buyer_id);
        $provieder = Client::findOrFail($group->provieder_id);
        $sender = Client::findOrFail($group->sender_id);

        Mail::to($buyer->email)->send(new snedmessage($buyer->name, $group->id));
        Mail::to($provieder->email)->send(new snedmessage($provieder->name, $group->id));
        Mail::to($sender->email)->send(new snedmessage($provieder->name, $group->id));
        Mail::to('altaawus2020@gmail.com')->send(new snedmessage('الادمن', $group->id));

        $this->hideModel();
        $this->alert('success', 'تم قبول الطلب بنجاح', [
            'position' =>  'center',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  null,
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
    }

    public function showSenderAcceptRequest($id) {
        $this->senderAcceptRequest = true;
        $this->modelId = $id;
    }

    public function editRequestStatus($id)
    {
        $this->changeRequestStatus = true;
        $this->modelId = $id;
        $this->reqs = \App\Models\ProductRequests::with('bill')->findOrFail($this->modelId);
        $this->request = \App\Models\ProductRequests::with('shipping_method')->findOrFail($this->modelId);
        $this->productStatus = $this->reqs->status;
        $this->reqs = $this->reqs->bill;
    }
    public function showBillInfoModel($id) {
        $this->BillIbfoVisible = true;
        $this->billInform = Bill::with('product.client.address', 'product.client.government', 'product.client.country', 'address', 'address.country', 'address.government' )->findOrFail($id);
    }
    public function changeRequestStatusFun() {
        if ($this->productStatus != null && is_numeric($this->productStatus)) {
            $get_request = \App\Models\ProductRequests::with( 'product:id,name,slug,receipt_days', 'buyer:id,name,email')->findOrFail($this->modelId);
            if ($this->productStatus == 1) {
                if ($get_request->product->receipt_days != null) {
                    $get_request->update([
                        'receipt_time'    => Carbon::now()->addDays($get_request->product->receipt_days),
                    ]);
                }
            } else if ($this->productStatus == 3) {
                Testimonial::create([
                    'client_id' => $get_request->buyer_id,
                    'token'     => strtolower(Str::random(16)).time(),
                    'product_id' => $get_request->product_id
                ]);

                $emailContent = " يمكنك الان تقيم منتج " . $get_request->product->name . '  ' . "<a href='".route('frontend.single-product', $get_request->product->slug)."'>من هنا</a>";
                $emailSubject = "  تقيم منتج " . $get_request->product->name;
                Mail::to($get_request->buyer->email)->send(new standardEmail($emailContent, $emailSubject, 'قيم من هنا', route('frontend.single-product', $get_request->product->slug)));
                $this->createNotification($emailContent, $get_request->buyer_id);
            }
            $get_request->update([
                'status'    => $this->productStatus
            ]);

            $this->hideModel();
            $this->alert('success', 'تمت العملية بنجاح', [
                'position' =>  'center',
                'timer' =>  3000,
                'toast' =>  true,
                'text' =>  null,
                'confirmButtonText' =>  'Ok',
                'cancelButtonText' =>  'Cancel',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  false,
            ]);
        } else {
            $this->alert('error', 'يجب اختيار حالة الطلب', [
                'position' =>  'center',
                'timer' =>  3000,
                'toast' =>  true,
                'text' =>  null,
                'confirmButtonText' =>  'Ok',
                'cancelButtonText' =>  'Cancel',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  false,
            ]);
        }

    }
    public function hideModel()
    {
        $this->changeRequestStatus = false;
        $this->BillIbfoVisible = false;
        $this->productStatus = null;
    }
    public function render()
    {
        $productsRequests = \App\Models\ProductRequests::with('buyer:id,name','provider:id,name', 'sender:id,name', 'product:id,name,main_image', 'bill', 'shipping_method', 'group')->where('soft_deleted', '=', 0);
        $data = $this->searchForm;
        if ($data != '') {
            $productsRequests = $productsRequests->whereHas('bill', function ($query) use ($data) {
                return $query->where('reference_number', '=', $data);
            });

        }
        $productsRequests = $productsRequests->orderBy('created_at', 'DESC')->paginate(20);



        return view('livewire.admin.product-requests', [
            'productsRequests'  => $productsRequests
        ]);
    }
}
