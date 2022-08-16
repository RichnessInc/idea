<?php

namespace App\Http\Traits;

use App\Models\Client;
use App\Models\pointsCommission;
use App\Models\pointsCommissionRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

trait PointsSystem {
    use notifications;
    public function plusPoints($client_id, $points) {
        $points = intval(round($points));
        $client = Client::findOrFail($client_id);
        $get_type = $client->type;
        $exPoints = $client->points + $points;
        $commissions = pointsCommission::where('soft_deleted', '=', 0)->where('type', '=', $get_type)->where('points', '<=', $exPoints)->get();
        foreach ($commissions as $commission) {
            $check = pointsCommissionRequest::where('client_id', '=', $client_id)->where('type_id', '=', $commission->id)->first();
            if ($check == null) {
                pointsCommissionRequest::create([
                    'type_id' => $commission->id,
                    'client_id' => $client_id
                ]);
                Mail::to(['altaawus2020@gmail.com', $client->email])->send(new \App\Mail\pointsRequest());
            }
        }
        $client->update([
            'points'    => $client->points + $points
        ]);
        $content = " تمت اضافة  ".$points."  نقطة لحسابك " . ' لأخر منتج تم التعامل عليه ';
        $this->createNotification($content, $client_id);
    }
}
