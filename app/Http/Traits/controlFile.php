<?php

namespace App\Http\Traits;


use App\Models\Client;
use App\Models\GeneralInfo;
use App\Models\PaymentSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

trait controlFile {
    public function delete_target_file($file) {
        if(File::exists(public_path('uploads/'.$file))){
            File::delete(public_path('uploads/'.$file));
        }
    }
}
