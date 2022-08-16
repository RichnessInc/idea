<?php

namespace App\Http\Livewire\Frontend;

use App\Models\altaawusVip as ModelsAltaawusVip;
use App\Models\altaawusVipRequest;
use App\Models\Country;
use App\Models\Government;
use App\Models\ShippingMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AltaawusVip extends Component
{
    use LivewireAlert;

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
    public $method_id;
    public $email;
    public $whatsapp_phone;
    public $createAddressVisible = false;


    public function createAddressModel($id) {
        $this->resetAddressFormDate();
        $this->createAddressVisible = true;
        $this->method_id = $id;
    }

    public function country_change() {
        $this->governorates = Government::where('country_id', '=', $this->country_id)->where('soft_deleted', '=', 0)->get();
    }
    public function store() {
        $validatedData = $this->validate([
            'government_id'     => 'required|numeric',
            'country_id'        => 'required|numeric',
            //////////////////////////////////////////////////////////////
            'street'            => 'required|string|max:255',
            'build_no'          => 'required|numeric',
            'sector'            => 'required|string|max:255',
            'floor'             => 'required|numeric',
            'unit_no'           => 'required|numeric',
            'details'           => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'whatsapp_phone'    => 'required|string|max:255',
        ]);
        $data = [
            'government_id'         => $this->government_id,
            'country_id'            => $this->country_id,
            'street'                => $this->street,
            'build_no'              => $this->build_no,
            'sector'                => $this->sector,
            'floor'                 => $this->floor,
            'unit_no'               => $this->unit_no,
            'details'               => $this->details,
            'client_id'             => (Auth::guard('clients')->check() ? Auth::guard('clients')->user()->id : null),
            'shipping_method_id'    => $this->method_id,
            'email'                 => $this->email,
            'whatsapp_phone'        => $this->whatsapp_phone,
        ];
        altaawusVipRequest::create($data);
        Mail::to('altaawus2020@gmail.com')->send(new \App\Mail\vipRequest());
        $this->resetAddressFormDate();
        $this->hideModel();
        $this->alert('success', 'تم ارسال طلب للإدارة بنجاح العنوان بنجاح', [
            'position' =>  'center',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  null,
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('frontend.altaawus-vip');

    }

    public function resetAddressFormDate() {
        $this->street               = null;
        $this->sector               = null;
        $this->build_no             = null;
        $this->floor                = null;
        $this->government_id        = null;
        $this->country_id           = null;
        $this->unit_no              = null;
        $this->details              = null;
        $this->client_id            = null;
        $this->shipping_method_id   = null;
    }


    public function hideModel() {
        $this->createAddressVisible     = false;
        $this->createProductVisible     = false;
        $this->updateProductFormVisible = false;
        $this->deleteProductVisible     = false;
        $this->addProductExtraVisible   = false;
        $this->ProductExtraVisible      = false;
        return redirect()->route('frontend.altaawus-vip');

    }
    public function render()
    {
        $countries = Country::where('soft_deleted', '=', 0)->get();

        return view('livewire.frontend.altaawus-vip', [
            'countries' => $countries,
            'pageIn'    => ModelsAltaawusVip::findOrFail(1),
            'methods'   => ShippingMethod::where('status', '=', 1)->where('soft_deleted', '=', 0)->where('premium', '=', 1)->get()
        ]);
    }
}
