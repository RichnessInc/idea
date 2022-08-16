<?php

namespace App\Http\Livewire\Admin;

use App\Models\GeneralInfo as ModelsGeneralInfo;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class GeneralInfo extends Component
{
    use LivewireAlert;

    use WithPagination;
    public $facebook;
    public $instgram;
    public $twitter;
    public $snapchat;
    public $whatsapp;
    public $telgram;
    public $switch;

    public $tel_fax;
    public $hot_line;
    public $email;
    public $address;

    public function __construct()
    {
        $data               = ModelsGeneralInfo::find(1);
        $this->facebook     = $data->facebook;
        $this->instgram     = $data->instgram;
        $this->twitter      = $data->twitter;
        $this->snapchat     = $data->snapchat;
        $this->whatsapp     = $data->whatsapp;
        $this->telgram      = $data->telgram;
        $this->currency     = $data->currency;
        $this->tel_fax      = $data->tel_fax;
        $this->hot_line     = $data->hot_line;
        $this->email        = $data->email;
        $this->address      = $data->address;
        $this->switch       = $data->senders_status;

    }

    public function updateModelData() {
        return [
            'facebook'      => $this->facebook,
            'instgram'      => $this->instgram,
            'twitter'       => $this->twitter,
            'snapchat'      => $this->snapchat,
            'whatsapp'      => $this->whatsapp,
            'telgram'       => $this->telgram,
            'currency'      => $this->currency,
            'tel_fax'      => $this->tel_fax,
            'hot_line'      => $this->hot_line,
            'email'      => $this->email,
            'address'      => $this->address,
            'senders_status'      => $this->switch,
        ];
    }
    public function loadModelData() {
        $data               = ModelsGeneralInfo::find(1);
        $this->facebook     = $data->facebook;
        $this->instgram     = $data->instgram;
        $this->twitter      = $data->twitter;
        $this->snapchat     = $data->snapchat;
        $this->whatsapp     = $data->whatsapp;
        $this->telgram      = $data->telgram;
        $this->currency     = $data->currency;

        $this->tel_fax      = $data->tel_fax;
        $this->hot_line     = $data->hot_line;
        $this->email        = $data->email;
        $this->address      = $data->address;
        $this->switch      = $data->senders_status;

    }
    public function update() {
        $this->validate([
            'facebook'  =>          ['max:255','nullable','regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
            'instgram'  =>          ['max:255','nullable','regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
            'twitter'   =>          ['max:255','nullable','regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
            'snapchat'  =>          ['max:255','nullable','regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
            'whatsapp'  =>          ['max:255','nullable','regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
            'telgram'   =>          ['max:255','nullable','regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
            'currency'  =>          ['max:255','required','numeric'],
            'hot_line'  =>          'max:255|nullable|numeric',
            'hot_line'  =>          'max:255|nullable|numeric',
            'address'   =>          'max:255|nullable|numeric',
            'email'     =>          'max:255|nullable|email',
            'switch'    =>          'required|numeric|max:9',
        ]);
        $row = ModelsGeneralInfo::findOrFail(1);
        $user = $row->update($this->updateModelData());
        // $this->storeLog($user, User::class, $row);
        $this->loadModelData();
        $this->alert('success', 'تم تعديل البيانات بنجاح', [
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

     public function clearCache() {
         Artisan::call("optimize:clear");
         Log::alert('Cache is cleared!');
         $this->alert('success', 'تم مسح الكاش بنجاح', [
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

    public function render()
    {

        return view('livewire.admin.general-info', [
            'data'  =>  ModelsGeneralInfo::findOrFail(1)
        ]);
    }
}
