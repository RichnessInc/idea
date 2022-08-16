<?php

namespace App\Http\Livewire\Components;

use App\Events\sendMessageToGroupFromClient;
use App\Mail\snedmessage;
use App\Models\Client;
use App\Models\Message;
use App\Models\ProductRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\chatGroup as CG;
use Livewire\WithFileUploads;

class ChatGroup extends Component
{

    use WithFileUploads;
    use LivewireAlert;

    public $gid;
    public $message;
    public $file;
    public function sendMessage() {
        if ($this->file != null || $this->message != null) {
            $client_id      = Auth::guard('clients')->user()->id;
            if ($this->file != null && $this->file != '') {
                $validatedData = $this->validate([
                    'file'                => 'required|mimes:jpeg,png,jpg,gif,webp,rar,zip'
                ]);
                $name = md5($this->file . microtime()) . '_.' . $this->file->extension();
                $this->file->storeAs('/', $name, 'uploads');
                Message::create([
                    'message'       => 'file',
                    'type'          => 1,
                    'client_id'     => $client_id,
                    'group_id'      => $this->gid,
                    'file'          => $name
                ]);
                if ($this->message != null) {
                    Message::create([
                        'message'       => $this->message,
                        'type'          => 0,
                        'client_id'     => $client_id,
                        'group_id'      => $this->gid
                    ]);
                }
                event(new sendMessageToGroupFromClient($this->message, $client_id, $this->gid, Auth::guard('clients')->user()->name, $name));
            } else {
                event(new sendMessageToGroupFromClient($this->message, $client_id, $this->gid, Auth::guard('clients')->user()->name));
                Message::create([
                    'message'       => $this->message,
                    'type'          => 0,
                    'client_id'     => $client_id,
                    'group_id'      => $this->gid
                ]);
            }
            $group = \App\Models\chatGroup::findOrFail($this->gid);
            $buyer = Client::findOrFail($group->buyer_id);
            $provieder = Client::findOrFail($group->provieder_id);
            Mail::to($buyer->email)->send(new snedmessage($buyer->name, $this->gid));
            Mail::to($provieder->email)->send(new snedmessage($provieder->name, $this->gid));
            Mail::to('altaawus2020@gmail.com')->send(new snedmessage('الادمن', $this->gid));
            if ($group->sender_id != null) {
                $sender = Client::findOrFail($group->sender_id);
                Mail::to($sender->email)->send(new snedmessage($sender->name, $this->gid));
            }
            $this->emit('sendMessage');
            $this->message  = null;
            $this->file     = null;
        }
    }
    public function make_it_read() {
        $check = CG::findOrFail($this->gid);
        $getMessages = Message::where('group_id', '=', $this->gid);
        if ($check->buyer_id == Auth::guard('clients')->user()->id) {
            $getMessages->update(['buyer_readed' => 1]);
        } elseif($check->provieder_id == Auth::guard('clients')->user()->id) {
            $getMessages->update(['providers_readed' => 1]);
        } elseif($check->sender_id == Auth::guard('clients')->user()->id) {
            $getMessages->update(['sender_readed' => 1]);
        }
    }
    public function render()
    {
        $get_group = \App\Models\chatGroup::findOrFail($this->gid);
        if ($get_group->sender_id != null) {
            $last_message = Message::where('client_id', '=', $get_group->sender_id)
                ->where('group_id', '=', $this->gid)
               // ->orderBy('created_at', 'DESC')
                ->latest()->first();
        } else {
            $last_message = null;
        }

        $this->make_it_read();

        $messages = Message::with('client:id,name', 'user:id,name')
            ->where('group_id', '=', $this->gid)
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('livewire.components.chat-group', [
            'messages'      => $messages,
            'last_message'  => $last_message,
            'get_group'     => $get_group,
        ]);
    }
    public function out() {
        $chatGroup = \App\Models\chatGroup::with('request')->findOrFail($this->gid);
        $chatGroupReq = ProductRequests::findOrFail($chatGroup->request->id);
        $chatGroupReq->update([
            'sender_id'     => null,
            'senderStatus'  => 0,
        ]);
        $chatGroup->update(['sender_id' => null]);

        $this->alert('success', 'تم استبعاد المندوب', [
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
