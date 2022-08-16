<?php

namespace App\Http\Livewire\Admin;

use App\Models\pointsCommission;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class PointsCommissions extends Component
{
    use LivewireAlert;

    public $createFormVisible   = false;
    public $updateFormVisible   = false;
    public $deleteFormVisible   = false;
    public $points;
    public $type;
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
            'points'      => $this->points,
            'type'      => $this->type,
        ];
    }
    public function updateModelData() {
        return [
            'name'      => $this->name,
            'points'      => $this->points,
            'type'      => $this->type,
        ];
    }
    public function loadModelData() {
        $data = pointsCommission::find($this->modelId);
        $this->name = $data->name;
        $this->points = $data->points;
        $this->type = $data->type;
    }

    public function resetFormDate() {
        $this->name = null;
        $this->points = null;
        $this->type = null;
    }

    public function rules() {
        return [
            'name'          => 'required',
            'points'          => 'required',
            'type'          => 'required',
        ];
    }

    public function store() {
        $this->validate();
        $Country = pointsCommission::create($this->modelData());
        // $this->storeLog($Country, pointsCommission::class);
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم انشاء الفئة بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('dashboard.points-commissions');

    }

    public function update() {
        $validatedData = $this->validate([
            'name'          => 'required',
            'points'          => 'required',
            'type'          => 'required',
        ]);

        $row = pointsCommission::findOrFail($this->modelId);
        $Country = $row->update($this->updateModelData());
        // $this->storeLog($Country, pointsCommission::class, $row);
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم تعديل الفئة بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('dashboard.points-commissions');
    }

    public function destroy() {
        $Country = pointsCommission::findOrFail($this->modelId);
        $Country->update(['soft_deleted' => 1]);
        // $this->storeLog($user, User::class);
        $this->hideModel();
        $this->alert('success', 'تم حذف الفئة بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('dashboard.points-commissions');
    }

    public function hideModel() {
        $this->createFormVisible = false;
        $this->updateFormVisible = false;
        $this->deleteFormVisible = false;
        return redirect()->route('dashboard.points-commissions');
    }

    public function render()
    {
        $rows = pointsCommission::where('soft_deleted', '=', 0)->get();
        return view('livewire.admin.points-commissions', [
            'rows'  => $rows
        ]);
    }
}
