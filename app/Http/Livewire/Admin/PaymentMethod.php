<?php

namespace App\Http\Livewire\Admin;

use App\Models\ShippingMethod;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentMethod extends Component
{
    use LivewireAlert;

    use WithPagination;
    public $statusFormVisible   = false;
    public $searchForm          = '';
    public $name;
    public $status;
    public $modelId;

    public function showStatusModel($id) {
        $this->statusFormVisible = true;
        $this->modelId = $id;

    }


    public function updateStatus() {
        $row = \App\Models\paymentMethod::findOrFail($this->modelId);
        if ($row->status == 1) {
            $this->status = 0;
            $row->update(['status' => 0]);
        } else {
            $this->status = 1;
            $row->update(['status' => 1]);
        }
        $this->hideModel();
        $this->alert('success', 'تم تعديل وسيلة الدفع بنجاح', [
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
        $this->statusFormVisible   = false;
    }

    public function render()
    {
        return view('livewire.admin.payment-method', [
            'rows' => \App\Models\paymentMethod::get()
        ]);
    }
}
