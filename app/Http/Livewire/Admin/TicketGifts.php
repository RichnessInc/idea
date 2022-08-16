<?php

namespace App\Http\Livewire\Admin;

use App\Models\Bill;
use App\Models\Client;
use App\Models\GiftTicket;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class TicketGifts extends Component
{
    use LivewireAlert;

    use WithPagination;
    public $createFormVisible   = false;
    public $updateFormVisible   = false;
    public $deleteFormVisible   = false;
    public $searchForm          = '';
    public $value;
    public $password;
    public $repassword;
    public $email;
    public $modelId;
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

    public function resetFormDate() {
        $this->value         = null;
        $this->email         = null;
    }

    public function rules() {
        return [
            'value'          => 'required|numeric',
            'email'         => 'required|email|max:255',
        ];
    }



    public function store() {
       $this->validate();
       $get_client = Client::where('email', '=', $this->email)->first();
       if ($get_client != null) {
            $GiftTicket = GiftTicket::create([
                'client_id' => $get_client->id,
                'reference_number'  => rand(100,999).date('dmY').time()

                ] + $this->modelData());

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
                'client_id'     => $get_client->id,
                'status'        => 0,
                'reference_number'  => rand(100, 999).'-'.rand(100, 999).'-'. date('d-m'),
            ]);
            // $this->storeLog($GiftTicket, GiftTicket::class);
            $this->resetFormDate();
            $this->hideModel();
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
       } else {
            $this->alert('error', 'هذا البريد الالكتروني غير موجود', [
                'position' =>  'cenetr',
                'timer' =>  4000,
                'toast' =>  true,
                'text' =>  '',
                'confirmButtonText' =>  'Ok',
                'cancelButtonText' =>  'Cancel',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  false,
            ]);
        }
        return redirect()->route('dashboard.ticket-gifts');

    }

    public function update() {
        $validatedData = $this->validate([
            'value'          => 'required|numeric',

        ]);

        $row = GiftTicket::findOrFail($this->modelId);
        $GiftTicket = $row->update($this->updateModelData());
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
        return redirect()->route('dashboard.ticket-gifts');
     }

     public function destroy() {
        $GiftTicket = GiftTicket::findOrFail($this->modelId);
        $GiftTicket->update(['soft_deleted' => 1]);
        // $this->storeLog($GiftTicket, GiftTicket::class);
        $this->hideModel();
        $this->alert('success', 'تم حذف التذكرة بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
         return redirect()->route('dashboard.ticket-gifts');
    }

    public function hideModel() {
        $this->createFormVisible = false;
        $this->updateFormVisible = false;
        $this->deleteFormVisible = false;
        return redirect()->route('dashboard.ticket-gifts');
    }

    public function all_users() {
        $row = GiftTicket::with('client:id,name')->where('soft_deleted', '=', 0);
        if ($this->searchForm != '') {
            $DATA = $this->searchForm;
            return $row->where('name', 'LIKE', "%{$DATA}%")->paginate(20);

        } else {
            return $row->orderBy('created_at', 'DESC')->paginate(20);
        }
    }
    public function render()
    {
        return view('livewire.admin.ticket-gifts', [
            'rows' => $this->all_users()
        ]);
    }
}
