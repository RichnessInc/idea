<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\ProductsCategory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Categories extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $createFormVisible   = false;
    public $updateFormVisible   = false;
    public $deleteFormVisible   = false;
    public $searchForm          = '';
    public $name;
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
            'name'      => $this->name,
        ];
    }
    public function updateModelData() {
        return [
        'name'            => $this->name,
        ];
    }
    public function loadModelData() {
        $data = ProductsCategory::find($this->modelId);
        $this->name                 = $data->name;
    }

    public function resetFormDate() {
        $this->name                 = null;
    }

    public function rules() {
        return [
            'name'          => 'required|max:255',
        ];
    }



    public function store() {
       $this->validate();
       $Client = ProductsCategory::create($this->modelData());
       // $this->storeLog($Client, Client::class);
       $this->resetFormDate();
       $this->hideModel();
       $this->alert('success', 'تم انشاء التصنيف بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('dashboard.categories');
    }

    public function update() {
        $row = ProductsCategory::findOrFail($this->modelId);
        $Client = $row->update($this->updateModelData());
        // $this->storeLog($Client, Client::class, $row);
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم تعديل التصنيف بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
        return redirect()->route('dashboard.categories');
     }

     public function destroy() {
        $Client = ProductsCategory::findOrFail($this->modelId);
        $Client->update(['soft_deleted' => 1]);
        // $this->storeLog($Client, Client::class);
        $this->hideModel();
        $this->alert('success', 'تم حذف التصنيف بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
         return redirect()->route('dashboard.categories');
    }

    public function hideModel() {
        $this->createFormVisible = false;
        $this->updateFormVisible = false;
        $this->deleteFormVisible = false;
        return redirect()->route('dashboard.categories');
    }

    public function all_users() {
        $data = $this->searchForm;
        if ($this->searchForm != '') {
            return ProductsCategory::withCount('products')
                ->where('soft_deleted', '=', 0)
                ->where('name', 'LIKE', "%{$data}%")
            ->paginate(20);

        } else {
            return ProductsCategory::withCount('products')
                ->where('soft_deleted', '=', 0)
                ->orderBy('created_at', 'DESC')->paginate(20);
        }
    }

    public function render()
    {
        return view('livewire.admin.categories', [
            'users'     => $this->all_users(),
        ]);
    }
}
