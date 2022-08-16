<?php

namespace App\Http\Livewire\Admin;

use App\Models\Country;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Countries extends Component
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
            'name'      => $this->name,
        ];
    }
    public function loadModelData() {
        $data = Country::find($this->modelId);
        $this->name = $data->name;
    }

    public function resetFormDate() {
        $this->name         = null;
    }

    public function rules() {
        return [
            'name'          => 'required|max:255',
        ];
    }



    public function store() {
       $this->validate();
       $Country = Country::create($this->modelData());
       // $this->storeLog($Country, Country::class);
       $this->resetFormDate();
       $this->hideModel();
       $this->alert('success', 'تم انشاء الدولة بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('dashboard.countries');
    }

    public function update() {
        $validatedData = $this->validate([
            'name'          => 'required|max:255',
        ]);

        $row = Country::findOrFail($this->modelId);
        $Country = $row->update($this->updateModelData());
        // $this->storeLog($Country, Country::class, $row);
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم تعديل المشرف بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
        return redirect()->route('dashboard.countries');
     }

     public function destroy() {
        $Country = Country::findOrFail($this->modelId);
        $Country->update(['soft_deleted' => 1]);
        // $this->storeLog($user, User::class);
        $this->hideModel();
        $this->alert('success', 'تم حذف المشرف بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
         return redirect()->route('dashboard.countries');
    }

    public function hideModel() {
        $this->createFormVisible = false;
        $this->updateFormVisible = false;
        $this->deleteFormVisible = false;
        return redirect()->route('dashboard.countries');
    }

    public function all_users() {
        $row = Country::withCount('governments', 'clients');
        if ($this->searchForm != '') {
            $DATA = $this->searchForm;
            return $row->where('name', 'LIKE', "%{$DATA}%")->where('soft_deleted', '=', 0)->paginate(20);

        } else {
            return $row->where('soft_deleted', '=', 0)->orderBy('created_at', 'DESC')->paginate(20);
        }
    }

    public function render()
    {
        return view('livewire.admin.countries',[
            'countries' => $this->all_users()
        ]);
    }
}
