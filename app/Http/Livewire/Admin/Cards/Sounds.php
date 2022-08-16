<?php

namespace App\Http\Livewire\Admin\Cards;

use App\Models\CardsSound;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Sounds extends Component
{
    use WithPagination, WithFileUploads;
    use LivewireAlert;
    public $audio;
    public $modelID;
    public $createFormVisible   = false;
    public $deleteFormVisible   = false;

    public function createShowModel() {
        // $this->audio = null;
        $this->createFormVisible = true;
    }
    public function confirmUserDelete($id) {
        $this->deleteFormVisible = true;
        $this->modelID = $id;
    }
    public function store() {


    }
    public function destroy() {


    }
    public function hideModel() {

        $this->createFormVisible = false;

        $this->deleteFormVisible = false;
    }
    public function render()
    {
        $rows = CardsSound::get();

        return view('livewire.admin.cards.sounds', [
            'rows'  => $rows
        ]);
    }
}
