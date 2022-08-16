<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Bill;
use App\Models\GiftTicket;
use App\Models\mainPage;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Ticket extends Component
{
    use LivewireAlert, WithPagination;

    public $createFormVisible = false;
    public $value;
    public $password;
    public $repassword;
    public $deleteFormVisible = false;
    public $modelId;
    public $showPassword            = false;
    public $updateFormVisible   = false;

    public function showPasswordF() {
        if ($this->showPassword == true) {
            $this->showPassword = false;
        } else {
            $this->showPassword = true;
        }
    }

    public function confirmUserDelete($id) {
        $this->deleteFormVisible = true;
        $this->modelId = $id;

    }
    public function showUpdateModel($id) {
        $this->updateFormVisible = true;
        $this->modelId = $id;
        $this->loadModelData();
    }
    public function modelData() {
        return [
            'value'      => $this->value,
            'password'      => Hash::make($this->password),
        ];
    }
    public function updateModelData() {
        return [
            'value'      => $this->value,
            'password'      => Hash::make($this->password),
        ];
    }
    public function loadModelData() {
        $data = GiftTicket::find($this->modelId);
        $this->value = floor($data->value);
    }

    public function store() {
    if (Auth::guard('clients')->check()) {
        $validatedData = $this->validate([
            'value'          => 'required',
            'password'          => 'required',
            'repassword'          => 'required|same:password',


        ]);
        $GiftTicket = GiftTicket::create([
            'client_id' => Auth::guard('clients')->user()->id,
            'password'  => Hash::make($this->password),
            'value'     => $this->value,
            'reference_number'  => rand(100,999).date('dmY').time()
        ]);
        $item = [
            'name'      => 'قسيمة شراء مسبقة الدفع',
            'price'     => $this->value,
            'model'     => GiftTicket::class,
            'item_id'   => $GiftTicket->id
        ];
        Bill::create([
            'item_data'     => json_encode($item),
            'item_price'    => $this->value,
            'shipping'      => 0,
            'total_price'   => $this->value,
            'client_id'     => Auth::guard('clients')->user()->id,
            'status'        => 0,
            'reference_number'  => rand(100, 999).'-'.rand(100, 999).'-'. date('d-m'),
        ]);
        $this->alert('success', 'تم انشاء التذكرة بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        $this->hideModel();
        return redirect()->route('frontend.cart');

    }
}
    public function update() {
        $validatedData = $this->validate([
            'value'             => 'required',
            'password'          => 'required|string',
            'repassword'        => 'required|string|same:password',

        ]);

        $row = GiftTicket::findOrFail($this->modelId);
        $GiftTicket = $row->update($this->updateModelData() + ($this->password != null ? ['password' => Hash::make($this->password)] : []));
        // $this->storeLog($GiftTicket, GiftTicket::class, $row);
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم تعديل التذكرة بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
    }

public function createShowModel() {
 //   $this->resetFormDate();
    $this->createFormVisible = true;
}
public function resetFormDate() {
    $this->value        = null;
    $this->password     = null;
    $this->repassword   = null;

}
public function hideModel() {
    $this->createFormVisible = false;
    $this->deleteFormVisible = false;
    return redirect()->route('frontend.ticket');
    }
    public function destroy()
    {
        $GiftTicket = GiftTicket::findOrFail($this->modelId);
        $GiftTicket->update(['soft_deleted' => 1]);
        // $this->storeLog($GiftTicket, GiftTicket::class);
        $this->hideModel();
        $this->alert('success', 'تم حذف التذكرة بنجاح', [
            'position' => 'cenetr',
            'timer' => 3000,
            'toast' => true,
            'text' => '',
            'confirmButtonText' => 'Ok',
            'cancelButtonText' => 'Cancel',
            'showCancelButton' => false,
            'showConfirmButton' => false,
        ]);
        return redirect()->route('frontend.ticket');

    }

    public function render()
    {
        return view('livewire.frontend.ticket', [
            'rows'  => GiftTicket::where('client_id', Auth::guard('clients')->user()->id)->where('soft_deleted', '=', 0)->orderBy('created_at', 'DESC')->paginate(20),
            'pageInfo'      => mainPage::where('slug', '=', 'ticket')->first(),
        ]);
    }
}
