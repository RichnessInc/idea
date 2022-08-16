<?php

namespace App\Http\Livewire\Admin;

use App\Http\Traits\controlFile;
use App\Models\Address;
use App\Models\Client;
use App\Models\Country;
use App\Models\Government;
use App\Models\Product;
use App\Models\singleRoom;
use App\Models\singleRoomMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;

class Clients extends Component
{
    use LivewireAlert;
    use WithPagination;
    use WithFileUploads;
    use controlFile;
    public $createFormVisible   = false;
    public $updateFormVisible   = false;
    public $deleteFormVisible   = false;
    public $searchForm          = '';
    public $name;
    public $password;
    public $repassword;
    public $email;
    public $modelId;
    public $country_id;
    public $government_id;
    public $whatsapp_phone;
    public $wallet;
    public $points;
    public $debt;
    public $shift_from;
    public $shift_to;
    public $serv_aval_in;
    public $ref;
    public $spasial_com;
    public $spare_phone;
    public $files;
    public $governorates = null;
    public $type;
    ////////////////////////////
    public $street;
    public $build_no;
    public $sector;
    public $floor;
    public $unit_no;
    public $details;
    public $showSpinner = false;
    public $myFiles;
    public $balanceModelVisible = false;
    public $updatePasswordFormVisible = false;
    public $recordData;
    public $showPassword            = false;


    protected $listeners = [
        'mainTrigger'   => 'mainTrigger',
        'download'      => 'download'
    ];
    public function showPasswordF() {
        if ($this->showPassword == true) {
            $this->showPassword = false;
        } else {
            $this->showPassword = true;
        }
    }
    public function mainTrigger() {
        $this->emit('editTrigger');
    }

