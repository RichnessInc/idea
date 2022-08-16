<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Client;
use App\Models\clientsResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Login extends Component
{
    use LivewireAlert;

    public $email;
    public $password;
    public $remember;
    public $showPassword            = false;
    public $forget_password_visible = false;
    public function showPasswordF() {
        if ($this->showPassword == true) {
            $this->showPassword = false;
        } else {
            $this->showPassword = true;
        }
    }
    public function login() {
        $validatedData = $this->validate([
            'email'             => 'required|email',
            'password'          => 'required|max:255|min:8',
        ]);

        $credentials = [
            'email'              => $this->email,
            'password'           => $this->password,
        ];
        $rem = ($this->remember == true ? true : false);
        if (Auth::guard('clients')->attempt($credentials, $rem)) {

            if (Auth::guard('clients')->user()->status != 0) {
                return redirect('/profile');
            } else {
                $this->alert('error', 'تم حظر حسابك', [
                    'position' =>  'center',
                    'timer' =>  3000,
                    'toast' =>  true,
                    'text' =>  null,
                    'confirmButtonText' =>  'Ok',
                    'cancelButtonText' =>  'Cancel',
                    'showCancelButton' =>  false,
                    'showConfirmButton' =>  false,
                ]);
            }
        } else {
            $this->alert('error', 'البيانات خاطئة', [
                'position' =>  'center',
                'timer' =>  3000,
                'toast' =>  true,
                'text' =>  null,
                'confirmButtonText' =>  'Ok',
                'cancelButtonText' =>  'Cancel',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  false,
            ]);
        }
    }
    public function forget_password() {
        $this->forget_password_visible = true;
    }
    public function hideModel() {
        $this->forget_password_visible = false;
    }
    public function forget_password_fun() {
        $check = Client::where('email', '=', $this->email)->first();
        if ($check != null) {
            $checkClientsResetPassword = clientsResetPassword::where('email', '=', $this->email)->first();
            if ($checkClientsResetPassword == null) {
                $data = clientsResetPassword::create([
                    'email'         => $this->email,
                    'token'         => strtolower(Str::random(16)),
                    'created_at'    => now()
                ]);
                Mail::to($this->email)->send(new \App\Mail\resetPassword($data->token));
                $this->alert('success', 'تم ارسال رسالة الى بريدك الالكتروني', [
                    'position' =>  'center',
                    'timer' =>  3000,
                    'toast' =>  true,
                    'text' =>  null,
                    'confirmButtonText' =>  'Ok',
                    'cancelButtonText' =>  'Cancel',
                    'showCancelButton' =>  false,
                    'showConfirmButton' =>  false,
                ]);
            } else {
                Mail::to($this->email)->send(new \App\Mail\resetPassword($checkClientsResetPassword->token));
                $this->alert('success', 'تم ارسال رسالة الى بريدك الالكتروني', [
                    'position' =>  'center',
                    'timer' =>  3000,
                    'toast' =>  true,
                    'text' =>  null,
                    'confirmButtonText' =>  'Ok',
                    'cancelButtonText' =>  'Cancel',
                    'showCancelButton' =>  false,
                    'showConfirmButton' =>  false,
                ]);
            }
        } else {
            $this->alert('error', 'البيانات خاطئة', [
                'position' =>  'center',
                'timer' =>  3000,
                'toast' =>  true,
                'text' =>  null,
                'confirmButtonText' =>  'Ok',
                'cancelButtonText' =>  'Cancel',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  false,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.frontend.login');
    }
}
