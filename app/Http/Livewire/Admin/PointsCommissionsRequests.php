<?php

namespace App\Http\Livewire\Admin;

use App\Models\Client;
use App\Models\pointsCommission;
use App\Models\pointsCommissionRequest;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class PointsCommissionsRequests extends Component
{
    use LivewireAlert;

    public $updateFormVisible   = false;
    public $deleteFormVisible   = false;
    public $com;
    public $modelId;
    public function showUpdateModel($id) {
        $this->updateFormVisible = true;
        $this->modelId = $id;
        $this->loadModelData();
    }
    public function confirmUserDelete($id) {
        $this->deleteFormVisible = true;
        $this->modelId = $id;

    }
    public function modelData() {
        return [
            'com'      => $this->com,
];
    }
    public function updateModelData() {
        return [
            'com'      => $this->com,
        ];
    }
    public function loadModelData() {
        $data   = pointsCommissionRequest::find($this->modelId);
        $client = Client::findOrFail($data->client_id);
        $this->com = $client->spasial_com;
    }

    public function resetFormDate() {
        $this->com = null;
    }

    public function rules() {
        return [
            'com'          => 'required',
        ];
    }

    public function update() {
        $row = pointsCommissionRequest::findOrFail($this->modelId);
        $row->update(['status' => 0]);
        $client = Client::findOrFail($row->client_id)->update(['spasial_com' => $this->com]);
        // $this->storeLog($Country, pointsCommission::class, $row);
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم تعديل بنجاح', [
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
        $Country = pointsCommissionRequest::findOrFail($this->modelId);
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
        $this->updateFormVisible = false;
        $this->deleteFormVisible = false;
    }

    public function render()
    {
        $rows = pointsCommissionRequest::where('status', '=', 1)->where('soft_deleted', '=', 0)->get();
        return view('livewire.admin.points-commissions-requests', [
            'rows'  => $rows
        ]);
    }
}
