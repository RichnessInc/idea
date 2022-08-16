<?php

namespace App\Http\Livewire\Admin;

use App\Models\altaawusVipRequest;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AltaawusVipRequests extends Component
{
    use LivewireAlert;

    public $acceptFormVisible = false;
    public $informationFormVisible = false;
    public $modelID;
    public $infoData;
    public function accept($id) {
        $this->acceptFormVisible = true;
        $this->modelID = $id;
    }

    public function information($id) {
        $this->modelID  = $id;
        $this->informationFormVisible = true;
        $this->infoData = altaawusVipRequest::with(
            'shipping_method:id,name',
            'client:id,name',
            'country:id,name',
            'government:id,name'
        )->findOrFail($this->modelID);
    }

    public function acceptReq() {
        $row = altaawusVipRequest::findOrFail($this->modelID);
        $user = $row->update(['status' => 1]);
        // $this->storeLog($user, User::class, $row);
        $this->hideModel();
        $this->alert('success', 'تم تحويل حالة الطلب الى تم', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('admin.altaawus-vip-requests');
    }

    public function hideModel() {
        $this->acceptFormVisible = false;
        $this->informationFormVisible = false;
        return redirect()->route('admin.altaawus-vip-requests');

    }

    public function destroy() {
        altaawusVipRequest::findOrFail($this->modelID)
            ->update(['soft_deleted' => 1]);
        $this->hideModel();
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
        return redirect()->route('admin.altaawus-vip-requests');
    }


    public function render()
    {
        return view('livewire.admin.altaawus-vip-requests', [
            'requests'  =>  altaawusVipRequest::with('client:id,name', 'country:id,name', 'government:id,name')
                ->where('status', '=', 0)
                ->where('soft_deleted', '=', 0)
                ->paginate(20),
        ]);
    }
}
