<?php

namespace App\Http\Livewire\Admin\Cards;

use App\Models\Card;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithFileUploads;
    use LivewireAlert;

    public $deleteFormVisible = false;
    public $modelId;
    public $searchForm;

    public function destroy() {
        $Client = Card::findOrFail($this->modelId);
        $Client->delete();
        // $this->storeLog($Client, Client::class);
        $this->hideModel();
        $this->alert('success', 'تم حذف الكارت بنجاح', [
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
    public function confirmUserDelete($id) {
        $this->deleteFormVisible = true;
        $this->modelId = $id;
    }
    public function all_users() {
        $data = $this->searchForm;
        if ($this->searchForm != '') {
            return Card::with('client')
                ->whereHas('client', function($q) use ($data) {
                $q->where('email', '=', $data)
                ->orWhere('name', 'LIKE', "%{$data}%")
                ->orWhere('whatsapp_phone', '=', $data);
            })->paginate(20);

        } else {
            return Card::with('client')->orderBy('created_at', 'DESC')->paginate(20);
        }
    }

    public function hideModel() {
        $this->deleteFormVisible = false;
    }

    public function render()
    {
        return view('livewire.admin.cards.index', [
            'users' => $this->all_users()
        ]);
    }
}
