<?php

namespace App\Http\Livewire\Admin;

use App\Models\Client;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentDebt extends Component
{
    use LivewireAlert;

    use WithPagination;
    public $searchForm          = '';
    public $rejectFormVisible   = false;
    public function confirmReject($id) {
        $this->rejectFormVisible = true;
        $this->modelId = $id;

    }
    public function reject() {
        Client::findOrFail($this->modelId)->update(['status' => 0]);
        $this->hideModel();
         $this->alert('success', 'تم حظر العضو بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('dashboard.payment-debt');
    }
    public function hideModel() {
        $this->rejectFormVisible = false;
        return redirect()->route('dashboard.payment-debt');
    }
    public function all_users() {
        $data = $this->searchForm;
        $clients = Client::where('status', '=', 1)
            ->where('soft_deleted', '=', 0)
            ->where('debt', '>', 0);
        if ($this->searchForm != '') {
            $clients = $clients->where('email', '=', $data)
            ->orWhere('name', 'LIKE', "%{$data}%")
            ->orWhere('whatsapp_phone', '=', $data);
        }
        $clients = $clients->orderBy('debt', 'DESC')->paginate(20);
        return $clients;

    }

    public function render()
    {
        return view('livewire.admin.payment-debt', [
            'users' => $this->all_users()
        ]);
    }
}
