<?php

namespace App\Http\Livewire\Admin;

use App\Models\Client;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class BandClients extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $searchForm          = '';
    public $email;
    public $modelId;
    public $rejectFormVisible   = false;
    public $banFormVisible   = false;
    public function confirmReject($id) {
        $this->rejectFormVisible = true;
        $this->modelId = $id;
    }
    public function banFun() {
        $this->banFormVisible = true;
    }
    public function reject() {
        Client::findOrFail($this->modelId)->update(['status' => 1]);
        $this->hideModel();
        $this->alert('success', 'تم تفعيل العضو بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('dashboard.band-clients');
    }
    public function ban() {
        $client = Client::where('email', '=', $this->email)->first();
        if ($client != null) {
            $client->update(['status' => 0]);
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
        } else {
            $this->alert('error', 'البريد الالكتروني غير صحيح', [
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
        return redirect()->route('dashboard.band-clients');
    }

    public function hideModel() {
        $this->rejectFormVisible = false;
        return redirect()->route('dashboard.band-clients');
    }
    public function all_users() {
        $data = $this->searchForm;
        $clients = Client::where('status', '!=', 1)->where('soft_deleted', '=', 0);
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
        return view('livewire.admin.band-clients', [
            'users' => $this->all_users()
        ]);
    }
}
