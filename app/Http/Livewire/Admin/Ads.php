<?php

namespace App\Http\Livewire\Admin;

use App\Models\Ads as ModelsAds;
use App\Models\Ads2;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Ads extends Component
{
    use WithPagination, WithFileUploads;
    use LivewireAlert;

    public $script;
    public $image;
    public $link;
    public $script2;
    public $image2;
    public $link2;
    public $script3;
    public $image3;
    public $link3;
    public $status;
    ////////////////
    public $ads_2_script;
    public $ads_2_image;
    public $ads_2_link;
    public $ads_2_script2;
    public $ads_2_image2;
    public $ads_2_link2;
    public $ads_2_script3;
    public $ads_2_image3;
    public $ads_2_link3;
    public $ads_2_status;

    public function __construct()
    {
        $ad = ModelsAds::findOrFail(1);
        $this->script   = $ad->script;
        $this->link     = $ad->link;
        $this->script2  = $ad->script2;
        $this->link2    = $ad->link2;
        $this->script3  = $ad->script3;
        $this->link3    = $ad->link3;
        $this->status   = $ad->status;
        //////////////
        $ad2 = Ads2::findOrFail(1);
        $this->ads_2_script     = $ad2->script;
        $this->ads_2_link       = $ad2->link;
        $this->ads_2_script2    = $ad2->script2;
        $this->ads_2_link2      = $ad2->link2;
        $this->ads_2_script3    = $ad2->script3;
        $this->ads_2_link3      = $ad2->link3;
        $this->ads_2_status     = $ad2->status;
    }

    public function ads() {
        if($this->image != '') {
            $name =  md5($this->image  . microtime()) . '_.' . $this->image->extension();
            $image =  ['image' => $name];
            $this->image->storeAs('/', $name, 'uploads');
        } else {
            $image = [];
        }

        if($this->image2 != '') {
            $name2 =  md5($this->image2  . microtime()) . '_.' . $this->image2->extension();
            $image2 =  ['image2' => $name2];
            $this->image2->storeAs('/', $name2, 'uploads');
        } else {
            $image2 = [];
        }

        if($this->image3 != '') {
            $name3 =  md5($this->image3  . microtime()) . '_.' . $this->image3->extension();
            $image3 =  ['image3' => $name3];
            $this->image3->storeAs('/', $name3, 'uploads');
        } else {
            $image3 = [];
        }

        ModelsAds::findOrFail(1)->update([
            'script'    => $this->script,
            'link'      => $this->link,
            'script2'   => $this->script2,
            'link2'     => $this->link2,
            'script3'   => $this->script3,
            'link3'     => $this->link3,
            'status'    => $this->status,
        ] + $image+ $image2 + $image3);

        $this->alert('success', 'تم التحديث بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('admin.ads');
    }


    public function ads2() {
        if($this->ads_2_image != '') {
            $name =  md5($this->ads_2_image  . microtime()) . '_.' . $this->ads_2_image->extension();
            $image =  ['image' => $name];
            $this->ads_2_image->storeAs('/', $name, 'uploads');
        } else {
            $image = [];
        }

        if($this->ads_2_image2 != '') {
            $name2 =  md5($this->ads_2_image2  . microtime()) . '_.' . $this->ads_2_image2->extension();
            $image2 =  ['image2' => $name2];
            $this->ads_2_image2->storeAs('/', $name2, 'uploads');
        } else {
            $image2 = [];
        }

        if($this->ads_2_image3 != '') {
            $name3 =  md5($this->ads_2_image3  . microtime()) . '_.' . $this->ads_2_image3->extension();
            $image3 =  ['image3' => $name3];
            $this->ads_2_image3->storeAs('/', $name3, 'uploads');
        } else {
            $image3 = [];
        }

        Ads2::findOrFail(1)->update([
            'script'    => $this->ads_2_script,
            'link'      => $this->ads_2_link,
            'script2'   => $this->ads_2_script2,
            'link2'     => $this->ads_2_link2,
            'script3'   => $this->ads_2_script3,
            'link3'     => $this->ads_2_link3,
            'status'    => $this->ads_2_status,
        ] + $image+ $image2 + $image3);

        $this->alert('success', 'تم التحديث بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('admin.ads');
    }

    public function render()
    {
        return view('livewire.admin.ads');
    }
}
