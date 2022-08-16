<?php

namespace App\Http\Livewire\Admin;

use App\Models\ShippingMethod;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Shipping extends Component
{
    use LivewireAlert;

    use WithPagination;
    public $createFormVisible   = false;
    public $updateFormVisible   = false;
    public $deleteFormVisible   = false;
    public $statusFormVisible   = false;
    public $premiumFormVisible   = false;
    public $searchForm          = '';
    public $name;
    public $status;
    public $premium;

    public $price;
    public $modelId;

    public function createShowModel() {
        $this->resetFormDate();
        $this->createFormVisible = true;
    }
    public function confirmUserDelete($id) {
        $this->deleteFormVisible = true;
        $this->modelId = $id;
    }
    public function confirmPremium($id) {
        $this->premiumFormVisible = true;
        $this->modelId = $id;
    }

    public function showStatusModel($id) {
        $this->statusFormVisible = true;
        $this->modelId = $id;

    }

    public function showUpdateModel($id) {
        $this->updateFormVisible = true;
        $this->modelId = $id;
        $this->loadModelData();
    }

    public function modelData() {
        return [
            'name'              => $this->name,
            'price'             => $this->price,
        ];
    }
    public function updateModelData() {
        return [
            'name'              => $this->name,
            'price'             => $this->price,
        ];
    }
    public function loadModelData() {
        $data = ShippingMethod::find($this->modelId);
        $this->name = $data->name;
        $this->price = floor($data->price);
    }

    public function resetFormDate() {
        $this->name         = null;
        $this->price   = null;
    }

    public function rules() {
        return [
            'name'          => 'required|max:255',
            'price'          => 'required',
        ];
    }



    public function store() {
       $this->validate();
       $Country = ShippingMethod::create($this->modelData());
       // $this->storeLog($Country, Country::class);
       $this->resetFormDate();
       $this->hideModel();
       $this->alert('success', 'تم انشاء وسيلة الدفع بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('dashboard.shipping');
    }
    public function premium() {
        $row = ShippingMethod::findOrFail($this->modelId);
        if ($row->premium == 1) {
            $this->premium = 0;
            $row->update(['premium' => 0]);
        } else {
            $this->premium = 1;
            $row->update(['premium' => 1]);
        }
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم تعديل وسيلة الدفع بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('dashboard.shipping');
    }
    public function updateStatus() {
        $row = ShippingMethod::findOrFail($this->modelId);
        if ($row->status == 1) {
            $this->status = 0;
            $row->update(['status' => 0]);
        } else {
            $this->status = 1;
            $row->update(['status' => 1]);
        }
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم تعديل وسيلة الدفع بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
        return redirect()->route('dashboard.shipping');
    }

    public function update() {
        if ($this->modelId == 3) {
            $validatedData = $this->validate([
                'name'          => 'required|max:255',
            ]);
        } else {
            $validatedData = $this->validate([
                'name'          => 'required|max:255',
                'price'          => 'required|numeric',
            ]);
        }
        $validatedData = $this->validate([
            'name'          => 'required|max:255',
            'price'          => 'required|numeric',
        ]);

        $row = ShippingMethod::findOrFail($this->modelId);
        $Country = $row->update($this->updateModelData());
        // $this->storeLog($Country, Country::class, $row);
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم تعديل وسيلة الدفع بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
        return redirect()->route('dashboard.shipping');
     }

     public function destroy() {
        $Country = ShippingMethod::findOrFail($this->modelId);
        $Country->update(['soft_deleted' => 1]);
        // $this->storeLog($user, User::class);
        $this->hideModel();
        $this->alert('success', 'تم حذف وسيلة الدفع بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
         return redirect()->route('dashboard.shipping');
    }

    public function hideModel() {
        $this->createFormVisible = false;
        $this->updateFormVisible = false;
        $this->deleteFormVisible = false;
        $this->statusFormVisible   = false;
        $this->premiumFormVisible   = false;

        return redirect()->route('dashboard.shipping');
    }

    public function all_users() {
        $row = ShippingMethod::where('soft_deleted', '=', 0);
        if ($this->searchForm != '') {
            $DATA = $this->searchForm;
            return $row->where('name', 'LIKE', "%{$DATA}%")->paginate(20);

        } else {
            return $row->orderBy('created_at', 'DESC')->paginate(20);
        }
    }

    public function render()
    {
        return view('livewire.admin.shipping', [
            'rows' => $this->all_users()
        ]);
    }
}
