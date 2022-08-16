<?php

namespace App\Http\Livewire\Admin;

use App\Http\Traits\calculateCommission;
use App\Http\Traits\notifications;
use App\Http\Traits\PointsSystem;
use App\Models\PaymentSetting;
use App\Models\Testimonial;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Testimonials extends Component
{
    use WithPagination, calculateCommission, PointsSystem;
    use LivewireAlert, notifications;

    public $updateFormVisible   = false;
    public $deleteFormVisible   = false;
    public $modelId;

    public function confirmUserDelete($id) {
        $this->deleteFormVisible = true;
        $this->modelId = $id;

    }
    public function showUpdateModel($id) {
        $this->updateFormVisible = true;
        $this->modelId = $id;
    }


    public function update() {

        $row = Testimonial::findOrFail($this->modelId);
        $Client = $row->update([
            'status' => 1
        ]);
        $this->plusPoints($row->client_id, 10);
        // $this->storeLog($Client, Client::class, $row);
        $this->hideModel();
        $this->alert('success', 'تم النشر  بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
        return redirect()->route('admin.testimonials');

     }

     public function destroy() {
        $Client = Testimonial::findOrFail($this->modelId);
        $Client->update(['soft_deleted' => 1]);
        // $this->storeLog($Client, Testimonial::class);
        $this->hideModel();
        $this->alert('success', 'تم الحذف بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
         return redirect()->route('admin.testimonials');
     }

     public function hideModel() {
        $this->updateFormVisible = false;
        $this->deleteFormVisible = false;
         return redirect()->route('admin.testimonials');
     }

    public function render()
    {
        $data = Testimonial::with('client:id,name,email')
            ->where('soft_deleted', '=', 0)
            ->where('status', '=', 0)->orderBy('created_at', 'DESC')->get();
        return view('livewire.admin.testimonials', [
            'data'  => $data
        ]);
    }
}
