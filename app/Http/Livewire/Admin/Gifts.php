<?php

namespace App\Http\Livewire\Admin;

use App\Models\Gift;
use App\Models\Page;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Gifts extends Component
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
    public $receipt_days;
    public $modelId;
    public $page_text;
    public $status;

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
        $data = Gift::find($this->modelId);
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
       $Gift = Gift::create($this->modelData());
       // $this->storeLog($Gift, Gift::class);
       $this->resetFormDate();
       $this->hideModel();
       $this->alert('success', 'تم انشاء الصندوق بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('dashboard.giftsbox');
    }

    public function update() {
        $validatedData = $this->validate([
            'price'          => 'required|numeric',
            'receipt_days'  => 'required|numeric',
        ]);

        $row = Gift::findOrFail($this->modelId);
        $Gift = $row->update($this->updateModelData());
        // $this->storeLog($Gift, Gift::class, $row);
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم تعديل الصندوق بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
        return redirect()->route('dashboard.giftsbox');
     }
     public function updatePageData() {
          $row = Page::where('slug','=', 'gifts');
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
         return redirect()->route('dashboard.giftsbox');
     }
     public function destroy() {
        $Gift = Gift::findOrFail($this->modelId);
        $Gift->update(['soft_deleted' => 1]);
        // $this->storeLog($Gift, Gift::class);
        $this->hideModel();
        $this->alert('success', 'تم حذف الصندوق بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
         return redirect()->route('dashboard.giftsbox');
     }

    public function hideModel() {
        $this->createFormVisible = false;
        $this->updateFormVisible = false;
        $this->statusFormVisible = false;
        return redirect()->route('dashboard.giftsbox');
    }

    public function updateStatus() {
        $row = Gift::findOrFail($this->modelId);
        if ($row->status == 1) {
            $this->status = 0;
            $row->update(['status' => 0]);
        } else {
            $this->status = 1;
            $row->update(['status' => 1]);
        }
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم تعديل الصندوق بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
        return redirect()->route('dashboard.giftsbox');
    }

    public function all_users() {
        return Gift::where('soft_deleted', '=', 0)
            ->orderBy('id', 'asc')->paginate(20);

    }

    public function render()
    {
       // dd(Page::where('slug','=', 'gifts')->first()->content);
        return view('livewire.admin.gifts', [
            'rows'  => $this->all_users(),
            'pageIn'  => Page::where('slug','=', 'gifts')->first()
        ]);
    }
}
