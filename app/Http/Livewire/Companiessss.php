<?php

namespace App\Http\Livewire;

use App\Models\clientsResetPassword;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Companiessss extends Component
{
    use LivewireAlert;

    public $password;
    public $conform_password;
    public $token;
    public $showPassword            = false;
    public function showPasswordF() {
        if ($this->showPassword == true) {
            $this->showPassword = false;
        } else {
            $this->showPassword = true;
        }
    }
    public function login() {
        $validatedData = $this->validate([
            'password'                  => 'required|email',
            'conform_password'          => 'required|max:255|min:8|same:password',
        ]);
        $checkClientsResetPassword = clientsResetPassword::where('token', '=', $this->token)->first();
        if ($checkClientsResetPassword != null) {
           // clientsResetPassword::
            }
    }
    public function render()
    {
        //dd($this->token);
        return view('livewire.companiessss');
    }
}
