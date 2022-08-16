<?php

namespace App\Http\Livewire\Admin;

use App\Models\Page;
use App\Models\Reesh as ModelsReesh;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Reesh extends Component
{
    use LivewireAlert;

    use WithFileUploads;
    use WithPagination;
    public $createFormVisible   = false;
    public $updateFormVisible   = false;
    public $statusFormVisible   = false;
    protected $listeners = ['postAdded' => 'eventName'];
    public $searchForm          = '';
    public $price;
    public $image;
    public $image_name;
    public $receipt_days;
    public $modelId;
    public $status;
    public $page_text;

    public function eventName($data) {
        $this->page_text = $data;
        $this->updatePageData();
        $this->emit('doneTal');

        //return false;
   }

    public function showStatusModel($id) {
        $this->statusFormVisible = true;
        $this->modelId = $id;

    }
    public function createShowModel() {
        $this->resetFormDate();
        $this->createFormVisible = true;
    }

    public function showUpdateModel($id) {
        $this->updateFormVisible = true;
        $this->modelId = $id;
        $this->loadModelData();
    }

    public function modelData() {
        return [
            'price'             => $this->price,
            'receipt_days'      => $this->receipt_days,

        ];
    }
    public function updateModelData() {
        return [
            'price'             => $this->price,
            'receipt_days'      => $this->receipt_days,
        ];
    }
    public function loadModelData() {
        $data = ModelsReesh::find($this->modelId);
        $this->price = floor($data->price);
        $this->receipt_days = $data->receipt_days;
    }

    public function resetFormDate() {
        $this->price         = null;
        $this->receipt_days         = null;
    }

    public function rules() {
        return [
            'price'          => 'required|numeric',
            'receipt_days'  => 'required|numeric',
        ];
    }



    public function store() {
       $this->validate();
       $ModelsReesh = ModelsReesh::create($this->modelData());
       // $this->storeLog($ModelsReesh, ModelsReesh::class);
       $this->resetFormDate();
       $this->hideModel();
       $this->alert('success', 'تم انشاء الريشة بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('dashboard.reesh');

    }

    public function update() {
        $validatedData = $this->validate([
            'price'          => 'required|numeric',
            'receipt_days'  => 'required|numeric',
        ]);
        $row = ModelsReesh::findOrFail($this->modelId);
        $ModelsReesh = $row->update($this->updateModelData());
        // $this->storeLog($ModelsReesh, ModelsReesh::class, $row);
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم تعديل الريشة بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
        return redirect()->route('dashboard.reesh');
     }

     public function updatePageData() {
        $row = Page::where('slug','=', 'reesh');
        $user = $row->update(['content' => $this->page_text]);
        // $this->storeLog($user, User::class, $row);
        $this->alert('success', 'Data Updated Successfully', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
         return redirect()->route('dashboard.reesh');
     }

     public function destroy() {
        $ModelsReesh = ModelsReesh::findOrFail($this->modelId);
        $ModelsReesh->update(['soft_deleted' => 1]);
        // $this->storeLog($ModelsReesh, ModelsReesh::class);
        $this->hideModel();
        $this->alert('success', 'تم حذف الريشة بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
         return redirect()->route('dashboard.reesh');
     }

    public function hideModel() {
        $this->createFormVisible = false;
        $this->updateFormVisible = false;
        $this->statusFormVisible = false;
        return redirect()->route('dashboard.reesh');
    }

    public function updateStatus() {
        $row = ModelsReesh::findOrFail($this->modelId);
        if ($row->status == 1) {
            $this->status = 0;
            $row->update(['status' => 0]);
        } else {
            $this->status = 1;
            $row->update(['status' => 1]);
        }
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم تعديل الريشة بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
        return redirect()->route('dashboard.reesh');
    }

    public function all_users() {
        return ModelsReesh::where('soft_deleted', '=', 0)->orderBy('id', 'asc')->paginate(20);

    }


    public function render()
    {
        return view('livewire.admin.reesh', [
            'rows' => $this->all_users(),
            'pageIn' => Page::where('slug','=', 'reesh')->first()
        ]);
    }
}
