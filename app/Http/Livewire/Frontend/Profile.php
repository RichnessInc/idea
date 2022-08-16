<?php

namespace App\Http\Livewire\Frontend;

use App\Http\Traits\BillTrait;
use App\Mail\CreatedRoom;
use App\Mail\OrderShipped;
use App\Mail\snedmessage;
use App\Mail\standardEmail;
use App\Models\Address;
use App\Models\Bill;
use App\Models\chatGroup;
use App\Models\Client;
use App\Models\Country;
use App\Models\Government;
use App\Models\Message;
use App\Models\Package;
use App\Models\PaymentSetting;
use App\Models\Product;
use App\Models\productExtra;
use App\Models\ProductRequests;
use App\Models\ProductsCategory;
use App\Models\Receipt;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Http\Traits\notifications;

class Profile extends Component
{
    use WithFileUploads, WithPagination, LivewireAlert, BillTrait, notifications;

    public $createAddressVisible = false;
    public $deleteProductVisible = false;
    public $ProductExtraVisible = false;
    public $changeRequestStatus = false;
    public $BillVisible = false;
    public $searchForm = '';
    public $street;
    public $sector;
    public $build_no;
    public $floor;
    public $modelId;
    public $country_id;
    public $government_id;
    public $unit_no;
    public $details;
    public $governorates;
    public $slug;
    public $add_service_available;
    public $shift_from;
    public $shift_to;

    /////////////////////
    public $addressSection = true;
    public $infomationSection = false;
    public $billsSection = false;
    public $salseSection = false;
    public $debtSection = false;
    public $walletSection = false;
    public $buyRequestsSection = false;
    public $backRequestsSection = false;
    public $pastRequestSection = false;
    public $nowRequestsSection = false;
    public $myProductsSection = false;
    //////////////////////////////////////
    protected $listeners = ['tabs' => 'tabsFunction'];
    //////////////////////////////////////////////////
    public $name;
    public $whatsapp_phone;
    public $email;
    public $oldpassword;
    public $password;
    public $repassword;
    public $request;
    /////////////////////////////////////////////////////////////
    ///
    public $productname;
    public $category_id;
    public $spare_phone;
    public $desc;
    public $wight;
    public $width;
    public $height;
    public $price;
    public $aval_count;
    public $main_image;
    public $images;
    public $tags;
    public $tagsArr = [];
    public $status;
    public $receipt_days;
    public $images_names;
    public $image_name;
    public $extras;
    /////////////////////////////////////////////////////////////
    ///
    public $billInfo;
    public $reqs;
    public $productStatus;
    public $senderStatus;
    public $senderAcceptRequest = false;
    public $updateAddressVisible = false;
    public $deleteAddressVisible = false;
    public $gps;
    public $BillIbfoVisible = false;
    public $clientUpdateFormVisible = false;
    public $billInform;

    public $blockProductStatusVisible = false;
    public $onProductStatusVisible = false;
    public $productID;
    public $showPassword            = false;

    public $addressBranchVisible = false;
    public $addressNormalVisible = false;

