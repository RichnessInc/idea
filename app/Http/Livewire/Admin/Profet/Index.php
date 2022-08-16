<?php

namespace App\Http\Livewire\Admin\Profet;

use App\Http\Traits\calculateCommission;
use App\Http\Traits\notifications;
use App\Http\Traits\PointsSystem;
use App\Models\Bill;
use App\Models\Client;
use App\Models\Package;
use App\Models\PaymentSetting;
use App\Models\Product;
use App\Models\ProductRequests;
use App\Models\Readbox;
use App\Models\Receipt;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, calculateCommission, PointsSystem;
    use LivewireAlert, notifications;
    function get_profit($type) {
        $profit        = 0;
        $getReceipts   = Receipt::where('status', '=', 2);
        if ($type == 'month') {
            $getReceipts = $getReceipts->whereMonth('created_at', Carbon::now()->month)->get();
        } elseif($type == 'three') {
            $getReceipts   = $getReceipts->whereBetween('created_at', [
                Carbon::now()->subMonth(3), Carbon::now()
            ])->get();
        } elseif($type == 'six') {
            $getReceipts   = $getReceipts->whereBetween('created_at', [
                Carbon::now()->subMonth(6), Carbon::now()
            ])->get();
        } elseif($type == 'year') {
            $getReceipts   = $getReceipts->whereYear('created_at', Carbon::now()->year)->get();
        }

        foreach ($getReceipts as $receipt) {
            foreach(json_decode($receipt->bills_data) as $data) {
                if(json_decode($data->item_data)->model == \App\Models\Gift::class || json_decode($data->item_data)->model == \App\Models\Reesh::class || json_decode($data->item_data)->model == \App\Models\GiftTicket::class || json_decode($data->item_data)->model == Package::class) {
                    $profit += $receipt->total_price;
                } else { // Start Buy Product
                    // Start Global Variables
                    $product = Product::where('id', '=',json_decode($data->item_data)->product->id)->first();
                    if ($product != null) {
                        $Bill               = Bill::where('id', '=', $data->bill_id)->first();
                        if ($Bill != null) {
                            $get_request        = ProductRequests::with( 'sender:id,name', 'provider:id,name', 'bill')->findOrFail($Bill->product_request_id);
                            $provieder          = Client::where('id', '=', $product->client_id)->first();
                            if ($provieder != null) {
                                $commission         = $Bill->item_price * $receipt->provider_commission / 100;
                                if (json_decode($Bill->shipping_data)->shipping_method_id == 5
                                    || json_decode($Bill->shipping_data)->shipping_method_id == 7
                                    || json_decode($Bill->shipping_data)->shipping_method_id == 8
                                    || json_decode($Bill->shipping_data)->shipping_method_id == 9) {
                                    $sender_commission = $get_request->bill->shipping * 100 / 100;
                                } else {
                                    $sender_commission = $get_request->bill->shipping * $receipt->sender_commission / 100;
                                }
                                $profit    += ($sender_commission + $commission);
                            }
                        }
                    }
                }
            }
            $buyer = Client::where('id', '=', $receipt->client_id)->first();
            if ($buyer != null) {
                $profit -= (($receipt->total_price * $receipt->cashback_commission) / 100);
            }
            $get_marketer = Client::where('ref', '=', $receipt->client->parent_ref)->first();

            if ($get_marketer != null) {
                $get_com = $receipt->total_price * $receipt->marketing_commission / 100;
                $profit -= $get_com;
            }
        }
        return $profit;
    }
    public function render()
    {
        $profitThisMonth        = $this->get_profit('month');
        $profitLastThreeMonth   = $this->get_profit('three');
        $profitLastSixMonth     = $this->get_profit('six');
        $profitThisYear         = $this->get_profit('year');
        $getReceipts   = Receipt::where('status', '=', 2)->with('client:id,name,email')->whereYear('created_at', Carbon::now()->year)->orderBy('created_at', 'DESC')->paginate(20);
        $receipts = [];
        foreach ($getReceipts as $receiptsData) {
            $total_price = 0;
            $total_product = 0;
            $total_shipping = 0;
            foreach(json_decode($receiptsData->bills_data) as $data) {
                if(json_decode($data->item_data)->model == \App\Models\Gift::class || json_decode($data->item_data)->model == \App\Models\Reesh::class || json_decode($data->item_data)->model == \App\Models\GiftTicket::class || json_decode($data->item_data)->model == Package::class) {
                    $total_price += $receiptsData->total_price;
                } else {
                    $product = Product::where('id', '=',json_decode($data->item_data)->product->id)->first();
                    if ($product != null) {
                        $Bill = Bill::where('id','=', $data->bill_id)->first();
                        if ($Bill != null) {
                            $get_request = ProductRequests::with('sender:id,name', 'provider:id,name', 'bill')->findOrFail($Bill->product_request_id);
                            $provieder = Client::where('id','=', $product->client_id)->first();
                           if ($provieder != null) {
                           $commission         = $Bill->item_price * $receiptsData->provider_commission / 100;

                           if (json_decode($Bill->shipping_data)->shipping_method_id == 5
                                || json_decode($Bill->shipping_data)->shipping_method_id == 7
                                || json_decode($Bill->shipping_data)->shipping_method_id == 8
                                || json_decode($Bill->shipping_data)->shipping_method_id == 9) {
                               $sender_commission = $Bill->shipping * 100 / 100;
                           } else {
                               $sender_commission = $Bill->shipping * $receiptsData->sender_commission / 100;
                           }

                               $total_price += ($sender_commission + $commission);
                               $total_product += ($commission);
                               $total_shipping += ($sender_commission);
                           }
                        }

                    }
                }

            }
            $buyer = Client::where('id', '=', $receiptsData->client_id)->first();
            if ($buyer != null) {
                $total_price -= (($receiptsData->total_price * $receiptsData->cashback_commission) / 100);
            }
            $get_marketer = Client::where('ref', '=', $buyer->parent_ref)->first();
            if ($get_marketer != null) {
                $get_com = $receiptsData->total_price * $receiptsData->marketing_commission / 100;
                $total_price -= $get_com;
            }

            $receipts[] = [
                "id"                => $receiptsData->id,
                "bills_data"        => $receiptsData->bills_data,
                "total_price"       => $receiptsData->total_price,
                "total_shipping"    => $receiptsData->total_shipping,
                "payment_data"      => $receiptsData->payment_data,
                "paymentmethod"     => $receiptsData->paymentmethod,
                "client_name"       => $receiptsData->client->name,
                "client_email"      => $receiptsData->client->email,
                "created_at"        => $receiptsData->created_at,
                "profit_provider"               => $total_product,
                "profit_sender"                 => $total_shipping,
                "profit_total"                  => $total_price,
            ];
        }
        return view('livewire.admin.profet.index', [
            'profitThisMonth'       => number_format($profitThisMonth),
            'profitLastThreeMonth'  => number_format($profitLastThreeMonth),
            'profitLastSixMonth'    => number_format($profitLastSixMonth),
            'profitThisYear'        => number_format($profitThisYear),
            'getReceipts'           => $receipts
        ]);
    }
    public $readbox_cost;
    public function change() {
        $this->validate([
            'readbox_cost'          => 'required|numeric',
        ]);
        $readBoxData = Readbox::findOrFail(1);
        $readBoxData->update([
            'readbox_cost' => $this->readbox_cost
        ]);
        $this->alert('success', 'تم تغير القيمة بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
    }
    public function zero() {
        $readBoxData = Readbox::findOrFail(1);
        $readBoxData->update([
            'dues' => 0
        ]);
        $this->alert('success', 'تم تسديد الديون بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
    }
}
