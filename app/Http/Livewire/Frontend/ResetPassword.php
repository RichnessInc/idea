<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Client;
use App\Models\clientsResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
class ResetPassword extends Component
{

    use LivewireAlert;

    public $password;
    public $conform_password;
    public $token;
    public $showPassword = false;

    public function showPasswordF()
    {
        if ($this->showPassword == true) {
            $this->showPassword = false;
        } else {
            $this->showPassword = true;
        }
    }

    public function login()
    {
        $validatedData = $this->validate([
            'password' => 'required|max:255',
            'conform_password' => 'required|max:255|min:8|same:password',
        ]);
        $checkClientsResetPassword = clientsResetPassword::where('token', '=', $this->token)->first();
        if ($checkClientsResetPassword != null) {
            Client::where('email', '=', $checkClientsResetPassword->email)->update([
                'password'  => Hash::make($this->password)
            ]);
            $checkClientsResetPassword->delete();
            return redirect('/login');
        } else {
            return redirect('/');
        }
    }

    public function render()
    {
        //dd($this->token);
        return view('livewire.frontend.reset-password');
    }
}
