<?php

namespace App\Http\Livewire\Admin\Chat\Group;

use App\Models\chatGroup;
use App\Models\Message;
use Livewire\Component;

class All extends Component
{
    public function get_unreaded_count() {
        return chatGroup::whereHas('messages', function($q) {
            return $q->where('user_id', '=', null)->where('user_readed', '=', 0);
        })->get();
    }
    public function render()
    {

        $unreaded = chatGroup::with('buyer:id,name,email', 'provieder:id,name,email', 'sender:id,name,email', 'request.product:id,name')
            ->whereHas('messages', function($q) {
            return $q->where('user_id', '=', null)->where('user_readed', '=', 0);
        });
        $unreaded = $unreaded->get();
        $UDs = [];
        foreach ($unreaded as $item) {
            $UDs[] = $item->id;
        }

        $groups = chatGroup::with('buyer:id,name,email', 'provieder:id,name,email', 'sender:id,name,email', 'request.product:id,name')
            ->whereNotIn('id', $UDs)
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('livewire.admin.chat.group.all', [
            'groups' => $groups,
            'unread'    => $this->get_unreaded_count(),
            'unreaded' => $unreaded

        ]);
    }
}
