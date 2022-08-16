<?php

namespace App\Http\Livewire\Components;

use App\Models\chatGroup;
use App\Models\singleRoom;
use App\Models\singleRoomMessage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{
    public function get_unreaded_count() {
        if (Auth::guard('clients')->check()) {
            return singleRoomMessage::where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('from', '=', 1)
            ->where('readed', '=', 0)
            ->count();
        } else {
            return false;
        }

    }
    public function render()
    {
        if (Auth::guard('clients')->check()) {
            $unreaded_buyer = chatGroup::with('request.product:id,name', 'collection_request.product:id,name')
                ->where('buyer_id', '=', Auth::guard('clients')->user()->id)
                ->whereHas('messages', function ($q) {
                    return $q->where('client_id', '=', null)->where('buyer_readed', '=', 0)->orderBy('created_at', 'DESC');
                })->orderBy('created_at', 'DESC')->get();

        if (Auth::guard('clients')->user()->type == 1 || Auth::guard('clients')->user()->type == 2) {
            $unreaded = chatGroup::with('request.product:id,name', 'collection_request.product:id,name')
                ->where('provieder_id', '=', Auth::guard('clients')->user()->id)
                ->whereHas('messages', function ($q) {
                    return $q->where('client_id', '=', null)->where('providers_readed', '=', 0);
                })->orderBy('created_at', 'DESC')->get();
        } elseif (Auth::guard('clients')->user()->type == 3) {
            $unreaded = chatGroup::with('request.product:id,name', 'collection_request.product:id,name')
                ->where('sender_id', '=', Auth::guard('clients')->user()->id)
                ->whereHas('messages', function ($q) {
                    return $q->where('client_id', '=', null)->where('sender_readed', '=', 0);
                })->orderBy('created_at', 'DESC')->get();
        } else {
            $unreaded = [];
        }
    } else {
            $unreaded = [];
            $unreaded_buyer = [];

        }
        return view('livewire.components.navbar', [
            'havemessage' => $this->get_unreaded_count(),
            'unreaded_buyer' => $unreaded_buyer,
            'unreaded' => $unreaded,
        ]);
    }
}
