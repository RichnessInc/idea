<?php

namespace App\Http\Livewire\Frontend;

use App\Mail\snedmessage;
use App\Mail\standardEmail;
use App\Models\billsCollection;
use App\Models\chatGroup;
use App\Models\Client;
use App\Models\Government;
use App\Models\Message;
use App\Models\ProductRequests;
use App\Models\receiptCollection;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ProfileCollection extends Component
{
    use WithPagination;
    use LivewireAlert;
    use \App\Http\Traits\notifications;
    public $billsSection            = true;
    public $buyRequestsSection      = false;
    public $nowRequestsSection      = false;
    public $myProductsSection       = false;
    public $BillIbfoVisible         = false;
    protected $listeners            = ['tabs' => 'tabsFunction'];
    public $changeRequestStatus     = false;
    public $billInform;
    public $modelId;
    public $info;
    public $reqs;
    public $request;
    public $productStatus;
    public $senderAcceptRequest;
    public $senderStatus;

    public function senderAcceptRequestFun() {
        $receipt = receiptCollection::with('requests')->findOrFail($this->modelId);
        foreach ($receipt->requests as $req) {
            $req->update([
                'sender_id' => Auth::guard('clients')->user()->id,
                'senderStatus'  => 1
            ]);
            chatGroup::where('collection_request_id', '=', $req->id)->update([
                'sender_id' => Auth::guard('clients')->user()->id
            ]);
            $group = chatGroup::where('collection_request_id', '=', $req->id)->first();

            Message::create([
                'message'   => "انضم المندوب الى المجموعة لمناقشة الطلب",
                'type'      => 0,
                'user_id'   => 1,
                'group_id'  => $group->id
            ]);
            $group = \App\Models\chatGroup::where('collection_request_id', '=', $req->id)->first();
            $buyer = Client::findOrFail($group->buyer_id);
            $provieder = Client::findOrFail($group->provieder_id);
            $sender = Client::findOrFail($group->sender_id);

            Mail::to($buyer->email)->send(new snedmessage($buyer->name, $group->id));
            Mail::to($provieder->email)->send(new snedmessage($provieder->name, $group->id));
            Mail::to($sender->email)->send(new snedmessage($provieder->name, $group->id));
            Mail::to('altaawus2020@gmail.com')->send(new snedmessage('الادمن', $group->id));
        }
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
        $receiptCollection = receiptCollection::findOrFail($id);
        $this->request = \App\Models\productRequestsCollection::with('shipping_method')->whereIn('id', json_decode($receiptCollection->reqsIDs))->first();
        $this->productStatus = $this->request->status;
    }
    public function changeRequestStatusFun() {
        $receiptCollection  = receiptCollection::findOrFail($this->modelId);
        $get_requests        = \App\Models\productRequestsCollection::with( 'product:id,name,slug,receipt_days', 'buyer:id,name,email')
            ->whereIn('id', json_decode($receiptCollection->reqsIDs))
            ->get();
        foreach ($get_requests as $get_request) {
            if ($this->productStatus == 1) {
                if ($get_request->product->receipt_days != null) {
                    $get_request->update([
                        'receipt_time'    => Carbon::now()->addDays($get_request->product->receipt_days),
                        'receipt_id'        => $receiptCollection->id
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
        }
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
    }

    public function showBillInfoModel($id) {
        $this->BillIbfoVisible = true;
        $this->billInform = billsCollection::with('product.client.address', 'product.client.government', 'product.client.country', 'address', 'address.country', 'address.government' )
            ->findOrFail(json_decode(receiptCollection::findOrFail($id)->bills_data)[0]->bill_id);
        $this->info = receiptCollection::findOrFail($id);
    }
    public function hideModel()
    {
        $this->changeRequestStatus = false;
        $this->BillIbfoVisible = false;
        $this->senderAcceptRequest = false;
    }
    public function all_bills() {
        $bills = \App\Models\receiptCollection::with('client:id,email')->where('client_id', '=', Auth::guard('clients')->user()->id);


        return $bills->orderBy('created_at', 'DESC')->paginate(10);


    }
    public function tabsFunction($tabName)
    {
        session()->put('profile_tab_tow', $tabName);
        if ($tabName == 'bills') {
            $this->billsSection = true;
            $this->buyRequestsSection = false;
            $this->nowRequestsSection = false;
            $this->myProductsSection = false;
        } elseif ($tabName == 'buyRequests') {
            $this->billsSection = false;
            $this->buyRequestsSection = true;
            $this->nowRequestsSection = false;
            $this->myProductsSection = false;

            ////////////////////////////////////
        } elseif ($tabName == 'nowRequests') {
            $this->billsSection = false;
            $this->buyRequestsSection = false;
            $this->nowRequestsSection = true;
            $this->myProductsSection = false;
        } elseif ($tabName == 'my-products') {
            $this->billsSection = false;
            $this->buyRequestsSection = false;
            $this->nowRequestsSection = false;
            $this->myProductsSection = true;
        }
    }
    public function goToGroup($id)  {
        return redirect()->route('frontend.group-chat', ['id' => $id]);
    }
    public function all_my_requests() {
        $productsRequests = \App\Models\receiptCollection::with('client:id,name')->where('client_id', '=', Auth::guard('clients')->user()->id);
        return $productsRequests->orderBy('created_at', 'DESC')->paginate(20);
    }
    public function productsRequestsProvieder() {
        if (Auth::guard('clients')->user()->type == 3) {
            $productsRequests = \App\Models\receiptCollection::with('client:id,name')
                ->whereHas('requests', function ($query) {
                    return $query->where('sender_id', '=', Auth::guard('clients')->user()->id);
                });
            return $productsRequests->orderBy('created_at', 'DESC')->paginate(20);
        } else {
            $productsRequests = \App\Models\receiptCollection::with('client:id,name')->where('provieder_id', '=', Auth::guard('clients')->user()->id);
            return $productsRequests->orderBy('created_at', 'DESC')->paginate(20);
        }

    }
    public function nowProductsRequests() {
         $client = Client::findOrFail(Auth::guard('clients')->user()->id);
            $areas = [];
            if ($client->serv_aval_in != null) {
                $get_areas = json_decode(Client::findOrFail(Auth::guard('clients')->user()->id)->serv_aval_in, true);

                foreach ($get_areas as $area) {
                    $areas[] = $area['id'];
                }
            }

        $productsRequests = \App\Models\receiptCollection::with('client:id,name')
        ->whereHas('requests', function ($query) use($areas) {
            return $query->where('status', '=', 1)
                ->where('senderStatus', '=', 0)
                ->where('sender_id', '=', null)
                ->whereIn('government_id',$areas)
                ->whereIn('branch_id',$areas);
        });
        return $productsRequests->orderBy('created_at', 'DESC')->paginate(20);
    }
    // requests
    public function render()
    {
        if (session()->has('profile_tab_tow')) {
            $this->tabsFunction(session()->get('profile_tab_tow'));
        }
        return view('livewire.frontend.profile-collection', [
            'bills' => $this->all_bills(),
            'my_products_requests'  => $this->all_my_requests(),
            'productsRequests'      => $this->productsRequestsProvieder(),
            'now_ProductsRequests'   => $this->nowProductsRequests(),
        ]);
    }
}
