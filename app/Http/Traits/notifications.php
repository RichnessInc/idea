<?php

namespace App\Http\Traits;


use App\Models\Client;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

trait notifications {

    public function createNotification($content, $client_id) {
        if ($client_id != null && $content) {
            Notification::create([
                'content'   => $content,
                'type'      => 0,
                'client_id' => $client_id,
                'user_id'   => 1,
            ]);
        }
    }

}
