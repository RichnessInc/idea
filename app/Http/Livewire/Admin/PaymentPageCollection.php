<?php

namespace App\Http\Livewire\Admin;

use App\Http\Traits\calculateCommission;
use App\Http\Traits\notifications;
use App\Http\Traits\PointsSystem;
use App\Models\Address;
use App\Models\billsCollection;
use App\Models\Client;
use App\Models\Package;
use App\Models\PaymentSetting;
use App\Models\Product;
use App\Models\productRequestsCollection;
use App\Models\Readbox;
use App\Models\receiptCollection;
use Illuminate\Support\Facades\Http;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentPageCollection extends Component
{
    use WithPagination, calculateCommission, PointsSystem;
    use LivewireAlert, notifications;

    public $acceptFormVisible   = false;
    public $rejectFormVisible   = false;
    public $contentFormVisible  = false;
    public $searchForm          = '';
    public $modelId;
    public $info;

    public function confirmAccept($id) {
        $this->modelId = $id;
        $this->acceptFormVisible = true;
    }
    public function confirmReject($id) {
        $this->modelId = $id;
        $this->rejectFormVisible = true;
    }
    public function showContent($id) {
        $this->info = receiptCollection::findOrFail($id);
        $this->modelId = $id;
        $this->contentFormVisible = true;
    }
    public function accept() {
        $receipt = receiptCollection::with('client', 'client.address', 'client.address.government')->findOrFail($this->modelId);
        $wightShip = 0;
        $mainProduct = null;
        $clientAddress = null;
        foreach(json_decode($receipt->bills_data) as $data) {
            if(json_decode($data->item_data)->model == \App\Models\Product::class) {
                // Start Global Variables
                $product        = Product::with('client')->findOrFail( json_decode($data->item_data)->product->id );
                $mainProduct    = Product::with('client')->findOrFail( json_decode($data->item_data)->product->id );
                $productNameSP = $product->name;
                $Bill           = billsCollection::findOrFail($data->bill_id);
                $get_request    = productRequestsCollection::with( 'sender:id,name', 'provider:id,name', 'bill')->findOrFail($Bill->product_request_id);

                if(json_decode($Bill->shipping_data)->shipping_method_id == 4 )  {
                    $wightShip += $product->wight;
                    $clientAddress = Address::with('government')->findOrFail(json_decode($Bill->shipping_data)->address_id);
                }
                // End Global Variables
                // Start Provider
                $provieder   = Client::findOrFail($product->client_id);
                $commission = $this->calculate_commission($provieder->id, $data->item_price);
                // dd($commission);
                $receipt->update([
                    'provider_commission' => ($this->get_commission($provieder)  != false ? $this->get_commission($provieder) : 0)
                ]);
                // dd($commission);
                if ($receipt->paymentmethod == 'الدفع عند الاستلام') {
                    $provieder->update([
                        'debt'    => $provieder->debt + $commission
                    ]);
                } else {
                    $provieder->update([
                        'wallet'    => $provieder->wallet + ($data->item_price - $commission)
                    ]);
                }
                $this->plusPoints($provieder->id, $data->item_price);
                $content = " تم اضافة " . ($data->item_price - $commission) . 'ريال' . " في رصيد مستحقاتك " . ' - ' . ' المنتج '. $productNameSP;
                $this->createNotification($content, $provieder->id);
                // End Provider
                // Start Sending Commission
                $sender_commission = $get_request->bill->shipping * PaymentSetting::first()->sender_commission / 100;
                $receipt->update([
                    'sender_commission' => PaymentSetting::first()->sender_commission
                ]);
                //  dd($sender_commission);
                if ($get_request->shipping_method_id == 1 || $get_request->shipping_method_id == 2) {
                    if($get_request->sender != null && \App\Models\GeneralInfo::findOrFail(1)->senders_status == 1) { // If Product sent by delegate
                        $client = Client::findOrFail($get_request->sender->id);
                        if ($get_request->payment_method_id == 2) {
                            $client->update([
                                'debt'    => $client->debt + $sender_commission
                            ]);
                        } else {
                            $client->update([
                                'wallet'    => $client->wallet + ($get_request->bill->shipping - $sender_commission)
                            ]);
                        }
                        $this->plusPoints($client->id, floor($get_request->bill->shipping));
                        $content = " تمت اضافة  ".floor($get_request->bill->shipping)."  نقطة لحسابك ". ' - ' . ' المنتج '. $productNameSP;
                        $this->createNotification($content, $client->id);
                    } else { // If Product sent by provider
                        if ($get_request->payment_method_id == 2) {
                            $provieder->update([
                                'debt'    => $provieder->debt + $sender_commission
                            ]);
                        } else {
                            $provieder->update([
                                'wallet'    => $provieder->wallet + ($get_request->bill->shipping - $sender_commission)
                            ]);
                        }
                        $this->plusPoints($provieder->id, floor($get_request->bill->shipping));
                        $content = " تمت اضافة  ".floor($get_request->bill->shipping)."  نقطة لحسابك ". ' - ' . ' المنتج '. $productNameSP;
                        $this->createNotification($content, $provieder->id);
                    }
                }
                // if ($get_request->shipping_method_id == 4) {
                $buyer = Client::findOrFail($receipt->client_id);
                if ($buyer->spasial_com != null && $buyer->spasial_com > 0) {
                    $total_price = (($receipt->total_price * $buyer->spasial_com) / 100);
                    $buyer->update([
                        'wallet' => $buyer->wallet + $total_price,
                    ]);
                    $content = " تم اضافة " . $total_price . 'ريال' . " في رصيد مستحقاتك " . ' - ' . ' المنتج ' . $productNameSP;
                    $this->createNotification($content, $buyer->id);
                    $this->plusPoints($buyer->id, $total_price);
                    $receipt->update([
                        'cashback_commission' => $total_price
                    ]);
                } else {
                    $receipt->update([
                        'cashback_commission' => PaymentSetting::first()->cashback_commission
                    ]);
                    $buyer->update([
                        'wallet' => $buyer->wallet + (($receipt->total_price * PaymentSetting::first()->cashback_commission) / 100),
                    ]);
                    $this->plusPoints($buyer->id, $receipt->total_price);
                    $content = " تم اضافة " . (($receipt->total_price * PaymentSetting::first()->cashback_commission) / 100) . 'ريال' . " في رصيد مستحقاتك " . ' - ' . ' المنتج ' . $productNameSP;
                    $this->createNotification($content, $buyer->id);
                }
                // }
            } // End Buy Product
        }

        $get_marketer = Client::where('ref', '=', $receipt->client->parent_ref)->first();

        if ($get_marketer != null) {
            $get_com = $receipt->total_price * PaymentSetting::first()->marketing_commission / 100;
            $total = $get_marketer->wallet + $get_com;
            $get_marketer->update([
                'wallet'    => $total
            ]);
            $content = " تم اضافة " . $get_com . ' ريال ' . " في رصيد مستحقاتك " . ' لأن عميل اشترى عن طريق كود دعوتك '. ' - ' . ' المنتج '. $productNameSP;
            $this->createNotification($content, $get_marketer->id);
            $receipt->update([
                'marketing_commission' => PaymentSetting::first()->cashback_commission
            ]);
        } else {
            $receipt->update([
                'marketing_commission' => 0
            ]);
        }

        if ($mainProduct != null && $clientAddress != null) {
            $productRequestsCollection = \App\Models\productRequestsCollection::with('buyer:id,name','provider:id,name', 'sender:id,name', 'product:id,name,main_image', 'bill', 'shipping_method', 'group')
                ->whereIn('id', json_decode($receipt->reqsIDs))->first();
            $provider_address       = Address::findOrFail($productRequestsCollection->branch_data_id);
            $api_key                = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJvcmdhbml6YXRpb25faWQiOiI2Mjk2ZTdhYTJmYjRhYTI5NmQ1NjExODQiLCJrZXkiOiIyMDIyLTA2LTA2VDExOjM5OjUzLjc4OVoiLCJpYXQiOjE2NTQ1MTU1OTN9.rokvHJL76PM2alEl_afnhx1iampAzNIdDpEOYqvOI1U';
            $api_key_test           = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJvcmdhbml6YXRpb25faWQiOiI2Mjk3MjkxNzkwZDZkOTY0NTE3MDU5OWIiLCJrZXkiOiIyMDIyLTA2LTAxVDA4OjU4OjUzLjcwMloiLCJpYXQiOjE2NTQwNzM5MzN9.7nthv4CuRF51VDTFZUo738N_irSN40v33aFkQFByPFI';
            $api_url                = 'https://app.redboxsa.com/api/business/v1/create-shipment';
            $api_url_test           = 'https://stage.redboxsa.com/api/business/v1/create-shipment';
            $response = Http::withHeaders([
                'Authorization' => $api_key_test,
            ])->post($api_url_test, [
                'reference'         => $receipt->reference_number,
                'sender_name'       => $mainProduct->client->name,
                'sender_email'      => $mainProduct->client->email,
                'sender_phone'      => $mainProduct->client->whatsapp_phone,
                'sender_address'    =>  'عنوان مستودع السلعة (warehouse address)' . '-  الشارع ' . $provider_address->street .' - ' .' القطاع ' . $provider_address->sector .' - ' .' رقم البناء ' . $provider_address->build_no .' - ' .' رقم الطابق ' . $provider_address->floor .' - ' .' رقم الوحده ' . $provider_address->unit_no .' - ' .' التفاصيل ' . $provider_address->details,
                'customer_name'     => $receipt->client->name,
                'customer_email'    => $receipt->client->email,
                'customer_phone'    => $receipt->client->whatsapp_phone,
                'customer_address'  => 'عنوان مستودع السلعة (warehouse address)' . ' الشارع ' . $provider_address->street .' - ' .' القطاع ' . $provider_address->sector .' - ' .' رقم البناء ' . $provider_address->build_no .' - ' .' رقم الطابق ' . $provider_address->floor .' - ' .' رقم الوحده ' . $provider_address->unit_no .' - ' .' التفاصيل ' . $provider_address->details  .
                    ' رقم هاتف التاجر ' . $mainProduct->client->whatsapp_phone .' البريد الالكتروني للتاجر ' . $mainProduct->client->email  .'--------'. ' عنوان المستلم (recipient address) '. ' الشارع ' . $clientAddress->street .' - ' .' القطاع ' . $clientAddress->sector .' - ' .' رقم البناء ' . $clientAddress->build_no .' - ' .' رقم الطابق ' . $clientAddress->floor .' - ' .' رقم الوحده ' . $clientAddress->unit_no .' - ' .' التفاصيل ' . $clientAddress->details ,
                'customer_city'     => $clientAddress->government->name,
                'dimension_unit'    => 'cm',
                'dimension_height'   => 90,
                'dimension_width'   => 90,
                'weight_unit'       => 'g',
                'weight_value'      => $wightShip,
                'cod_currency'      => 'SAR',
                'cod_amount'        => 0,
                'size'              => 'Small',
                'from_platform'     => 'Altaawws',
            ]);
            $receipt->update(['shipping_method_data' => $response->body()]);
            $readBoxData = Readbox::findOrFail(1);
            $readBoxData->update([
                'dues' => $readBoxData->readbox_cost + $readBoxData->dues
            ]);
        }


        $receipt->update(['status' => 2]);
        $this->hideModel();
        $this->alert('success', 'تم الموافقة على الطلب بنجاح', [
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
    public function reject() {
        receiptCollection::findOrFail($this->modelId)->update(['status' => 3]);
        $this->hideModel();
        $this->alert('success', 'تم رفض الطلب بنجاح', [
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
    public function hideModel() {
        $this->acceptFormVisible = false;
        $this->rejectFormVisible = false;
        $this->contentFormVisible = false;
    }

    public function all_users() {
        $bills = receiptCollection::with('client:id,email')->where('status', '=', 0)
            ->orWhere('status', '=', 1);

        $data = $this->searchForm;

        if ($this->searchForm != '') {

            $bills = $bills->where('reference_number', '=', $data);
        }

        return $bills->orderBy('created_at', 'DESC')->paginate(20);


    }

    public function debt_settlement() {
        $clients = Client::where('soft_deleted', '=', 0)->where('type', '=', 1)->orWhere('type', '=', 2)->orWhere('type', '=', 3)->get();
        foreach ($clients as $client) {
            if ($client->wallet >= $client->debt) {
                $total = $client->wallet - $client->debt;
                $client->update([
                    'wallet'    => $total,
                    'debt'      => 0
                ]);
            }else if ($client->debt > $client->wallet) {
                if ($client->wallet > 0) {
                    $total = $client->debt - $client->wallet;
                    $client->update([
                        'wallet'    => 0,
                        'debt'      => $total
                    ]);
                }

            }
        }
        $this->alert('success', 'تم تسوية الديون بنجاح', [
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

    public function render()
    {
        return view('livewire.admin.payment-page-collection', [
            'bills' => $this->all_users()
        ]);
    }
}
