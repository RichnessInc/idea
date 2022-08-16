<?php

namespace App\Http\Livewire\Admin\Chat\Single;

use App\Models\singleRoom;
use Livewire\Component;
use Livewire\WithPagination;

class All extends Component
{
    use WithPagination;
    public $search;
    public function get_unreaded_count() {
        return singleRoom::whereHas('messages', function($q) {
            return $q->where('from', '=', 0)->where('readed', '=', 0);
        })->get();
    }
    public function render()
    {
        $unreaded = singleRoom::with('client:id,name,email')->whereHas('messages', function($q) {
            return $q->where('from', '=', 1)->where('readed', '=', 0);
        });
        if ($this->search != '') {
            $data = $this->search;
            $unreaded = $unreaded->whereHas('client', function($q) use($data) {
                return $q->where('name', 'LIKE', "%{$data}%")
                    ->orWhere('email', '=', $data);
            });
        }
        $unreaded = $unreaded->get();
        $UDs = [];
        foreach ($unreaded as $item) {
            $UDs[] = $item->id;
        }
        $chats = singleRoom::with('client:id,name,email');
        $chats = $chats->whereNotIn('id', $UDs);
        if ($this->search != '') {
            $data = $this->search;

            $chats = $chats->whereHas('client', function($q) use($data) {
                return $q->where('name', 'LIKE', "%{$data}%")
                    ->orWhere('email', '=', $data);
            });
        }
        $chats = $chats->paginate(100);

        return view('livewire.admin.chat.single.all', [
            'chats'     => $chats,
            'unread'    => $this->get_unreaded_count(),
            'unreaded' => $unreaded

        ]);
    }
}
