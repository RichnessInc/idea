<?php

namespace App\Http\Livewire\Admin;

use App\Models\PaymentSetting;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentSettings extends Component
{
    use LivewireAlert;

    use WithPagination;
    public $pro_max_dept;
    public $sender_max_dept;
    public $cashback_commission;
    public $handmade_commission;
    public $sender_commission;
    public $page_text;
    public $handmade_max_dept;
    public $marketing_commission;
    public $provider_commission;

    protected $listeners = ['postAdded' => 'eventName'];

    public function __construct()
    {
        $data                           = PaymentSetting::find(1);
        $this->pro_max_dept             = floor($data->pro_max_dept);
        $this->sender_max_dept          = floor($data->sender_max_dept);
        $this->cashback_commission      = floor($data->cashback_commission);
        $this->handmade_commission      = floor($data->handmade_commission);
        $this->sender_commission        = floor($data->sender_commission);
        $this->handmade_max_dept        = floor($data->handmade_max_dept);
        $this->marketing_commission     = floor($data->marketing_commission);
        $this->provider_commission      = floor($data->provider_commission);
        $this->page_text                = $data->text;
    }

    public function updateModelData() {
        return [
            'pro_max_dept'              => $this->pro_max_dept,
            'sender_max_dept'           => $this->sender_max_dept,
            'cashback_commission'       => $this->cashback_commission,
            'handmade_commission'       => $this->handmade_commission,
            'sender_commission'         => $this->sender_commission,
            'text'                      => $this->page_text,
            'handmade_max_dept'         => $this->handmade_max_dept,
            'marketing_commission'      => $this->marketing_commission,
            'provider_commission'      => $this->provider_commission,

        ];
    }
    public function loadModelData() {
        $data                           = PaymentSetting::find(1);
        $this->pro_max_dept             = floor($data->pro_max_dept);
        $this->sender_max_dept          = floor($data->sender_max_dept);
        $this->cashback_commission      = floor($data->cashback_commission);
        $this->handmade_commission      = floor($data->handmade_commission);
        $this->sender_commission        = floor($data->sender_commission);
        $this->page_text                = $data->text;
        $this->handmade_max_dept        = floor($data->handmade_max_dept);
        $this->marketing_commission     = floor($data->marketing_commission);
        $this->provider_commission      = floor($data->provider_commission);

    }


    public function update() {
      //dd($this->page_text);
        $row = PaymentSetting::findOrFail(1);
        $user = $row->update($this->updateModelData());
        // $this->storeLog($user, User::class, $row);
        $this->loadModelData();
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
        return redirect()->route('dashboard.payment.settings');

     }

    public function render()
    {
        return view('livewire.admin.payment-settings', [
            'data'  =>  PaymentSetting::findOrFail(1)

        ]);

    }
    public function eventName($data) {
         $this->page_text = $data;
         $this->update();
         $this->emit('doneTal');

         //return false;
    }
}
