<?php

namespace App\Http\Livewire\Admin;

use App\Models\Country;
use App\Models\Government;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Governments extends Component
{
    use LivewireAlert;

    use WithPagination;
    public $createFormVisible   = false;
    public $updateFormVisible   = false;
    public $deleteFormVisible   = false;
    public $searchForm          = '';
    public $name;
    public $country_id;
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
            'country_id'        => $this->country_id,
        ];
    }
    public function updateModelData() {
        return [
            'name'              => $this->name,
            'country_id'        => $this->country_id,
        ];
    }
    public function loadModelData() {
        $data = Government::find($this->modelId);
        $this->name = $data->name;
        $this->country_id = $data->country_id;
    }

    public function resetFormDate() {
        $this->name         = null;
        $this->country_id   = null;
    }

    public function rules() {
        return [
            'name'          => 'required|max:255',
            'country_id'     => 'required',
        ];
    }



    public function store() {
       $this->validate();
       $Country = Government::create($this->modelData());
       // $this->storeLog($Country, Country::class);
       $this->resetFormDate();
       $this->hideModel();
       $this->alert('success', 'Country Created Successfully', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('dashboard.governments');

    }

    public function update() {
        $validatedData = $this->validate([
            'name'          => 'required|max:255',
        ]);

        $row = Government::findOrFail($this->modelId);
        $Country = $row->update($this->updateModelData());
        // $this->storeLog($Country, Country::class, $row);
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'Country Updated Successfully', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
        return redirect()->route('dashboard.governments');
     }

     public function destroy() {
        $Country = Government::findOrFail($this->modelId);
        $Country->update(['soft_deleted' => 1]);
        // $this->storeLog($user, User::class);
        $this->hideModel();
        $this->alert('success', 'Country Deleted Successfully', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
         return redirect()->route('dashboard.governments');
     }

    public function hideModel() {
        $this->createFormVisible = false;
        $this->updateFormVisible = false;
        $this->deleteFormVisible = false;
        return redirect()->route('dashboard.governments');
    }

    public function all_users() {
        $row = Government::with('country')
        ->withCount('clients')
        ->whereHas('country', function ($query) {
            return $query->where('soft_deleted', '=', 0);
        })
        ->where('soft_deleted', '=', 0);
        if ($this->searchForm != '') {
            $DATA = $this->searchForm;
            return $row->where('name', 'LIKE', "%{$DATA}%")->paginate(20);

        } else {
            return $row->orderBy('created_at', 'DESC')->paginate(20);
        }
    }
    public function render()
    {
        return view('livewire.admin.governments', [
            'governments'   => $this->all_users(),
            'countries'   => Country::where('soft_deleted', '=', 0)->get()
        ]);
    }
}
