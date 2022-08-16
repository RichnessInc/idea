<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notifications extends Component
{
    public function render()
    {
        $rows = Notification::where('client_id', Auth::guard('clients')->user()->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(20);
        Notification::where('client_id', '=',Auth::guard('clients')->user()->id)->where('type', '=', 0)->update([
            'type' => 1
        ]);
        return view('livewire.frontend.notifications', [
            'rows' => $rows
        ]);
    }
}
