<?php

namespace App\Http\Livewire\Admin\Chat\Single;

use App\Events\MyEventSs;
use App\Events\sendMessageFromAdmin;
use App\Events\TestingMessage;
use App\Mail\mainEmail;
use App\Models\Client;
use App\Models\singleRoom;
use App\Models\singleRoomMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

use Livewire\Component;

class Single extends Component
{
    use WithPagination, WithFileUploads;

    public $message;
    public $client_id;
    public $file;

    public function sendMessage() {
        $admin_id      = Auth::user()->id;
        $get_room_id    = singleRoom::where('client_id', '=', $this->client_id)->first()->id;
        if ($this->file != '' && $this->file != null) {
            $name =  md5($this->file . microtime()) . '_'.microtime().'.' . $this->file->extension();
            $this->file->storeAs('/', $name, 'uploads');
            singleRoomMessage::create([
                'client_id' => $this->client_id,
                'room_id'   => $get_room_id,
                'admin_id'  => $admin_id,
                'from'      => 0,
                'message'   => 'file',
                'file'      => $name
            ]);
            if ($this->message != null) {
                singleRoomMessage::create([
                    'client_id' => $this->client_id,
                    'room_id'   => $get_room_id,
                    'admin_id'  => $admin_id,
                    'from'      => 0,
                    'message'   => $this->message
                ]);
            }
            event(new MyEventSs($this->message, $this->client_id, $name));

        } else {
            singleRoomMessage::create([
                'client_id' => $this->client_id,
                'room_id'   => $get_room_id,
                'admin_id'  => $admin_id,
                'from'      => 0,
                'message'   => $this->message
            ]);
            event(new MyEventSs($this->message, $this->client_id));
        }

        Mail::to(Client::findOrFail($this->client_id)->email)->send(new mainEmail(' رسالة جديدة - altaawus', 'يوجد في الدردشة الفردية مع الإدارة حديث قائم حاليا يرجى متابعة الرد', ''));

        $this->message  = null;
        $this->file     = null;
    }

    public function make_it_readed() {
        singleRoomMessage::where('client_id', $this->client_id)
        ->where('from', '=', 1)
        ->update([
            'readed' => 1
        ]);
    }

    public function render()
    {
        $this->make_it_readed();
        $messages = singleRoomMessage::where('client_id', $this->client_id)
        ->orderBy('created_at', 'DESC')
        ->get();
        return view('livewire.admin.chat.single.single', [
            'messages' => $messages
        ]);
    }
}
