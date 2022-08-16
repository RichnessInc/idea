<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Address;
use App\Models\Client;
use App\Models\Country;
use App\Models\Government;
use App\Models\singleRoom;
use App\Models\singleRoomMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Register extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $name;
    public $whatsapp_phone;
    public $email;
    public $type;
    public $country_id;
    public $government_id;
    public $password;
    public $repassword;
    public $files;
    public $governorates = null;
    ////////////////////////////
    ///
    public $terms;
    public $street;
    public $build_no;
    public $sector;
    public $floor;
    public $unit_no;
    public $details;
    public $showSpinner = false;
    public $recaptcha;
    protected $listeners = ['postAdded' => 'store'];

    public $showPassword = false;

    public function showPasswordF() {
        if ($this->showPassword == true) {
            $this->showPassword = false;
        } else {
            $this->showPassword = true;
        }
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
            'whatsapp_phone'    => $this->whatsapp_phone
        ];
    }

    public function store($payload) {
        if ($this->is_rtl($this->password) == 0) {
            if ($this->terms == true) {
                $isVer = ($this->type == 0 ? 1 : 0);
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
                    'files.*'           => 'mimes:jpeg,jpg,png,gif,pdf'

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
                $ref = ($payload['ref'] != "" ? $payload['ref'] : null);
                $refArray = ['parent_ref' => $ref];
                $client = Client::create(
                    $password +
                    ['verify_email_token' => $token ] +
                    ['ref' => Str::random(10).rand(20,30).date('dmY')] +
                    $files +
                    ['verified' => $isVer] +
                    $refArray + $this->modelData()
                );
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
                $credentials = [
                    'email'              => $this->email,
                    'password'           => $this->password,
                ];
                if (Auth::guard('clients')->attempt($credentials)) {
                    return redirect('/profile');
                }
                /*
                if ($this->recaptcha != null) {

                } else {
                    $this->alert('error', 'يجب الضغط على علامة انا لست روبوت', [
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
                */
            } else {
                $this->alert('error', 'يجب الموافقة على االشروط والاحكام', [
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
        } else {
            $this->alert('error', 'لا يمكن كتابة حروف عربية في كلمة المرور', [
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


    }

    function is_rtl( $string ) {
        $rtl_chars_pattern = '/[\x{0590}-\x{05ff}\x{0600}-\x{06ff}]/u';
        return preg_match($rtl_chars_pattern, $string);
    }

    function uniord($u) {
        // i just copied this function fron the php.net comments, but it should work fine!
        $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
        $k1 = ord(substr($k, 0, 1));
        $k2 = ord(substr($k, 1, 1));
        return $k2 * 256 + $k1;
    }
    function is_arabic($str) {
        if(mb_detect_encoding($str) !== 'UTF-8') {
            $str = mb_convert_encoding($str,mb_detect_encoding($str),'UTF-8');
        }
        preg_match_all('/.|\n/u', $str, $matches);
        $chars = $matches[0];
        $arabic_count = 0;
        $latin_count = 0;
        $total_count = 0;
        foreach($chars as $char) {
            //$pos = ord($char); we cant use that, its not binary safe
            $pos = $this->uniord($char);
            echo $char ." --> ".$pos.PHP_EOL;

            if($pos >= 1536 && $pos <= 1791) {
                $arabic_count++;
            } else if($pos > 123 && $pos < 123) {
                $latin_count++;
            }
            $total_count++;
        }
        if(($arabic_count/$total_count) > 0.6) {
            // 60% arabic chars, its probably arabic
            return true;
        }
        return false;
    }


    public function render()
    {
        $countries = Country::where('soft_deleted', '=', 0)->get();
        return view('livewire.frontend.register', [
            'countries' => $countries
        ]);
    }
}
