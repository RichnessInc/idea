<?php

namespace App\Http\Livewire\Admin\Cards;

use App\Models\CardsSound;
use App\Models\CardsVideo;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Videos extends Component
{
    use WithPagination, WithFileUploads;
    use LivewireAlert;
    public $image;
    public $category_id;
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

            $image =  ['video_name' => $name];

            $this->image->storeAs('/', $name, 'uploads');

            CardsVideo::create($image + ['category_id' => $this->category_id]);
            $this->hideModel();

            $this->alert('success', 'تم رفع الفيديو بنجاح', [
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
            $this->alert('error', 'يجب رفع الفيديو', [
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

        CardsVideo::findOrFail($this->modelID)->delete();

        $this->hideModel();

        $this->alert('success', 'تم حذف الفيديو بنجاح', [
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
        $rows = CardsVideo::get();
        return view('livewire.admin.cards.videos', [
            'rows' => $rows
        ]);
    }
}
