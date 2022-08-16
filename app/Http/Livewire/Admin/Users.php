<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use LivewireAlert;

    use WithPagination;
    public $createFormVisible   = false;
    public $updateFormVisible   = false;
    public $deleteFormVisible   = false;
    public $chatOnModelVisible  = false;
    public $searchForm          = null;
    public $name;
    public $password;
    public $repassword;
    public $email;
    public $modelId;
    public $chat_on;
    public $showPassword            = false;

    public function showPasswordF() {
        if ($this->showPassword == true) {
            $this->showPassword = false;
        } else {
            $this->showPassword = true;
        }
    }
    public function createShowModel() {
        $this->resetFormDate();
        $this->createFormVisible = true;
    }
    public function confirmUserDelete($id) {
        $this->deleteFormVisible = true;
        $this->modelId = $id;

    }
    public function confirmUserChatOn($id) {
        $this->chatOnModelVisible = true;
        $this->modelId = $id;

    }
    public function showUpdateModel($id) {
        $this->updateFormVisible = true;
        $this->modelId = $id;
        $this->loadModelData();
    }

    public function modelData() {
        return [
            'name'      => $this->name,
            'email'     => $this->email,
            'password'  => Hash::make($this->password),
        ];
    }
    public function updateModelData() {
        return [
            'name'      => $this->name,
            'email'     => $this->email,
        ];
    }
    public function loadModelData() {
        $data = User::find($this->modelId);
        $this->name = $data->name;
        $this->email = $data->email;
    }

    public function resetFormDate() {
        $this->name         = null;
        $this->password     = null;
        $this->repassword   = null;
        $this->email        = null;
    }

    public function rules() {
        return [
            'name'          => 'required|max:255',
            'email'         => 'required|unique:users|max:255',
            'password'      => 'required|max:255|min:8',
            'repassword'    => 'required|same:password',
        ];
    }



    public function store() {
       $this->validate();
       $user = User::create($this->modelData());
       // $this->storeLog($user, User::class);
       $this->resetFormDate();
       $this->hideModel();
       $this->alert('success', 'تم انشاء المشرف بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('dashboard.users');
    }

    public function update() {
        $validatedData = $this->validate([
            'name'          => 'required|max:255',
            'email'         => 'required|max:255|unique:users,email,'.$this->modelId,
            // 'password'         => 'nullable|max:255|min:8',
            // 'repassword'         => 'nullable|max:255|min:8|same:password',
        ]);

        $row = User::findOrFail($this->modelId);

        $password = ($this->password != null ? ['password' => Hash::make($this->repassword)] : []);
        $user = $row->update($password + $this->updateModelData());
        // $this->storeLog($user, User::class, $row);
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم تعديل المشرف بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
        return redirect()->route('dashboard.users');

     }

     public function destroy() {
        $user = User::findOrFail($this->modelId);
        $user->update(['soft_deleted' => 1]);
        // $this->storeLog($user, User::class);
        $this->hideModel();
        $this->alert('success', 'تم حذف المشرف بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
         return redirect()->route('dashboard.users');

    }

    public function UserChatOn() {
        $user = User::findOrFail($this->modelId);
        // $this->storeLog($user, User::class);
        if ($user->chat_on == 0) {
            $user->update(['chat_on' => 1]);
        } else {
            $user->update(['chat_on' => 0]);
        }
        $this->hideModel();
        $this->alert('success', 'تم فتح امكانية الدردشة للمشرف', [
            'position' =>  'cenetr',
            'timer' =>  4000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('dashboard.users');

    }

    public function hideModel() {
        $this->createFormVisible    = false;
        $this->updateFormVisible    = false;
        $this->deleteFormVisible    = false;
        $this->chatOnModelVisible   = false;
        return redirect()->route('dashboard.users');

    }

    public function all_users() {
        if ($this->searchForm != '') {
            return User::where('email', '=', $this->searchForm)
                ->where('soft_deleted', '=', 0)
                ->paginate(20);

        } else {
            return User::where('soft_deleted', '=', 0)->orderBy('created_at', 'DESC')->paginate(20);
        }
    }

    public function render()
    {
        return view('livewire.admin.users', [
            'users'         => $this->all_users()
        ]);
    }
}
