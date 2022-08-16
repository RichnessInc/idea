<?php

namespace App\Http\Controllers;

use App\Models\PaymentSetting;
use Illuminate\Http\Request;

class PaymentSettings extends Controller
{

    public function update(Request $request) {
        $row = PaymentSetting::findOrFail(1);
        $data = $request->all();
        unset($data[0]);

        $user = $row->update($data);
        // $this->storeLog($user, User::class, $row);
        return redirect()->route('dashboard.payment.settings');

    }
}
