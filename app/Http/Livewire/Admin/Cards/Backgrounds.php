<?php

namespace App\Http\Livewire\Admin\Cards;
use App\Models\CardsBackground;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Backgrounds extends Component
{
    use WithPagination, WithFileUploads;
    use LivewireAlert;
    public $image;
    public $modelID;
    public $createFormVisible   = false;
    public $deleteFormVisible   = false;

    public function createShowModel() {
        $this->image = null;
        $this->createFormVisible = true;
    }
    public function confirmUserDelete($id) {
        $this->deleteFormVisible = true;
        $this->modelID = $id;
    }


    public function store() {

        if($this->image != '') {

            $name =  md5($this->image  . microtime()) . '_.' . $this->image->extension();

            $image =  ['background_name' => $name];

            $this->image->storeAs('/', $name, 'uploads');

            CardsBackground::create($image);
            $this->hideModel();
            $this->alert('success', 'تم رفع الصوت الصورة', [
                'position' =>  'cenetr',
                'timer' =>  3000,
                'toast' =>  true,
                'text' =>  '',
                'confirmButtonText' =>  'Ok',
                'cancelButtonText' =>  'Cancel',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  false,
            ]);
        } else {
            $this->alert('error', 'يجب رفع صورة', [
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
    }
    public function destroy() {

        CardsBackground::findOrFail($this->modelID)->delete();

        $this->hideModel();

        $this->alert('success', 'تم حذف الخلفية بنجاح', [
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

        $this->createFormVisible = false;

        $this->deleteFormVisible = false;
    }
    public function render()
    {
        $rows = CardsBackground::get();
        return view('livewire.admin.cards.backgrounds', [
            'rows'  => $rows
        ]);
    }
}
