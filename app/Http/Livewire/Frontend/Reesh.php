<?php

namespace App\Http\Livewire\Frontend;

use App\Http\Traits\BillTrait;
use App\Models\Address;
use App\Models\Bill;
use App\Models\Country;
use App\Models\Government;
use App\Models\Page;
use App\Models\Reesh as ModelsReesh;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Reesh extends Component
{
    use LivewireAlert;
    use BillTrait;

    public $createAddressVisible = false;
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
    public $address_id;

    public function select_address($ad_id) {
        $this->address_id = $ad_id;
    }

    public function country_change() {
        $this->governorates = Government::where('country_id', '=', $this->country_id)->where('soft_deleted', '=', 0)->get();
    }

    public function createAddressModel($id) {
        $this->resetAddressFormDate();
        $this->createAddressVisible = true;
        $this->modelId = $id;
    }
    public function resetAddressFormDate() {
        $this->street           = null;
        $this->sector           = null;
        $this->build_no         = null;
        $this->floor            = null;
        $this->government_id    = null;
        $this->country_id       = null;
        $this->unit_no          = null;
        $this->details          = null;
        $this->governorates     = null;
    }

    public function getAddress() {
        if (Auth::guard('clients')->check()) {
            return Address::with('country', 'government')->where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('status', '=', 1)
            ->orderBy('created_at', 'DESC')
            ->get();
        } else {
            return false;
        }
    }

    public function hideModel() {
        $this->createAddressVisible     = false;
        return redirect()->route('frontend.reesh');
    }

    public function store() {

        $hasReesh = false;
        $bills = Bill::where('client_id', '=', Auth::guard('clients')->user()->id)->where('status', '=', 0);
        $bills =  $bills->where('soft_deleted', '=', 0)->get();

        foreach ($bills as $bill) {
            if(json_decode($bill->item_data)->model == \App\Models\Reesh::class) {
                $hasReesh = true;
            }
        }
        if ($hasReesh == false ) {
            if ($this->address_id == null) {
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
                ]);
                $data = [
                    'government_id'     => $this->government_id,
                    'country_id'        => $this->country_id,
                    'street'            => $this->street,
                    'build_no'          => $this->build_no,
                    'sector'            => $this->sector,
                    'floor'             => $this->floor,
                    'unit_no'           => $this->unit_no,
                    'details'           => $this->details,
                ];
                $add = Address::create($data + ['client_id' => Auth::guard('clients')->user()->id]);
                $this->address_id = $add->id;
            }
            $gift = ModelsReesh::findOrFail($this->modelId);
            $gift->update(['status' => 1]);
            $item_data = [
                'name'          => 'شراء ريشة',
                'address_id'    => $this->address_id,
                'receipt_days'  => $gift->receipt_days,
                'model'         => ModelsReesh::class
            ];
            $this->createBill($item_data, $gift->price, 0);
            $this->resetAddressFormDate();
            $this->hideModel();
            $this->alert('success', 'تم انشاء الفاتورة بنجاح', [
                'position' =>  'center',
                'timer' =>  3000,
                'toast' =>  true,
                'text' =>  null,
                'confirmButtonText' =>  'Ok',
                'cancelButtonText' =>  'Cancel',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  false,
            ]);
            return redirect()->route('frontend.cart');
        } else {
            $this->alert('error', 'لديك ريشه حظ بالفعل', [
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
        $countries = Country::where('soft_deleted', '=', 0)->get();

        return view('livewire.frontend.reesh', [
            'countries'     => $countries,
            'address'       => $this->getAddress(),
            'gifts'         => ModelsReesh::where('status', '=', 0)->where('soft_deleted', '=', 0)->get(),
            'pageInfo'      => Page::where('slug', '=', 'reesh')->first(),

        ]);
    }


}
