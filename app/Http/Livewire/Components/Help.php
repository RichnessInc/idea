<?php

namespace App\Http\Livewire\Components;

use App\Mail\mainEmail;
use App\Models\singleRoom;
use App\Models\singleRoomMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use App\Events\MyEventSs;
use Livewire\WithFileUploads;

class Help extends Component
{
    use WithFileUploads;
    public $message;
    public $file;

    public function sendMessage() {
        if ($this->file != null || $this->message != null) {
            $client_id = Auth::guard('clients')->user()->id;
            $get_room_id = singleRoom::where('client_id', '=', $client_id)->first()->id;
            if ($this->file != null && $this->file != '') {
                $validatedData = $this->validate([
                    'file' => 'required|mimes:jpeg,png,jpg,gif,webp,rar,zip'
                ]);
                $name = md5($this->file . microtime()) . '_.' . $this->file->extension();
                $this->file->storeAs('/', $name, 'uploads');
                singleRoomMessage::create([
                    'client_id' => $client_id,
                    'room_id' => $get_room_id,
                    'admin_id' => 1,
                    'from' => 1,
                    'message' => 'file',
                    'file' => $name
                ]);
                if ($this->message != null) {
                    singleRoomMessage::create([
                        'client_id' => $client_id,
                        'room_id' => $get_room_id,
                        'admin_id' => 1,
                        'from' => 1,
                        'message' => $this->message,
                    ]);
                }
                event(new MyEventSs($this->message, $client_id, $name));
            } else {
                singleRoomMessage::create([
                    'client_id' => $client_id,
                    'room_id' => $get_room_id,
                    'admin_id' => 1,
                    'from' => 1,
                    'message' => $this->message
                ]);
                event(new MyEventSs($this->message, $client_id));
            }
            Mail::to('altaawus2020@gmail.com')->send(new mainEmail(' رسالة جديدة - altaawus', 'يوجد في الدردشة الفردية مع الإدارة حديث قائم حاليا يرجى متابعة الرد', ''));
            $this->emit('sendMessage');
            $this->message = null;
            $this->file = null;
        }
    }

    public function make_it_readed() {
        singleRoomMessage::where('client_id', Auth::guard('clients')->user()->id)
        ->where('from', '=', 0)
        ->update([
            'readed' => 1
        ]);
    }
    public function render()
    {
        $this->make_it_readed();
        $messages = singleRoomMessage::where('client_id', Auth::guard('clients')->user()->id)
        ->orderBy('created_at', 'DESC')
        ->get();
        return view('livewire.components.help', [
            'messages' => $messages
        ]);
    }
}
