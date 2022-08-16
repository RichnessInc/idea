<?php

namespace App\Http\Livewire\Admin;

use App\Models\altaawusVip as ModelsAltaawusVip;
use App\Models\altaawusVipRequest;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class AltaawusVip extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $page_text;
    public $modelID;


    protected $listeners = ['postAdded' => 'eventName'];

    public function __construct()
    {
        $data               = ModelsAltaawusVip::findOrFail(1);
        $this->page_text    = $data->text;
    }

    public function updateModelData() {
        return [
             'text'         => $this->page_text,
        ];
    }
    public function loadModelData() {
        $data                           = ModelsAltaawusVip::findOrFail(1);
        $this->page_text                = $data->text;
    }


    public function update() {
        $row = ModelsAltaawusVip::findOrFail(1);
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
        return redirect()->route('admin.altaawus-vip');
     }


    public function eventName($data) {
         $this->page_text = $data;
         $this->update();
         $this->emit('doneTal');
    }

    public function hideModel() {
        $this->deleteFormVisible = false;
        return redirect()->route('admin.altaawus-vip');
    }


    public function render()
    {
        return view('livewire.admin.altaawus-vip', [
            'data'      =>  ModelsAltaawusVip::findOrFail(1),
        ]);
    }
}
