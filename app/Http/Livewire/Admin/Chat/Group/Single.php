<?php

namespace App\Http\Livewire\Admin\Chat\Group;

use App\Events\sendMessageToGroupFromClient;
use App\Mail\CreatedRoom;
use App\Mail\snedmessage;
use App\Models\chatGroup;
use App\Models\Client;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;

class Single extends Component
{
    use WithFileUploads;

    public $gid;
    public $message;
    public $file;
    public function sendMessage() {
        $client_id      = Auth::user()->id;
        if ($this->file != null && $this->file != '') {
            $name = md5($this->file . microtime()) . '_.' . $this->file->extension();
            $this->file->storeAs('/', $name, 'uploads');
            Message::create([
                'message'       => 'file',
                'type'          => 1,
                'user_id'     => $client_id,
                'group_id'      => $this->gid,
                'file'          => $name
            ]);
            if ($this->message != null) {
                Message::create([
                    'message'       => $this->message,
                    'type'          => 0,
                    'user_id'     => $client_id,
                    'group_id'      => $this->gid
                ]);
            }
            event(new sendMessageToGroupFromClient($this->message, $client_id, $this->gid, 'الإدارة', $name));
        } else {
            Message::create([
                'message'       => $this->message,
                'type'          => 0,
                'user_id'     => $client_id,
                'group_id'      => $this->gid
            ]);
            event(new sendMessageToGroupFromClient($this->message, $client_id, $this->gid, 'الإدارة'));

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

    public function make_it_readed() {
        Message::where('user_id', '=', null)
            ->where('user_readed', '=', 0)
            ->where('group_id', '=', $this->gid)
            ->update([
                'user_readed' => 1
            ]);
    }

    public function render()
    {
        $this->make_it_readed();
        $messages = Message::with('client:id,name', 'user:id,name')
            ->where('group_id', '=', $this->gid)
            ->orderBy('created_at', 'DESC')
            ->get();
            return view('livewire.admin.chat.group.single', [
            'messages' => $messages
        ]);
    }
}