    public function ComfirmBranchAddressModel($id) {
        $this->addressBranchVisible = true;
        $this->modelId = $id;
    }
    public function ComfirmNormalAddressModel($id) {
        $this->addressNormalVisible = true;
        $this->modelId = $id;
    }
    public function ComfirmBranchAddressFun() {
        Address::findOrFail($this->modelId)->update(['branch' => 1]);
        $this->hideModel();
        $this->alert('success', 'تم بنجاح', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
            'text' => null,
            'confirmButtonText' => 'Ok',
            'cancelButtonText' => 'Cancel',
            'showCancelButton' => false,
            'showConfirmButton' => false,
        ]);
    }
    public function ComfirmNormalAddressFun() {
        Address::findOrFail($this->modelId)->update(['branch' => 0]);
        $this->hideModel();
        $this->alert('success', 'تم بنجاح', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
            'text' => null,
            'confirmButtonText' => 'Ok',
            'cancelButtonText' => 'Cancel',
            'showCancelButton' => false,
            'showConfirmButton' => false,
        ]);
    }

    /////////////////////////////////////////////////////////////
    ///

    public function showPasswordF() {
        if ($this->showPassword == true) {
            $this->showPassword = false;
        } else {
            $this->showPassword = true;
        }
    }
    public function blockProductStatusModel($id) {
        $this->productID = $id;
        $this->blockProductStatusVisible = true;
    }
    public function onProductStatusModel($id) {
        $this->productID = $id;
        $this->onProductStatusVisible = true;

    }
    public function blockProductStatusFun() {
        Product::findOrFail($this->productID)->update(['status' => 0]);
        $this->alert('success', 'تم بنجاح', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
            'text' => null,
            'confirmButtonText' => 'Ok',
            'cancelButtonText' => 'Cancel',
            'showCancelButton' => false,
            'showConfirmButton' => false,
        ]);
        $this->hideModel();
    }
    public function onProductStatusFun() {
        Product::findOrFail($this->productID)->update(['status' => 1]);
        $this->alert('success', 'تم بنجاح', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
            'text' => null,
            'confirmButtonText' => 'Ok',
            'cancelButtonText' => 'Cancel',
            'showCancelButton' => false,
            'showConfirmButton' => false,
        ]);
        $this->hideModel();
    }
    public function updateInformationModel() {
        $this->clientUpdateFormVisible = true;
        $this->name = Auth::guard('clients')->user()->name;
        $this->whatsapp_phone = Auth::guard('clients')->user()->whatsapp_phone;
        $this->email = Auth::guard('clients')->user()->email;
        $this->shift_from = Auth::guard('clients')->user()->shift_from;
        $this->shift_to = Auth::guard('clients')->user()->shift_to;
        $this->spare_phone = Auth::guard('clients')->user()->spare_phone;
    }
    public function showBillInfoModel($id) {
        $this->BillIbfoVisible = true;
        $this->billInform = Bill::with('product.client.address', 'product.client.government', 'product.client.country', 'address', 'address.country', 'address.government' )->findOrFail($id);
    }

    public function add_tag() {
        $this->tagsArr[] = $this->tags;
        $this->tags = null;
    }
    public function showBillModel($id)
    {
        $this->BillVisible = true;
        $this->billInfo = Receipt::findOrFail($id)->bills_data;
    }

    public function updateInformation () {
        if ($this->password != null) {
            if (Hash::check($this->oldpassword, Auth::guard('clients')->user()->password)) {
                if ($this->password == $this->repassword) {
                    $password = ['password' => Hash::make($this->password)];
                } else {
                    $this->alert('error', 'كلمة المرور غير متطابقة', [
                        'position' => 'center',
                        'timer' => 3000,
                        'toast' => true,
                        'text' => null,
                        'confirmButtonText' => 'Ok',
                        'cancelButtonText' => 'Cancel',
                        'showCancelButton' => false,
                        'showConfirmButton' => false,
                    ]);
                }
            } else {
                $this->alert('error', 'كلمة المرور غير صحيحية', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => true,
                    'text' => null,
                    'confirmButtonText' => 'Ok',
                    'cancelButtonText' => 'Cancel',
                    'showCancelButton' => false,
                    'showConfirmButton' => false,
                ]);
            }
        } else {
            $password = [];
        }

            Client::where('id', '=', Auth::guard('clients')->user()->id)->update([
            'name'              => $this->name,
            'email'             => $this->email,
            'whatsapp_phone'    => $this->whatsapp_phone,
            'shift_from'        => $this->shift_from,
            'shift_to'          => $this->shift_to,
            'spare_phone'       => $this->spare_phone,


        ]+$password);
        $this->hideModel();
        $this->alert('success', 'تم بنجاح', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
            'text' => null,
            'confirmButtonText' => 'Ok',
            'cancelButtonText' => 'Cancel',
            'showCancelButton' => false,
            'showConfirmButton' => false,
        ]);
    }

    public function tabsFunction($tabName)
    {
        session()->put('profile_tab', $tabName);
        if ($tabName == 'address') {
            $this->addressSection = true;
            $this->infomationSection = false;
            $this->billsSection = false;
            $this->salseSection = false;
            $this->debtSection = false;
            $this->walletSection = false;
            $this->buyRequestsSection = false;
            $this->backRequestsSection = false;
            $this->pastRequestSection = false;
            $this->nowRequestsSection = false;
            $this->myProductsSection = false;
        } elseif ($tabName == 'infomation') {
            $this->addressSection = false;
            $this->infomationSection = true;
            $this->billsSection = false;
            $this->salseSection = false;
            $this->debtSection = false;
            $this->walletSection = false;
            $this->buyRequestsSection = false;
            $this->backRequestsSection = false;
            $this->pastRequestSection = false;
            $this->nowRequestsSection = false;
            $this->myProductsSection = false;
            ////////////////////////////////////

            ///////////////////////////////////////
        } elseif ($tabName == 'bills') {
            $this->addressSection = false;
            $this->infomationSection = false;
            $this->billsSection = true;
            $this->salseSection = false;
            $this->debtSection = false;
            $this->walletSection = false;
            $this->buyRequestsSection = false;
            $this->backRequestsSection = false;
            $this->pastRequestSection = false;
            $this->nowRequestsSection = false;
            $this->myProductsSection = false;
        } elseif ($tabName == 'salse') {
            $this->addressSection = false;
            $this->infomationSection = false;
            $this->billsSection = false;
            $this->salseSection = true;
            $this->debtSection = false;
            $this->walletSection = false;
            $this->buyRequestsSection = false;
            $this->backRequestsSection = false;
            $this->pastRequestSection = false;
            $this->nowRequestsSection = false;
            $this->myProductsSection = false;
        } elseif ($tabName == 'debt') {
            $this->addressSection = false;
            $this->infomationSection = false;
            $this->billsSection = false;
            $this->salseSection = false;
            $this->debtSection = true;
            $this->walletSection = false;
            $this->buyRequestsSection = false;
            $this->backRequestsSection = false;
            $this->pastRequestSection = false;
            $this->nowRequestsSection = false;
            $this->myProductsSection = false;
        } elseif ($tabName == 'wallet') {
            $this->addressSection = false;
            $this->infomationSection = false;
            $this->billsSection = false;
            $this->salseSection = false;
            $this->debtSection = false;
            $this->walletSection = true;
            $this->buyRequestsSection = false;
            $this->backRequestsSection = false;
            $this->pastRequestSection = false;
            $this->nowRequestsSection = false;
            $this->myProductsSection = false;
        } elseif ($tabName == 'buyRequests') {
            $this->addressSection = false;
            $this->infomationSection = false;
            $this->billsSection = false;
            $this->salseSection = false;
            $this->debtSection = false;
            $this->walletSection = false;
            $this->buyRequestsSection = true;
            $this->backRequestsSection = false;
            $this->pastRequestSection = false;
            $this->nowRequestsSection = false;
            $this->myProductsSection = false;

            ////////////////////////////////////
        } elseif ($tabName == 'backRequests') {
            $this->addressSection = false;
            $this->infomationSection = false;
            $this->billsSection = false;
            $this->salseSection = false;
            $this->debtSection = false;
            $this->walletSection = false;
            $this->buyRequestsSection = false;
            $this->backRequestsSection = true;
            $this->pastRequestSection = false;
            $this->nowRequestsSection = false;
            $this->myProductsSection = false;
        } elseif ($tabName == 'pastRequest') {
            $this->addressSection = false;
            $this->infomationSection = false;
            $this->billsSection = false;
            $this->salseSection = false;
            $this->debtSection = false;
            $this->walletSection = false;
            $this->buyRequestsSection = false;
            $this->backRequestsSection = false;
            $this->pastRequestSection = true;
            $this->nowRequestsSection = false;
            $this->myProductsSection = false;
        } elseif ($tabName == 'nowRequests') {
            $this->addressSection = false;
            $this->infomationSection = false;
            $this->billsSection = false;
            $this->salseSection = false;
            $this->debtSection = false;
            $this->walletSection = false;
            $this->buyRequestsSection = false;
            $this->backRequestsSection = false;
            $this->pastRequestSection = false;
            $this->nowRequestsSection = true;
            $this->myProductsSection = false;
        } elseif ($tabName == 'my-products') {
            $this->addressSection = false;
            $this->infomationSection = false;
            $this->billsSection = false;
            $this->salseSection = false;
            $this->debtSection = false;
            $this->walletSection = false;
            $this->buyRequestsSection = false;
            $this->backRequestsSection = false;
            $this->pastRequestSection = false;
            $this->nowRequestsSection = false;
            $this->myProductsSection = true;
        }
    }

    public function country_change()
    {
        $this->governorates = Government::where('country_id', '=', $this->country_id)->where('soft_deleted', '=', 0)->get();
    }

    public function createAddressModel()
    {
        $this->resetAddressFormDate();
        $this->createAddressVisible = true;
    }
    public function ComfirmUpdateAddressModel($id)
    {
        $this->modelId = $id;
        $data = Address::findOrFail($this->modelId);
        $this->government_id    = $data->government_id;
        $this->country_id       = $data->country_id;
        $this->street           = $data->street;
        $this->build_no         = $data->build_no;
        $this->sector           = $data->sector;
        $this->floor            = $data->floor;
        $this->unit_no          = $data->unit_no;
        $this->details          = $data->details;
        $this->gps              = $data->gps;
        $this->updateAddressVisible = true;
    }

    public function updateAddressModel()
    {
        $validatedData = $this->validate([
            'government_id' => 'required|numeric',
            'country_id' => 'required|numeric',
            //////////////////////////////////////////////////////////////
            'street' => 'required|string|max:255',
            'build_no' => 'required|numeric',
            'sector' => 'required|string|max:255',
            'floor' => 'required|numeric',
            'unit_no' => 'required|numeric',
            'details' => 'required|string|max:255',
        ]);
        $data = [
            'government_id' => $this->government_id,
            'country_id'    => $this->country_id,
            'street'        => $this->street,
            'build_no'      => $this->build_no,
            'sector'        => $this->sector,
            'floor'         => $this->floor,
            'unit_no'       => $this->unit_no,
            'details'       => $this->details,
            'gps'           => $this->gps
        ];
        $add = Address::findOrFail($this->modelId);
        $add->update($data);
        if (Auth::guard('clients')->user()->address_id == $add->id) {
            Client::findOrFail(Auth::guard('clients')->user()->id)->update([
                'government_id' => $this->government_id,
                'country_id'    => $this->country_id,
            ]);
        }

        $this->resetAddressFormDate();
        $this->hideModel();
        $this->alert('success', 'تم تعديل العنوان بنجاح', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
            'text' => null,
            'confirmButtonText' => 'Ok',
            'cancelButtonText' => 'Cancel',
            'showCancelButton' => false,
            'showConfirmButton' => false,
        ]);

    }

    public function showProductExtrasModel($id)
    {
        $this->ProductExtraVisible = true;
        $this->modelId = $id;
        $this->extras = productExtra::where('product_id', '=', $id)->where('soft_deleted', '=', 0)->get();
    }

    public function storeAddress()
    {
        $validatedData = $this->validate([
            'government_id' => 'required|numeric',
            'country_id' => 'required|numeric',
            //////////////////////////////////////////////////////////////
            'street' => 'required|string|max:255',
            'build_no' => 'required|numeric',
            'sector' => 'required|string|max:255',
            'floor' => 'required|numeric',
            'unit_no' => 'required|numeric',
            'details' => 'required|string|max:255',
        ]);
        $data = [
            'government_id' => $this->government_id,
            'country_id'    => $this->country_id,
            'street'        => $this->street,
            'build_no'      => $this->build_no,
            'sector'        => $this->sector,
            'floor'         => $this->floor,
            'unit_no'       => $this->unit_no,
            'details'       => $this->details,
            'gps'           => $this->gps
        ];
        Address::create($data + ['client_id' => Auth::guard('clients')->user()->id]);
        $this->resetAddressFormDate();
        $this->hideModel();
        $this->alert('success', 'تم اضافة العنوان بنجاح', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
            'text' => null,
            'confirmButtonText' => 'Ok',
            'cancelButtonText' => 'Cancel',
            'showCancelButton' => false,
            'showConfirmButton' => false,
        ]);
    }
    public function resetAddressFormDate()
    {
        $this->street = null;
        $this->sector = null;
        $this->build_no = null;
        $this->floor = null;
        $this->government_id = null;
        $this->country_id = null;
        $this->unit_no = null;
        $this->details = null;
        $this->governorates = null;
        $this->gps = null;
    }
    public function hideModel()
    {
        $this->deleteAddressVisible     = false;
        $this->addressBranchVisible     = false;
        $this->addressNormalVisible     = false;
        $this->createAddressVisible     = false;
        $this->deleteProductVisible     = false;
        $this->ProductExtraVisible      = false;
        $this->BillVisible              = false;
        $this->changeRequestStatus      = false;
        $this->senderAcceptRequest      = false;
        $this->BillIbfoVisible          = false;
        $this->updateAddressVisible     = false;
        $this->clientUpdateFormVisible  = false;
        $this->blockProductStatusVisible       = false;
        $this->onProductStatusVisible          = false;
    }
    public function getAddress()
    {
        return Address::with('country', 'government')->where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('status', '=', 1)
            ->orderBy('created_at', 'DESC')
            ->get();
    }
    public function ConfermdeleteAddress($id)
    {
        $this->modelId = $id;
        $this->deleteAddressVisible = true;
    }
    public function deleteAddress()
    {   Address::findOrFail($this->modelId)->update([
            'status' => 0
        ]);
        $this->hideModel();
        $this->alert('success', 'تم حذف العنوان بنجاح', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
            'text' => null,
            'confirmButtonText' => 'Ok',
            'cancelButtonText' => 'Cancel',
            'showCancelButton' => false,
            'showConfirmButton' => false,
        ]);

    }
    public function confirmUserProductDelete($id)
    {
        $this->deleteProductVisible = true;
        $this->modelId = $id;
    }


    public function destroyProduct()
    {
        $pro = Product::with('extras')->findOrFail($this->modelId);
        if ($pro->extras != null) {
            foreach ($pro->extras as $extra) {
                if(File::exists(public_path('uploads/'.$extra->main_image))){
                    File::delete(public_path('uploads/'.$extra->main_image));
                }
            }
        }
        if ($pro->main_image != null) {
            if(File::exists(public_path('uploads/'.$pro->main_image))){
                File::delete(public_path('uploads/'.$pro->main_image));
            }
        }
        if ($pro->images != null) {
            foreach (explode(',', $pro->images) as $img) {
                if(File::exists(public_path('uploads/'.$img))){
                    File::delete(public_path('uploads/'.$img));
                }
            }
        }

        $pro->update(['soft_deleted' => 1]);
        $this->hideModel();
        $this->alert('success', 'تم حذف المنتج بنجاح', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
            'text' => null,
            'confirmButtonText' => 'Ok',
            'cancelButtonText' => 'Cancel',
            'showCancelButton' => false,
            'showConfirmButton' => false,
        ]);
    }

    public function editRequestStatus($id)
    {
        $this->changeRequestStatus = true;
        $this->modelId = $id;
        $this->reqs = ProductRequests::with('bill')->findOrFail($this->modelId);
        $this->request = ProductRequests::with('shipping_method')->findOrFail($this->modelId);
        $this->productStatus = $this->reqs->status;
        $this->reqs = $this->reqs->bill;
    }

    public function goToGroup($id)  {
        return redirect()->route('frontend.group-chat', ['id' => $id]);
    }

    public function changeRequestStatusFun() {
        $get_request = ProductRequests::with( 'product:id,name,slug,receipt_days', 'buyer:id,name,email')->findOrFail($this->modelId);
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

    }

    public function add_service_available_in() {
        $array  = [];
        $gov    = Government::findOrFail($this->government_id);
        $client = Client::findOrFail(Auth::guard('clients')->user()->id);
        if ($client->serv_aval_in != null) {
            $array = json_decode($client->serv_aval_in, true);

            if (!array_key_exists($gov->id, $array)) {
                $item = [
                    'id'    => $gov->id,
                    'title' => $gov->name,
                ];
                $array[$gov->id] = $item;
            }
        } else {
            $item = [
                'id'    => $gov->id,
                'title' => $gov->name,
            ];
            $array[$gov->id] = $item;
        }

        Client::findOrFail(Auth::guard('clients')->user()->id)->update([
            'serv_aval_in'  => json_encode($array)
        ]);

        //
        $this->alert('success', 'تم تعديل البيانات بنجاح', [
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

    public function delete_area($id) {
        $client = Client::findOrFail(Auth::guard('clients')->user()->id);
        $array = json_decode($client->serv_aval_in, true);
        unset($array[$id]);
        $client->update([
            'serv_aval_in'  => json_encode($array)
        ]);
        $this->alert('success', 'تم تعديل البيانات  بنجاح', [
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

    public function senderAcceptRequestFun() {
        $req = ProductRequests::findOrFail($this->modelId);
        if ($req->sender_id == null) {
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
        } else {
            $this->alert('error', 'تم قبول الطلب من قبل', [
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

    public function render()
    {
        if (session()->has('profile_tab')) {
            $this->tabsFunction(session()->get('profile_tab'));
        }

        if (Auth::guard('clients')->user()->type == 1 || Auth::guard('clients')->user()->type == 2) {
            $productsRequests = ProductRequests::with('sender:id,name', 'buyer:id,name', 'product:id,name,main_image', 'bill', 'shipping_method', 'group')->where('soft_deleted', '=', 0)
                ->where('provieder_id', '=', Auth::guard('clients')->user()->id)
                ->orderBy('created_at', 'DESC')
                ->paginate(20);
            $hasBranches = (Address::with('government')->where('branch', '=', 1)
                ->where('client_id','=', Auth::guard('clients')->user()->id)
                ->first() != null ? true : false) ;
        } elseif(Auth::guard('clients')->user()->type == 3) {
            $hasBranches = false;
            $productsRequests = ProductRequests::with('sender:id,name', 'buyer:id,name', 'product:id,name,main_image', 'bill', 'shipping_method', 'group')->where('soft_deleted', '=', 0)
                ->where('sender_id', '=', Auth::guard('clients')->user()->id)
                ->orderBy('created_at', 'DESC')
                ->paginate(20);
        } else {
            $hasBranches = false;
            $productsRequests = null;
        }

        if(Auth::guard('clients')->user()->type == 3) {
            $client = Client::findOrFail(Auth::guard('clients')->user()->id);
            $areas = [];
            if ($client->serv_aval_in != null) {
               $get_areas = json_decode(Client::findOrFail(Auth::guard('clients')->user()->id)->serv_aval_in, true);

               foreach ($get_areas as $area) {
                   $areas[] = $area['id'];
               }
           }
            $nowProductsRequests = ProductRequests::with('provider:id,name', 'buyer:id,name', 'product:id,name,main_image', 'bill', 'shipping_method', 'group')->where('soft_deleted', '=', 0)


                ->where('status', '=', 1)
                ->where('senderStatus', '=', 0)
                ->where('sender_id', '=', null)
                ->whereIn('government_id',$areas)
                ->whereIn('branch_id',$areas)
                ->orderBy('created_at', 'DESC')
                ->paginate(20);
            $senderGovs = Government::where('country_id', '=', Auth::guard('clients')->user()->country_id)->where('soft_deleted', '=', 0)->get();
        } else {
            $nowProductsRequests = null;
            $senderGovs = null;
        }

        $bills = Receipt::where('client_id', Auth::guard('clients')->user()->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        $countries = Country::where('soft_deleted', '=', 0)->get();
        $my_products_requests = ProductRequests::with('provider:id,name', 'sender:id,name', 'product:id,name,main_image', 'bill', 'group')->where('soft_deleted', '=', 0)
            ->where('buyer_id', '=', Auth::guard('clients')->user()->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(20);
        if (Auth::guard('clients')->user()->type == 1 || Auth::guard('clients')->user()->type == 2) {
            $packages = Package::where('soft_deleted', '=', 0)->get();
        } else {
            $packages = null;
        }
        return view('livewire.frontend.profile', [
            'countries'             => $countries,
            'address'               => $this->getAddress(),
           'productsArray'          => Product::with('category')->where('soft_deleted', '=', 0)->where('client_id', '=', Auth::guard('clients')->user()->id)->orderBy('created_at', 'DESC')->paginate(20),
            'bills'                 => $bills,
            'my_products_requests'  => $my_products_requests,
            'productsRequests'      => $productsRequests,
            'areas'                 => Client::findOrFail(Auth::guard('clients')->user()->id)->serv_aval_in,
            'nowProductsRequests'   => $nowProductsRequests,
            'packages'              => $packages,
            'senderGovs'            => $senderGovs,
            'hasBranches'           => $hasBranches

        ]);
    }


    public function buyPackage($id) {
        $gift = Package::findOrFail($id);
        $item_data = [
            'item_id'       => $gift->id,
            'name'          => $gift->name,
            'address_id'    => null,
            'receipt_days'  => 7,
            'model'         => Package::class
        ];
        $this->createBill($item_data, $gift->price, 0);
        return redirect()->route('frontend.cart');
    }
}
