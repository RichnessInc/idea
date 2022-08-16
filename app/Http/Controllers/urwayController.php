<?php

namespace App\Http\Controllers;

use App\Mail\CreatedRoom;
use App\Mail\mainEmail;
use App\Models\Address;
use App\Models\Bill;
use App\Models\billsCollection;
use App\Models\chatGroup;
use App\Models\Client;
use App\Models\Gift;
use App\Models\GiftTicket;
use App\Models\Government;
use App\Models\Message;
use App\Models\Package;
use App\Models\PackageBuyer;
use App\Models\Product;
use App\Models\ProductRequests;
use App\Models\productRequestsCollection;
use App\Models\Receipt;
use App\Models\receiptCollection;
use App\Models\Reesh;
use App\Models\singleRoom;
use App\Models\singleRoomMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class urwayController extends Controller
{

    public function urway_response() {
        $terminalId     = "altaawws";// Will be provided by URWAY
        $password       = "altaawws@123";// Will be provided by URWAY
        $key   = "78e449cb5a4829348279187ad370c60a5f5c77b85c63bc7eed26d279453653f3";// Will be provided by URWAY
        if ($_GET !== NULL) {
            $requestHash = "" . $_GET['TranId'] . "|" . $key . "|" . $_GET['ResponseCode'] . "|" . $_GET['amount'] . "";
            $txn_details1 = "" . $_GET['TrackId'] . "|" . $terminalId . "|" . $password . "|" . $key . "|" . $_GET['amount'] . "|SAR";
            $hash = hash('sha256', $requestHash);
            if ($hash === $_GET['responseHash']) {
                $txn_details1 = "" . $_GET['TrackId'] . "|" . $terminalId . "|" . $password . "|" . $key . "|" . $_GET['amount'] . "|SAR";
                //Secure check
                $requestHash1 = hash('sha256', $txn_details1);
                $apifields    = array(
                    'trackid' => $_GET['TrackId'],
                    'terminalId' => $terminalId,
                    'action' => '10',
                    'merchantIp' => "",
                    'password' => $password,
                    'currency' => "SAR",
                    'transid' => "",
                    'transid' => $_GET['TranId'],
                    'amount' => $_GET['amount'],
                    'udf5' => "",
                    'udf3' => "",
                    'udf4' => "",
                    'udf1' => "",
                    'udf2' => "",
                    'requestHash' => $requestHash1
                );
                $apifields_string = json_encode($apifields);

                $url = "https://payments-dev.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest";
                $ch  = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $apifields_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($apifields_string)
                ));
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

                //execute post
                $apiresult = curl_exec($ch);
                // print_r($apiresult);die;
                $urldecodeapi        = (json_decode($apiresult, true));
                $inquiryResponsecode = $urldecodeapi['responseCode'];
                $inquirystatus       = $urldecodeapi['result'];



                if ($_GET['Result'] === 'Successful'  && $_GET['ResponseCode']==='000') {

                    if($inquirystatus=='Successful' || $inquiryResponsecode=='000'){
                        $trackid = $_GET['TrackId'];
                        $responseCode = $_GET['ResponseCode'];
                        $amount = $_GET['amount'];

                        $bills          = [];
                        $this_bills     = Bill::where('client_id', '=', request()->get('client_id'))
                            ->where('status', '=', 0)->where('soft_deleted', '=', 0);
                        $client_data     = Client::findOrFail(request()->get('client_id'));
                        $total_price    = $this_bills->sum('total_price');
                        $total_shipping = $this_bills->sum('shipping');
                        $this_bills = $this_bills->get();
                        $client_id      = request()->get('client_id');
                        foreach ($this_bills as $bill) {
                            $bills[] = [
                                'bill_id'           => $bill->id,
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
                                    'payment_method_id'     => 3,
                                    'payment_status'        => 1,
                                    'shipping_method_id'    => json_decode($bill->shipping_data)->shipping_method_id,
                                    'government_id'         => $gov->id,
                                    'branch_id'         => $branch->government_id
                                ]);
                                if (json_decode($bill->shipping_data)->shipping_method_id == 4) {
                                    Mail::to(['jojoalmalki50@gmail.com', 'altaawus2020@gmail.com'])->send(new \App\Mail\mainEmail('Shipping Buy ReadBox', 'قام احد الاعضاء بالشحن عن طريق ReadBox'));
                                }
                                $bill->update(['product_request_id' => $req->id]);
                                $group = chatGroup::create([
                                    'buyer_id'  => $client_id,
                                    'provieder_id'  => $product->client_id,
                                    'request_id'    => $req->id,
                                ]);
                                Mail::to($provieder->email)->send(new CreatedRoom($provieder->name, $group->id));
                                Mail::to($client_data->email)->send(new CreatedRoom($client_data->name, $group->id));
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
                            }elseif (json_decode($bill->item_data)->model == Package::class ) {
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
                            'payment_data'      => json_encode([
                                'paymentId'     => $trackid
                            ]),
                            'client_id'         => request()->get('client_id'),
                            'paymentmethod'     => 'urway',
                            'paymentmethod_id'  => 6,
                            'status'            => 1,
                            'reference_number'  => rand(100, 999).'-'.rand(100, 999).'-'.rand(100, 999)
                        ]);
                        Mail::to(['altaawus2020@gmail.com', $client_data->email])->send(new mainEmail(config('app.name'), 'تم دفع فواتير الخزنة'));
                        Bill::where('client_id', '=', request()->get('client_id'))
                            ->where('status', '=', 0)->update(['status' => 1]);
                        session()->flash('message', 'تم دفع الفواتير بنجاح.');
                        return redirect('/');


                    }else {
                        echo "Something went wrong!!! Secure Check failed!!!!!!!";
                    }

                } else {
                    result();
                }
            } else {
                echo "Hash Mismatch!!!!!!!";

            }
        } else {

            echo "Something Went wrong!!!!!!!!!!!!";
        }
    }
    public function urway_response_tow() {
        $terminalId     = "altaawws";// Will be provided by URWAY
        $password       = "altaawws@123";// Will be provided by URWAY
        $key   = "78e449cb5a4829348279187ad370c60a5f5c77b85c63bc7eed26d279453653f3";// Will be provided by URWAY
        if ($_GET !== NULL) {
            $requestHash = "" . $_GET['TranId'] . "|" . $key . "|" . $_GET['ResponseCode'] . "|" . $_GET['amount'] . "";
            $txn_details1 = "" . $_GET['TrackId'] . "|" . $terminalId . "|" . $password . "|" . $key . "|" . $_GET['amount'] . "|SAR";
            $hash = hash('sha256', $requestHash);
            if ($hash === $_GET['responseHash']) {
                $txn_details1 = "" . $_GET['TrackId'] . "|" . $terminalId . "|" . $password . "|" . $key . "|" . $_GET['amount'] . "|SAR";
                //Secure check
                $requestHash1 = hash('sha256', $txn_details1);
                $apifields    = array(
                    'trackid' => $_GET['TrackId'],
                    'terminalId' => $terminalId,
                    'action' => '10',
                    'merchantIp' => "",
                    'password' => $password,
                    'currency' => "SAR",
                    'transid' => "",
                    'transid' => $_GET['TranId'],
                    'amount' => $_GET['amount'],
                    'udf5' => "",
                    'udf3' => "",
                    'udf4' => "",
                    'udf1' => "",
                    'udf2' => "",
                    'requestHash' => $requestHash1
                );
                $apifields_string = json_encode($apifields);

                $url = "https://payments-dev.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest";
                $ch  = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $apifields_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($apifields_string)
                ));
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

                //execute post
                $apiresult = curl_exec($ch);
                // print_r($apiresult);die;
                $urldecodeapi        = (json_decode($apiresult, true));
                $inquiryResponsecode = $urldecodeapi['responseCode'];
                $inquirystatus       = $urldecodeapi['result'];



                if ($_GET['Result'] === 'Successful'  && $_GET['ResponseCode']==='000') {

                    if($inquirystatus=='Successful' || $inquiryResponsecode=='000'){
                        $trackid = $_GET['TrackId'];
                        $responseCode = $_GET['ResponseCode'];
                        $amount = $_GET['amount'];

                        $bills          = [];

                        $total_shipping = billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
                            ->where('soft_deleted', '!=', 1)
                            ->where('status', '=', 0)->first()->shipping;
                        $this_bills     = billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
                            ->where('soft_deleted', '!=', 1)
                            ->where('status', '=', 0);
                        $total_price    = $this_bills->sum('item_price');

                        $client_data     = Client::findOrFail(request()->get('client_id'));
                        $this_bills = $this_bills->get();
                        $client_id      = request()->get('client_id');
                        $reqsIDs = [];
                        $proviederID = null;
                        foreach ($this_bills as $bill) {
                            $bills[] = [
                                'bill_id'           => $bill->id,
                                'item_data'         => $bill->item_data,
                                'item_price'        => $bill->item_price,
                                'shipping'          => $bill->shipping,
                                'total_price'       => $bill->total_price,
                                'reference_number'  => $bill->reference_number
                            ];
                            if(json_decode($bill->item_data)->model == Product::class) {
                                $product                    = Product::findOrFail( json_decode($bill->item_data)->product->id );
                                $provieder                  = Client::findOrFail( $product->client_id );
                                $proviederID                = $provieder->id;
                                $address                    = Address::findOrFail(json_decode($bill->shipping_data)->address_id);
                                $gov                        = Government::where('id', '=', $address->government_id)->first();
                                $branch                     = Address::findOrFail(json_decode($bill->shipping_data)->branch_id);
                                $req                        = productRequestsCollection::create([
                                    'buyer_id'              => $client_id,
                                    'provieder_id'          => $product->client_id,
                                    'product_id'            => json_decode($bill->item_data)->product->id,
                                    'payment_method_id'     => 3,
                                    'payment_status'        => 1,
                                    'shipping_method_id'    => json_decode($bill->shipping_data)->shipping_method_id,
                                    'government_id'         => $gov->id,
                                    'branch_id'         => $branch->government_id
                                ]);
                                $reqsIDs[] = $req->id;

                                if (json_decode($bill->shipping_data)->shipping_method_id == 4) {
                                    Mail::to(['jojoalmalki50@gmail.com', 'altaawus2020@gmail.com'])->send(new \App\Mail\mainEmail('Shipping Buy ReadBox', 'قام احد الاعضاء بالشحن عن طريق ReadBox'));
                                }
                                $bill->update(['product_request_id' => $req->id]);
                                $group = chatGroup::create([
                                    'buyer_id'  => $client_id,
                                    'provieder_id'  => $product->client_id,
                                    'collection_request_id'    => $req->id,
                                ]);
                                Mail::to($provieder->email)->send(new CreatedRoom($provieder->name, $group->id));
                                Mail::to($client_data->email)->send(new CreatedRoom($client_data->name, $group->id));
                                Mail::to('altaawus2020@gmail.com')->send(new CreatedRoom('الادمن', $group->id));
                                Message::create([
                                    'message'   => "تم انشاء المجموعة لمناقشة الطلب",
                                    'type'      => 0,
                                    'user_id'   => 1,
                                    'group_id'  => $group->id
                                ]);
                            }
                        }

                        receiptCollection::create([
                            'bills_data'        => json_encode($bills),
                            'total_price'       => $total_price,
                            'total_shipping'    => $total_shipping,
                            'payment_data'      => json_encode([
                                'paymentId'     => $trackid
                            ]),
                            'client_id'         => request()->get('client_id'),
                            'paymentmethod'     => 'urway',
                            'paymentmethod_id'  => 6,
                            'status'            => 1,
                            'reference_number'  => rand(100, 999).'-'.rand(100, 999).'-'.rand(100, 999),
                            'reqsIDs'           => json_encode($reqsIDs),
                            'provieder_id'      => $proviederID,
                        ]);
                        Mail::to(['altaawus2020@gmail.com', $client_data->email])->send(new mainEmail(config('app.name'), 'تم دفع فواتير الخزنة'));
                        billsCollection::where('client_id', '=', request()->get('client_id'))
                            ->where('status', '=', 0)->update(['status' => 1]);
                        session()->flash('message', 'تم دفع الفواتير بنجاح.');
                        return redirect('/');


                    }else {
                        echo "Something went wrong!!! Secure Check failed!!!!!!!";
                    }

                } else {
                    result();
                }
            } else {
                echo "Hash Mismatch!!!!!!!";

            }
        } else {

            echo "Something Went wrong!!!!!!!!!!!!";
        }
    }
}
