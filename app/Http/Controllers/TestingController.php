<?php

namespace App\Http\Controllers;

use App\Http\Traits\BillTrait;
use App\Http\Traits\PayPalTrait;
use App\Models\Address;
use App\Models\Bill;
use App\Models\clientsResetPassword;
use App\Models\Gift;
use App\Models\Product;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class TestingController extends Controller
{

    use PayPalTrait;

    public function sendMessage()
    {

    }

    public function testing_response() {

    }

    public function reset_password($token) {
        $checkClientsResetPassword = clientsResetPassword::where('token', '=', $token)->first();
        if ($checkClientsResetPassword != null) {
            return redirect()->route('reset_password.new', $token);
        } else {
            return redirect('/');
        }
    }
}
