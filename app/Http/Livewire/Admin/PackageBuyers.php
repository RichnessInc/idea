<?php

namespace App\Http\Livewire\Admin;

use App\Models\Package;
use App\Models\PackageBuyer;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class PackageBuyers extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $createFormVisible   = false;
    public $updateFormVisible   = false;
    public $deleteFormVisible   = false;
    public $searchForm          = '';
    public $name;
    public $price;
    public $description;
    public $modelId;

    public function createShowModel() {
        $this->resetFormDate();
        $this->createFormVisible = true;
    }
    public function confirmUserDelete($id) {
        $this->deleteFormVisible = true;
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
            'description'       => $this->description,
        ];
    }
    public function updateModelData() {
        return [
            'name'              => $this->name,
            'price'             => $this->price,
            'description'       => $this->description,
        ];
    }
    public function loadModelData() {
        $data = Package::find($this->modelId);
        $this->name = $data->name;
        $this->price = $data->price;
        $this->description = $data->description;
    }

    public function resetFormDate() {
        $this->name         = null;
        $this->price                = null;
        $this->description         = null;
    }

    public function rules() {
        return [
            'name'          => 'required|max:255',
        ];
    }



    public function store() {
        $this->validate();
        $Country = Package::create($this->modelData());
        // $this->storeLog($Country, Package::class);
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم انشاء باقة بنجاح', [
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

    public function update() {
        $validatedData = $this->validate([
            'name'          => 'required|max:255',
        ]);

        $row = Package::findOrFail($this->modelId);
        $Country = $row->update($this->updateModelData());
        // $this->storeLog($Country, Package::class, $row);
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم تعديل باقة بنجاح', [
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

    public function destroy() {
        $Country = PackageBuyer::findOrFail($this->modelId);
        $Country->update(['soft_deleted' => 1]);
        // $this->storeLog($user, User::class);
        $this->hideModel();
        $this->alert('success', 'تم حذف الطلب بنجاح', [
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
        $this->createFormVisible = false;
        $this->updateFormVisible = false;
        $this->deleteFormVisible = false;
    }

    public function all_users() {
        $row = Package::withCount('buyers')->where('soft_deleted', '=', 0);
        if ($this->searchForm != '') {
            $DATA = $this->searchForm;
            return $row->where('name', 'LIKE', "%{$DATA}%")->paginate(20);

        } else {
            return $row->orderBy('created_at', 'DESC')->paginate(20);
        }
    }
    public function render()
    {
        return view('livewire.admin.package-buyers', [
            'rows' => PackageBuyer::with('package', 'client:id,name')->where('soft_deleted', '=', 0)->orderBy('created_at', 'desc')->paginate(20)
        ]);
    }
}
