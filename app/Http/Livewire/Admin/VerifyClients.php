<?php

namespace App\Http\Livewire\Admin;

use App\Mail\standardEmail;
use App\Models\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class VerifyClients extends Component
{
    use WithPagination;
    use LivewireAlert;
    use \App\Http\Traits\notifications;

    public $searchForm          = '';
    public $email;
    public $modelId;
    public $myFiles;
    public $rejectFormVisible   = false;
    public $banFormVisible      = false;

    protected $listeners = [
        'mainTrigger'   => 'mainTrigger',
        'download'      => 'download'
    ];

    public function mainTrigger() {
        $this->emit('editTrigger');
    }

    public function download($fileName) {
        return response()->download(public_path('uploads/'.$fileName));
    }
    public function confirmReject($id) {
        $this->rejectFormVisible = true;
        $this->modelId = $id;
    }
    public function banFun($id) {
        $this->banFormVisible = true;
        $data = Client::find($id);
        $this->myFiles              = $data->files;
    }
    public function reject() {
        $client = Client::findOrFail($this->modelId);
        $client->update(['verified' => 1]);
        $this->createNotification('تم تفعيل حسابك بنجاح - تستطيع الان اضافة منتجاتك', $this->modelId);
        Mail::to($client->email)->send(new standardEmail(
            'تم تفعيل حسابك بنجاح - تستطيع الان اضافة منتجاتك',
            'تم تفعيل حسابك بنجاح - الطاووس',
            'الموقع',
            URL::to('/')
        ));
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
    }

    public function hideModel() {
        $this->rejectFormVisible    = false;
        $this->banFormVisible       = false;
        $this->myFiles              = false;
    }
    public function all_users() {
        $data = $this->searchForm;
        $clients = new Client();
        if ($this->searchForm != '') {
            $clients = $clients->where('email', '=', $data);
        }
        return $clients->where('verified', '=', 0)->where('soft_deleted', '=', 0)->orderBy('created_at', 'DESC')->paginate(20);

    }

    public function render()
    {
        return view('livewire.admin.verify-clients', [
            'users' => $this->all_users()
        ]);
    }
}