    public function balanceModel() {
        $this->balanceModelVisible = true;

    }
    public function balanceFun() {
        $clients = Client::where('soft_deleted', '=', 0)
            ->where('type', '=', 1)
            ->orWhere('type', '=', 2)
            ->orWhere('type', '=', 3)->get();
        foreach ($clients as $client) {
            if ($client->wallet >= $client->debt) {
                $total = $client->wallet - $client->debt;
                $client->update([
                    'wallet'    => $total,
                    'debt'      => 0
                ]);
            }else if ($client->debt > $client->wallet) {
                if ($client->wallet > 0) {
                    $total = $client->debt - $client->wallet;
                    $client->update([
                        'wallet'    => 0,
                        'debt'      => $total
                    ]);
                }

            }
        }
        $this->alert('success', 'تم تسوية الديون بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        $this->balanceModelVisible = false;
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


    public function country_change() {
        $this->governorates = Government::where('country_id', '=', $this->country_id)->where('soft_deleted', '=', 0)->get();
    }

    public function addressData() {
        return [
            'street'                => $this->street,
            'build_no'              => $this->build_no,
            'sector'                => $this->sector,
            'floor'                 => $this->floor,
            'unit_no'               => $this->unit_no,
            'details'               => $this->details,
            'government_id'         => $this->government_id,
            'country_id'            => $this->country_id,
        ];
    }

    public function modelData() {
        return [
            'name'              => $this->name,
            'email'             => $this->email,
            'type'              => $this->type,
            'government_id'     => $this->government_id,
            'country_id'        => $this->country_id,
            'whatsapp_phone'    => $this->whatsapp_phone,
            'spare_phone'       => $this->spare_phone,

        ];
    }

    public function store() {
        $validatedData = $this->validate([
            'name'              => 'required|min:4|max:255',
            'whatsapp_phone'    => 'required|unique:clients',
            'email'             => 'required|email|unique:clients',
            'type'              => 'required|numeric',
            'government_id'     => 'required|numeric',
            'country_id'        => 'required|numeric',
            'password'          => 'required|max:255|min:8',
            'repassword'        => 'required|max:255|min:8|same:password',
            //////////////////////////////////////////////////////////////
            'street'            => 'required|string|max:255',
            'build_no'          => 'required|numeric',
            'sector'            => 'required|string|max:255',
            'floor'             => 'required|numeric',
            'unit_no'           => 'required|numeric',
            'details'           => 'required|string|max:255',
            'spare_phone'           => 'required|string|max:255',
        ]);
        $filesNames = [];
        if($this->type != 0 && $this->files != '') {
            foreach ($this->files as $file) {
                $name =  md5($file . microtime()) . '_.' . $file->extension();
                $file->storeAs('/', $name, 'uploads');
                $filesNames[] = $name;
            }
            $files = ['files' => implode(',', $filesNames)];
        } else {
            $files = ['files' => null];
        }
        // Add Client
        $password   = ['password'   => Hash::make($this->password)];
        $token = openssl_random_pseudo_bytes(16);
        //Convert the binary data into hexadecimal representation.
        $token = bin2hex($token);
        $details = [
            'title' => 'بيريد تفعيل البريد الالكتروني',
            'body' => $token
        ];
        //Mail::to($this->email)->send(new \App\Mail\verifyMail($details));
        $client = Client::create($password + ['verify_email_token' => $token ] + ['ref' => Str::random(10).rand(20,30).date('dmY')] + $files + $this->modelData());
        /// Add Address.php
        $Address = Address::create($this->addressData() + ['client_id' => $client->id]);
        // Make Chat Room With Mangement
        $room = singleRoom::create([
            'client_id' => $client->id
        ]);
        singleRoomMessage::create([
            'client_id' => $client->id,
            'room_id'   => $room->id,
            'message'   => 'مرحبا بك في موقع الطاووس',
        ]);

        $client->update(['address_id' => $Address->id]);
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم اضافة العضو بنجاح', [
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

    public function updateModelData() {
        return [
        'name'            => $this->name,
        'email'           => $this->email,
        'whatsapp_phone'  => $this->whatsapp_phone,
        'wallet'          => floor($this->wallet),
        'points'          => $this->points,
        'debt'            => floor($this->debt),
        'shift_from'      => $this->shift_from,
        'shift_to'        => $this->shift_to,
        'spare_phone'     => $this->spare_phone,
        'spasial_com'     => $this->spasial_com,
        ];
    }
    public function loadModelData() {
        $data = Client::find($this->modelId);
        $this->name                 = $data->name;
        $this->email                = $data->email;
        $this->country_id           = $data->country_id;
        $this->whatsapp_phone       = $data->whatsapp_phone;
        $this->spare_phone          = $data->spare_phone;
        $this->wallet               = floor($data->wallet);
        $this->points               = $data->points;
        $this->debt                 = floor($data->debt);
        $this->shift_from           = $data->shift_from;
        $this->shift_to             = $data->shift_to;
        $this->spasial_com          = $data->spasial_com;
        $this->ref                  = URL::to('/register'). '?ref='.$data->ref;
        $this->myFiles              = $data->files;
    }

    public function resetFormDate() {
        $this->name                 = null;
        $this->email                = null;
        $this->whatsapp_phone       = null;
        $this->wallet               = null;
        $this->points               = null;
        $this->debt                 = null;
        $this->shift_from           = null;
        $this->shift_to             = null;
        $this->spasial_com          = null;
        $this->ref                  = null;
        $this->files                = null;
       $this->street                = null;
       $this->build_no              = null;
       $this->sector                = null;
       $this->floor                 = null;
       $this->unit_no               = null;
       $this->details               = null;
       $this->government_id         = null;
       $this->country_id            = null;
        $this->spare_phone          = null;
        $this->myFiles          = null;

    }
    public function showUpdatePasswordModel($id) {
        $this->modelId = $id;
        $this->recordData = Client::findOrFail($id);
        $this->updatePasswordFormVisible = true;
    }
    public function update() {
        $row = Client::findOrFail($this->modelId);
        $Client = $row->update([
            'name'            => $this->name,
            'email'           => $this->email,
            'whatsapp_phone'  => $this->whatsapp_phone,
            'wallet'          => floor($this->wallet),
            'points'          => $this->points,
            'debt'            => floor($this->debt),
            'shift_from'      => $this->shift_from,
            'shift_to'        => $this->shift_to,
            'spare_phone'     => $this->spare_phone,
            'spasial_com'     => $this->spasial_com,
        ]);
        // $this->storeLog($Client, Client::class, $row);
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم تعديل العضو بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
        return redirect()->route('dashboard.clients');
     }

     public function destroy() {
        $Client = Client::findOrFail($this->modelId);

        if ($Client->files != null) {
            foreach (explode(',', $Client->files) as $file) {
                $this->delete_target_file($file);
            }
        }
        //dd($Client->type);
        if ($Client->type == 1 || $Client->type == 2) {
            $products = Product::with('extras')
                ->where('soft_deleted', '=', 0)
                ->where('client_id', '=', $Client->id)
                ->get();
            if (count($products) > 0) {
                foreach ($products as $product) {
                    if ($product->main_image != null) {
                        $this->delete_target_file($product->main_image);
                    }
                    if ($product->images != null) {
                        foreach (explode(',', $product->images) as $file) {
                            $this->delete_target_file($file);
                        }
                    }
                    if ($product->extras != null && count($product->extras) > 0) {
                        foreach ($product->extras as $extra) {
                            $this->delete_target_file($extra->main_image);
                        }
                    }
                }
            }
        }
        $Client->update(['soft_deleted' => 1]);
        // $this->storeLog($Client, Client::class);
        $this->hideModel();
        $this->alert('success', 'تم حذف العضو بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
         return redirect()->route('dashboard.clients');
    }

    public function hideModel() {
        $this->createFormVisible = false;
        $this->updateFormVisible = false;
        $this->deleteFormVisible = false;
        $this->balanceModelVisible = false;
        $this->updatePasswordFormVisible = false;

    }

    public function all_users() {
        $data = $this->searchForm;
        if ($this->searchForm != '') {
            return Client::where('soft_deleted', '=', 0)
            ->where('email', '=', $data)
            ->orWhere('name', 'LIKE', "%{$data}%")
            ->orWhere('whatsapp_phone', '=', $data)
            ->paginate(20);

        } else {
            return Client::orderBy('created_at', 'DESC')->paginate(20);
        }
    }

    public function typeZeroUsers() {
        return Client::where('type', '=', 0)->where('soft_deleted', '=', 0)->count();
    }
    public function typeOneUsers() {
        return Client::where('type', '=', 1)->where('soft_deleted', '=', 0)->count();
    }
    public function typeTowUsers() {
        return Client::where('type', '=', 2)->where('soft_deleted', '=', 0)->count();
    }
    public function typeThreeUsers() {
        return Client::where('type', '=', 3)->where('soft_deleted', '=', 0)->count();
    }

    public function download($fileName) {
        return response()->download(public_path('uploads/'.$fileName));
    }

    public function render()
    {

        return view('livewire.admin.clients',[
            'users'     => $this->all_users(),
            'countries'  => Country::where('soft_deleted', '=', 0)->get(),
            'governments'=>  Government::where('country_id', '=', $this->country_id)->where('soft_deleted', '=', 0)->get(),
            'type0'     => $this->typeZeroUsers(),
            'type1'     => $this->typeOneUsers(),
            'type2'     => $this->typeTowUsers(),
            'type3'     => $this->typeThreeUsers(),
        ]);
    }
}
