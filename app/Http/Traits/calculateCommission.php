<?php

namespace App\Http\Traits;


use App\Models\Client;
use App\Models\GeneralInfo;
use App\Models\PaymentSetting;
use Illuminate\Support\Facades\Auth;

trait calculateCommission {

    public function get_commission($client) {
        if ($client->spasial_com != null) {
            return $client->spasial_com;
        } else {
            $allComs = PaymentSetting::first();
            if ($client->type == 1) {
                return $allComs->provider_commission;
            } else if ($client->type == 2) {
                return $allComs->handmade_commission;
            } else {
                return false;
            }
        }
    }

    public function calculate_commission($client_id, $item_price) {
        $client     = Client::where('id', '=',$client_id)->first();
        $commission = ($this->get_commission($client) != false ? $this->get_commission($client) : false);
        $value      = ($commission != false ? ($item_price * $commission) / 100 : false);
        return $value;
    }

    public function calculate_marketer_commission($item_price) {
        return PaymentSetting::first()->cashback_commission;
    }
}
