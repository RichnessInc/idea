<?php

namespace App\Http\Livewire\Admin\Profet;

use App\Models\GeneralInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Login extends Component
{
    use LivewireAlert;

    public $password;
    public $showPassword = false;

    public function showPasswordF() {
        if ($this->showPassword == true) {
            $this->showPassword = false;
        } else {
            $this->showPassword = true;
        }
    }
    public function login() {
        $validatedData = $this->validate([
            'password'          => 'required|max:255|min:8',
        ]);
        $nowPassword = GeneralInfo::findOrFail(1)->profits_section_password;
        if (Hash::check($this->password,$nowPassword)) {
            session()->push('go_to_profits', true);
            if(session()->get('go_to_profits')[0] == true) {
                return redirect()->route('admin.profit.index');
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
        return view('livewire.admin.profet.login');
    }
}
