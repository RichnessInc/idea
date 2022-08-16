<?php

namespace App\Http\Livewire\Admin;

use App\Models\homepageSetting;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class HomepageSettings extends Component
{
    use LivewireAlert;

    public $slider_1;
    public $slider_2;
    public $slider_3;
    public $slider_4;

    public $uper_ads;
    public $down_ads;

    public function __construct() {
        $data = homepageSetting::find(1);
        $this->slider_1 = $data->slider_1;
        $this->slider_2 = $data->slider_2;
        $this->slider_3 = $data->slider_3;
        $this->slider_4 = $data->slider_4;
    }

    public function update() {
        homepageSetting::find(1)->update([
            'slider_1' => $this->slider_1,
            'slider_2' => $this->slider_2,
            'slider_3' => $this->slider_3,
            'slider_4' => $this->slider_4,
        ]);
        $this->alert('success', 'تم تحديث البيانات', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('admin.homepage-settings');

    }

    public function render()
    {
        return view('livewire.admin.homepage-settings');
    }
}
