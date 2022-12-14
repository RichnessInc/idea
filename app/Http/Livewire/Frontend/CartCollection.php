<?php

namespace App\Http\Livewire\Frontend;

use App\Http\Traits\calculateCommission;
use App\Http\Traits\PayPalTrait;
use App\Http\Traits\PointsSystem;
use App\Mail\CreatedRoom;
use App\Mail\mainEmail;
use App\Models\Address;
use App\Models\Bill;
use App\Models\billsCollection;
use App\Models\chatGroup;
use App\Models\Client;
use App\Models\GeneralInfo;
use App\Models\Gift;
use App\Models\GiftTicket;
use App\Models\Government;
use App\Models\Message;
use App\Models\Package;
use App\Models\PackageBuyer;
use App\Models\paymentMethod;
use App\Models\Product;
use App\Models\productRequestsCollection;
use App\Models\receiptCollection;
use App\Models\Reesh;
use App\Models\singleRoom;
use App\Models\singleRoomMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class CartCollection extends Component
{
    use WithPagination, PayPalTrait;
    use LivewireAlert;
    use calculateCommission, PointsSystem;

    public $deleteFormVisible   = false;
    public $infoFormVisible     = false;
    public $ticketStatus        = false;
    public $ticketValue         = 0;
    public $billInfo            = [];
    public $billID;
    public $number;
    public $password;
    public $showPassword            = false;

    protected $listeners = ['paypalProcess' => 'paypalProcess'];

    public function showPasswordF() {
        if ($this->showPassword == true) {
            $this->showPassword = false;
        } else {
            $this->showPassword = true;
        }
    }
    public function confirmbillDelete($id) {
        $this->deleteFormVisible = true;
        $this->billID = $id;
    }
    function get_server_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    public function payWithUrway($price) {
// Information
        $total_shipping = billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('soft_deleted', '!=', 1)
            ->where('status', '=', 0)->first()->shipping;
        $this_bills     = billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('soft_deleted', '!=', 1)
            ->where('status', '=', 0);
        $total_price    = $this_bills->sum('item_price');


        $idorder        = 'PHP_' . rand(1, 1000);//Customer Order ID
        $terminalId     = "altaawws";// Will be provided by URWAY
        $password       = "altaawws@123";// Will be provided by URWAY
        $merchant_key   = "78e449cb5a4829348279187ad370c60a5f5c77b85c63bc7eed26d279453653f3";// Will be provided by URWAY
        $currencycode   = "SAR";
        $amount         = $total_price;
        $ipp            = $this->get_server_ip();
        // Generate Hash
        $txn_details    = $idorder.'|'.$terminalId.'|'.$password.'|'.$merchant_key.'|'.$amount.'|'.$currencycode;
        $hash           =hash('sha256', $txn_details);

//        dd(URL::to('testing-response'));
        $fields = array(
            'trackid' => $idorder,
            'terminalId' => $terminalId,
            'customerEmail' => 'customer@email.com',
            'action' => "1",  // action is always 1
            'merchantIp' =>$ipp,
            'password'=> $password,
            'currency' => $currencycode,
            'country'=>"SA",
            'amount' => $amount,
            "udf1"              =>"Test1",
            "udf2"              =>'https://altaawws.com/urway-response-tow?client_id='.Auth::guard('clients')->user()->id,//Response page URL
            "udf3"              =>"",
            "udf4"              =>"",
            "udf5"              =>"Test5",
            'requestHash' => $hash  //generated Hash
        );
        $data = json_encode($fields);
        $ch=curl_init('https://payments-dev.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest'); // Will be provided by URWAY
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $server_output =curl_exec($ch);
        //close connection
        curl_close($ch);
        $result = json_decode($server_output);
        if (!empty($result->payid) && !empty($result->targetUrl)) {
            $url = $result->targetUrl . '?paymentid=' .  $result->payid;
            return redirect()->away($url);//Redirect to Payment Page
        }else{
            Log::critical(json_encode($result));
        }
    }
    public function enterTicket() {
        $validatedData = $this->validate([
            'number'          => 'required',
            'password'          => 'required',
        ]);
        if ($this->number != null && $this->password != null ) {
            $ticket = GiftTicket::where('reference_number', '=', $this->number)->first();
            if ($ticket != null) {
                $bills          = [];
                $total_shipping = billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
                    ->where('soft_deleted', '!=', 1)
                    ->where('status', '=', 0)->first()->shipping;
                $this_bills     = billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
                    ->where('soft_deleted', '!=', 1)
                    ->where('status', '=', 0);
                $total_price    = $this_bills->sum('item_price');
                $this_bills = $this_bills->get();
                $client_id      = Auth::guard('clients')->user()->id;
                if ($ticket->value >= $total_price) {
                    if ($ticket->status == 0 && $ticket->paid == 1) {
                        if (Hash::check($this->password, $ticket->password)) {
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

                                if (json_decode($bill->item_data)->model == Gift::class || json_decode($bill->item_data)->model == Reesh::class) {
                                    $sec = (json_decode($bill->item_data)->model == Gift::class ? ' ?????????? ???? ' : ' ???????? ?????? ');
                                    $get_room_id    = singleRoom::where('client_id', '=', $client_id)->first()->id;
                                    singleRoomMessage::create([
                                        'client_id' => $client_id,
                                        'room_id'   => $get_room_id,
                                        'admin_id'  => 1,
                                        'from'      => 1,
                                        'message'   => '?????? ?????? ?????????? ' . $sec . ' ???? ?????????????? '
                                    ]);
                                } else if(json_decode($bill->item_data)->model == Product::class) {
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
                                        'payment_method_id'     => 5,
                                        'payment_status'        => 1,
                                        'shipping_method_id'    => json_decode($bill->shipping_data)->shipping_method_id,
                                        'government_id'         => $gov->id,
                                        'branch_id'             => $branch->government_id,
                                        'branch_data_id'        => $branch->id
                                    ]);
                                    $reqsIDs[] = $req->id;
                                    if (json_decode($bill->shipping_data)->shipping_method_id == 4) {
                                        Mail::to(['jojoalmalki50@gmail.com', 'altaawus2020@gmail.com'])->send(new \App\Mail\mainEmail('Shipping Buy ReadBox', '?????? ?????? ?????????????? ???????????? ???? ???????? ReadBox'));
                                    }
                                    $bill->update(['product_request_id' => $req->id]);
                                    $group = chatGroup::create([
                                        'buyer_id'  => $client_id,
                                        'provieder_id'  => $product->client_id,
                                        'collection_request_id'    => $req->id,
                                    ]);
                                    Mail::to($provieder->email)->send(new CreatedRoom($provieder->name, $group->id));
                                    Mail::to(Auth::guard('clients')->user()->email)->send(new CreatedRoom(Auth::guard('clients')->user()->name, $group->id));
                                    Mail::to('altaawus2020@gmail.com')->send(new CreatedRoom('????????????', $group->id));
                                    Message::create([
                                        'message'   => "???? ?????????? ???????????????? ?????????????? ??????????",
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
                                    Mail::to('altaawus2020@gmail.com')->send(new \App\Mail\mainEmail('Buy Package', '?????? ?????? ???????????? ?????????? ????????'));
                                }
                            }
                            receiptCollection::create([
                                'bills_data'        => json_encode($bills),
                                'total_price'       => $total_price,
                                'total_shipping'    => $total_shipping,
                                'payment_data'      => json_encode([]),
                                'client_id'         => Auth::guard('clients')->user()->id,
                                'paymentmethod'     => '?????????? ????????',
                                'paymentmethod_id'  => 5,
                                'status'            => 1,
                                'reference_number'  => rand(100, 999).'-'.rand(100, 999).'-'.rand(100, 999),
                                'reqsIDs'           => json_encode($reqsIDs),
                                'provieder_id'      => $proviederID,

                            ]);
                            $thisClient = Client::findOrFail(Auth::guard('clients')->user()->id);
                            $thisClient->update([
                                'wallet'    => $thisClient->wallet + ($ticket->value - $total_price)
                            ]);
                            billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
                                ->where('status', '=', 0)->update(['status' => 1]);
                            $ticket->update([
                                'status'    => 1
                            ]);
                            Mail::to(['altaawus2020@gmail.com', Auth::guard('clients')->user()->email])->send(new mainEmail(config('app.name'), '???? ?????? ???????????? ????????????'));
                            session()->flash('message', '???? ?????????? ?????????? ??????????.');
                            return redirect('/');
                        } else {
                            $this->alert('error', '???????????????? ??????????', [
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
                    } else {
                        $this->alert('error', '?????????????? ?????? ??????????', [
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
                } else {
                    $this->alert('error', '???????? ???????????????? ???????? ???? ???????? ??????????????', [
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
            } else {
                $this->alert('error', '???????????????? ??????????', [
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
        } else {
            $this->alert('error', '?????? ?????? ????????????????', [
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

    public function billInfo($id) {
        $this->infoFormVisible = true;
        $this->billID = $id;
        $data = billsCollection::with('address.country:id,name', 'address.government:id,name')->findOrFail($this->billID);
        if (json_decode($data->item_data)->model == Product::class) {
            $extra = json_decode($data->item_data)->extra;
            return $this->billInfo = [
                'name'          => json_decode($data->item_data)->product->name,
                'price'         => number_format(json_decode($data->item_data)->product->price) . ' SAR ',
                'receipt_days'  => json_decode($data->item_data)->product->receipt_days . ' ?????? ',
                'qty'           => json_decode($data->item_data)->product->qty,
                'country'       => $data->address->country->name,
                'government'    => $data->address->government->name,
                'extras'        => $extra
            ];
        }
    }

    public function destroy() {
        $bill = billsCollection::findOrFail($this->billID);
        $bill->update(['soft_deleted' => 1]);
        $this->hideModel();
        $this->alert('success', '???? ?????? ???????????????? ??????????', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('frontend.cart-collection');
    }

    public function hideModel() {

        $this->deleteFormVisible = false;
        $this->infoFormVisible     = false;


    }

    public function withPayPal($price) {
        $total_shipping = billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('soft_deleted', '!=', 1)
            ->where('status', '=', 0)->first()->shipping;
        $this_bills     = billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('soft_deleted', '!=', 1)
            ->where('status', '=', 0);
        $total_price    = $this_bills->sum('item_price');
        $usdValue = GeneralInfo::findOrFail(1)->currency;
        $total_price = ceil( $total_price / $usdValue);
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                env('PAYPALClientID'), env('PAYPALSecret')
            )
        );
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new \PayPal\Api\Amount();
        $amount->setTotal($total_price);
        $amount->setCurrency('USD');

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypal-redirect'))
            ->setCancelUrl(route('paypal-cancel'));

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($apiContext);
            return redirect()->away($payment->getApprovalLink());
        }
        catch (\PayPal\Exception\PayPalConnectionException $ex) {
            Log::emergency($ex->getData());
            return redirect('/');
        }
    }
    public function payAtHome($price) {
        $bills          = [];
        $total_shipping = billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('soft_deleted', '!=', 1)
            ->where('status', '=', 0)->first()->shipping;
        $this_bills     = billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('soft_deleted', '!=', 1)
            ->where('status', '=', 0);
        $total_price    = $this_bills->sum('item_price');
        $this_bills = $this_bills->get();
        $client_id      = Auth::guard('clients')->user()->id;
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
                $product   = Product::findOrFail( json_decode($bill->item_data)->product->id );
                $provieder   = Client::findOrFail( $product->client_id );
                $proviederID                = $provieder->id;
                $address                    = Address::findOrFail(json_decode($bill->shipping_data)->address_id);
                $gov                        = Government::where('id', '=', $address->government_id)->first();
                $branch                     = Address::findOrFail(json_decode($bill->shipping_data)->branch_id);

                $req = productRequestsCollection::create([
                    'buyer_id'          => $client_id,
                    'provieder_id'      => $product->client_id,
                    'product_id'        => json_decode($bill->item_data)->product->id,
                    'payment_method_id' => 2,
                    'payment_status'    => 0,
                    'government_id'     => $gov->id,
                    'shipping_method_id'=> json_decode($bill->shipping_data)->shipping_method_id,
                    'branch_id'             => $branch->government_id,
                    'branch_data_id'        => $branch->id,
                ]);
                $reqsIDs[] = $req->id;
                if (json_decode($bill->shipping_data)->shipping_method_id == 4) {
                    Mail::to(['jojoalmalki50@gmail.com', 'altaawus2020@gmail.com'])->send(new \App\Mail\mainEmail('Shipping Buy ReadBox', '?????? ?????? ?????????????? ???????????? ???? ???????? ReadBox'));
                }
                $bill->update(['product_request_id' => $req->id]);

                $group = chatGroup::create([
                    'buyer_id'  => $client_id,
                    'provieder_id'  => $product->client_id,
                    'collection_request_id'    => $req->id,
                ]);
                Mail::to($provieder->email)->send(new CreatedRoom($provieder->name, $group->id));
                Mail::to(Auth::guard('clients')->user()->email)->send(new CreatedRoom(Auth::guard('clients')->user()->name, $group->id));
                Mail::to('altaawus2020@gmail.com')->send(new CreatedRoom('????????????', $group->id));
                Message::create([
                    'message'   => "???? ?????????? ???????????????? ?????????????? ??????????",
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
            'client_id'         => Auth::guard('clients')->user()->id,
            'paymentmethod'     => '?????????? ?????? ????????????????',
            'paymentmethod_id'  => 2,
            'payment_data'      => json_encode([]),
            'reference_number'  => rand(100, 999).'-'.rand(100, 999).'-'.rand(100, 999),
            'reqsIDs'           => json_encode($reqsIDs),
            'provieder_id'      => $proviederID,
        ]);
        Mail::to(['altaawus2020@gmail.com', Auth::guard('clients')->user()->email])->send(new mainEmail(config('app.name'), '???? ?????? ???????????? ????????????'));
        billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('status', '=', 0)->update(['status' => 2]);
        session()->flash('message', '???? ?????????? ?????????? ??????????.');
        return redirect('/');
    }

    public function payWithWallet($price) {
        $bills          = [];
        $total_shipping = billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('soft_deleted', '!=', 1)
            ->where('status', '=', 0)->first()->shipping;
        $this_bills     = billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('soft_deleted', '!=', 1)
            ->where('status', '=', 0);
        $total_price    = $this_bills->sum('item_price');
        $reqsIDs = [];
        $proviederID = null;

        if (Auth::guard('clients')->user()->wallet >= $total_price) {
            $this_bills = $this_bills->get();
            $client_id      = Auth::guard('clients')->user()->id;
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
                        'payment_method_id'     => 4,
                        'payment_status'        => 1,
                        'shipping_method_id'    => json_decode($bill->shipping_data)->shipping_method_id,
                        'branch_id'             => $branch->government_id,
                        'branch_data_id'        => $branch->id,
                        'government_id'         => $gov->id
                    ]);
                    $reqsIDs[] = $req->id;
                    if (json_decode($bill->shipping_data)->shipping_method_id == 4) {
                        Mail::to(['jojoalmalki50@gmail.com', 'altaawus2020@gmail.com'])->send(new \App\Mail\mainEmail('Shipping Buy ReadBox', '?????? ?????? ?????????????? ???????????? ???? ???????? ReadBox'));
                    }
                    $bill->update(['product_request_id' => $req->id]);
                    $group = chatGroup::create([
                        'buyer_id'  => $client_id,
                        'provieder_id'  => $product->client_id,
                        'collection_request_id'    => $req->id,
                    ]);
                    Mail::to($provieder->email)->send(new CreatedRoom($provieder->name, $group->id));
                    Mail::to(Auth::guard('clients')->user()->email)->send(new CreatedRoom(Auth::guard('clients')->user()->name, $group->id));
                    Mail::to('altaawus2020@gmail.com')->send(new CreatedRoom('????????????', $group->id));
                    Message::create([
                        'message'   => "???? ?????????? ???????????????? ?????????????? ??????????",
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
                'payment_data'      => json_encode([]),
                'client_id'         => Auth::guard('clients')->user()->id,
                'paymentmethod'     => '?????????? ???? ???????? ????????????',
                'paymentmethod_id'  => 4,
                'status'            => 1,
                'reference_number'  => rand(100, 999).'-'.rand(100, 999).'-'.rand(100, 999),
                'reqsIDs'           => json_encode($reqsIDs),
                'provieder_id'      => $proviederID,
            ]);
            $thisClient = Client::findOrFail(Auth::guard('clients')->user()->id);
            $thisClient->update([
                'wallet'    => $thisClient->wallet - $total_price
            ]);
            Mail::to(['altaawus2020@gmail.com', Auth::guard('clients')->user()->email])->send(new mainEmail(config('app.name'), '???? ?????? ???????????? ????????????'));
            billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
                ->where('status', '=', 0)->update(['status' => 1]);
            session()->flash('message', '???? ?????????? ?????????? ??????????.');
            return redirect('/');
        }    else {
            return redirect('/');
        }
    }
    public function paypalProcess($responseData) {
        $bills          = [];
        $this_bills     = billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('soft_deleted', '!=', 1)
            ->where('status', '=', 0);

        $total_shipping = billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('soft_deleted', '!=', 1)
            ->where('status', '=', 0)->first()->shipping;
        $total_price    = $this_bills->sum('item_price');
        $this_bills     = $this_bills->get();
        $client_id      = Auth::guard('clients')->user()->id;
        $reqsIDs        = [];
        $proviederID    = null;
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
                $branch                     = Address::findOrFail(json_decode($bill->shipping_data)->branch_id);
                $gov                        = Government::where('id', '=', $address->government_id)->first();
                $req                        = productRequestsCollection::create([
                    'buyer_id'              => $client_id,
                    'provieder_id'          => $product->client_id,
                    'product_id'            => json_decode($bill->item_data)->product->id,
                    'payment_method_id'     => 1,
                    'payment_status'        => 1,
                    'shipping_method_id'    => json_decode($bill->shipping_data)->shipping_method_id,
                    'government_id'         => $gov->id,
                    'branch_id'         => $branch->government_id,
                    'branch_data_id'        => $branch->id
                ]);
                $reqsIDs[] = $req->id;
                if (json_decode($bill->shipping_data)->shipping_method_id == 4) {
                    Mail::to(['jojoalmalki50@gmail.com', 'altaawus2020@gmail.com'])->send(new \App\Mail\mainEmail('Shipping Buy ReadBox', '?????? ?????? ?????????????? ???????????? ???? ???????? ReadBox'));
                }
                $bill->update(['product_request_id' => $req->id]);
                $group = chatGroup::create([
                    'buyer_id'  => $client_id,
                    'provieder_id'  => $product->client_id,
                    'collection_request_id'    => $req->id,
                ]);
                Mail::to($provieder->email)->send(new CreatedRoom($provieder->name, $group->id));
                Mail::to(Auth::guard('clients')->user()->email)->send(new CreatedRoom(Auth::guard('clients')->user()->name, $group->id));
                Mail::to('altaawus2020@gmail.com')->send(new CreatedRoom('????????????', $group->id));
                Message::create([
                    'message'   => "???? ?????????? ???????????????? ?????????????? ??????????",
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
            'payment_data'      => json_encode($responseData),
            'client_id'         => Auth::guard('clients')->user()->id,
            'paymentmethod'     => 'paypal',
            'paymentmethod_id'  => 1,
            'status'            => 1,
            'reference_number'  => rand(100, 999).'-'.rand(100, 999).'-'.rand(100, 999),
            'reqsIDs'           => json_encode($reqsIDs),
            'provieder_id'      => $proviederID,
        ]);
        Mail::to(['altaawus2020@gmail.com', Auth::guard('clients')->user()->email])->send(new mainEmail(config('app.name'), '???? ?????? ???????????? ????????????'));
        billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('status', '=', 0)->update(['status' => 1]);
        session()->flash('message', '???? ?????? ???????????????? ??????????.');

        return redirect('/');
    }
    public function render()
    {
        $hasTicket = false;
        $bills = billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('status', '=', 0)
            ->where('soft_deleted', '!=', 1);
        if ($bills->count() > 0) {
            $shipping =  billsCollection::where('client_id', '=', Auth::guard('clients')->user()->id)
                ->where('status', '=', 0)
                ->where('soft_deleted', '!=', 1)->first()->shipping;
        } else {
            $shipping =  0;
        }

        $total =  $bills->sum('item_price') + $shipping;
        $bills =  $bills->get();

        foreach ($bills as $bill) {
            if(json_decode($bill->shipping_data)->shipping_method_id != 10) {
                $hasTicket = true;
            }
        }

        if ($hasTicket == true) {
            $paymentMethods = paymentMethod::where('id', '!=', 2)->get();
        } else {
            $paymentMethods = paymentMethod::get();
        }



        return view('livewire.frontend.cart-collection', [
            'bills' =>  $bills,
            'shipping' =>  $shipping,
            'total' =>  $total,
            'paymentmethods'   => $paymentMethods,
        ]);
    }
}
