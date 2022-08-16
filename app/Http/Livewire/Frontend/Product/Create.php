<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\Address;
use App\Models\Country;
use App\Models\Government;
use App\Models\Product;
use App\Models\ProductsCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Create extends Component
{
    use WithFileUploads, WithPagination, LivewireAlert;
    public $main_image;
    public $images;
    public $productname;
    public $category_id;
    public $desc;
    public $wight;
    public $width;
    public $height;
    public $price;
    public $tagsArr = [];
    public $receipt_days;
    public $aval_count;
    public $slug;
    public $tags;
    public $createAddressVisible = false;
    public $street;
    public $sector;
    public $build_no;
    public $floor;
    public $modelId;
    public $country_id;
    public $government_id;
    public $unit_no;
    public $details;
    public $governorates;
    public function add_tag() {
        if ($this->tags != null) {
            $this->tagsArr[] = $this->tags;
            $this->tags = null;
        }
    }
    public function delete_tag($del_val) {
        if (($key = array_search($del_val, $this->tagsArr)) !== false) {
            unset($this->tagsArr[$key]);
            $this->tags = null;
        }
    }
    public function create() {
        $validatedData = $this->validate([
            'productname'               => 'required|string|max:255',
            'category_id'               => 'required|numeric',
            'desc'                      => 'required|string|max:65000',
            'wight'                     => "required|regex:/^\d*(\.\d{1,2})?$/",
            'width'                     => "required|regex:/^\d*(\.\d{1,2})?$/",
            'height'                    => "required|regex:/^\d*(\.\d{1,2})?$/",
            'price'                     => "required|regex:/^\d*(\.\d{1,2})?$/",
            'receipt_days'              => 'required|numeric',
            'aval_count'                => 'required|numeric',
            'slug'                      => 'required|string',
            'main_image'                => 'required|image|mimes:jpeg,png,jpg,gif,webp'
        ]);

        if (!empty($this->tagsArr)) {
            if (!empty($this->selectedBranches)) {
                if ($this->main_image != null) {
                    $images = [];
                    if ($this->images != null) {
                        foreach ($this->images as $image) {
                            $name = md5($image . microtime()) . '_.' . $image->extension();
                            $image->storeAs('/', $name, 'uploads');
                            $images[] = $name;
                        }
                        $files = ['images' => implode(',', $images)];
                    } else {
                        $files = ['images' => null];
                    }
                    $name = md5($this->main_image . microtime()) . '_.' . $this->main_image->extension();
                    $this->main_image->storeAs('/', $name, 'uploads');
                    $file = ['main_image' => $name];
                    $data = [
                        'name'          => $this->productname,
                        'category_id'   => $this->category_id,
                        'desc'          => $this->desc,
                        'wight'         => $this->wight,
                        'width'         => $this->width,
                        'height'        => $this->height,
                        'price'         => $this->price,
                        'tags'          => ($this->tagsArr != null ? implode(',',$this->tagsArr) : []),
                        'receipt_days'  => $this->receipt_days,
                        'aval_count'    => $this->aval_count,
                        'slug'          => $this->slug.'-'.strtolower(Str::random(10)),
                        'branches'      => implode(',', $this->selectedBranches)
                    ];
                    Product::create($data + $file + $files + ['client_id' => Auth::guard('clients')->user()->id]);
                    $this->alert('success', 'تم اضافة المنتج بنجاح', [
                        'position' =>  'center',
                        'timer' =>  3000,
                        'toast' =>  true,
                        'text' =>  null,
                        'confirmButtonText' =>  'Ok',
                        'cancelButtonText' =>  'Cancel',
                        'showCancelButton' =>  false,
                        'showConfirmButton' =>  false,
                    ]);
                    $this->productname = null;
                    $this->category_id  = null;
                    $this->desc  = null;
                    $this->wight  = null;
                    $this->width = null;
                    $this->height = null;
                    $this->price = null;
                    $this->tagsArr = [];
                    $this->receipt_days  = null;
                    $this->aval_count = null;
                    $this->slug = null;
                    $this->selectedBranches = [];
                    $this->main_image = null;
                    $this->images = null;
                } else {
                    $this->alert('error', 'صورة المنتج اجبارية', [
                        'position' => 'center',
                        'timer' => 3000,
                        'toast' => true,
                        'text' => null,
                        'confirmButtonText' => 'Ok',
                        'cancelButtonText' => 'Cancel',
                        'showCancelButton' => false,
                        'showConfirmButton' => false,
                    ]);
                }
             } else {
                $this->alert('error', 'يجب اضافة فرع واحد على الاقل', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => true,
                    'text' => null,
                    'confirmButtonText' => 'Ok',
                    'cancelButtonText' => 'Cancel',
                    'showCancelButton' => false,
                    'showConfirmButton' => false,
                ]);
            }


        } else {
            $this->alert('error', 'يجب اضافة كلمة مفتاحية واحدة على الاقل', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
                'text' => null,
                'confirmButtonText' => 'Ok',
                'cancelButtonText' => 'Cancel',
                'showCancelButton' => false,
                'showConfirmButton' => false,
            ]);
        }
    }
    public  $selectedBranches = [];

    public function removeBranch($id) {
        if (($key = array_search($id, $this->selectedBranches)) !== false) {
            unset($this->selectedBranches[$key]);
        }
    }
    public function addBranch($id) {
        if (!in_array($id, $this->selectedBranches)) {
            $this->selectedBranches[] = $id;
        }
    }
    public function store() {
        $validatedData = $this->validate([
            'government_id'     => 'required|numeric',
            'country_id'        => 'required|numeric',
            //////////////////////////////////////////////////////////////
            'street'            => 'required|string|max:255',
            'build_no'          => 'required|numeric',
            'sector'            => 'required|string|max:255',
            'floor'             => 'required|numeric',
            'unit_no'           => 'required|numeric',
            'details'           => 'required|string|max:255',
        ]);
        $data = [
            'government_id'     => $this->government_id,
            'country_id'        => $this->country_id,
            'street'            => $this->street,
            'build_no'          => $this->build_no,
            'sector'            => $this->sector,
            'floor'             => $this->floor,
            'unit_no'           => $this->unit_no,
            'details'           => $this->details,
        ];
        $add = Address::create($data + ['client_id' => Auth::guard('clients')->user()->id]);
        $this->addBranch($add->id);
        $this->resetAddressFormDate();
        $this->hideModel();
        $this->alert('success', 'تم انشاء العنوان بنجاح', [
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
    public function country_change() {
        $this->governorates = Government::where('country_id', '=', $this->country_id)->where('soft_deleted', '=', 0)->get();
    }
    public function createAddressModel() {
        dd('s');
        $this->resetAddressFormDate();
        $this->createAddressVisible = true;
    }
    public function resetAddressFormDate() {
        $this->street           = null;
        $this->sector           = null;
        $this->build_no         = null;
        $this->floor            = null;
        $this->government_id    = null;
        $this->country_id       = null;
        $this->unit_no          = null;
        $this->details          = null;
        $this->governorates     = null;
    }
    public function hideModel() {
        $this->createAddressVisible     = false;
    }
    public function render()
    {
        $categories = ProductsCategory::where('soft_deleted', '=', 0)->get();
        $branches = \App\Models\Address::with('government')->where('branch', '=', 1)
            ->where('client_id','=', Auth::guard('clients')->user()->id)
            ->whereNotIn('id',$this->selectedBranches)
            ->get();

        return view('livewire.frontend.product.create', [
            'categories'    => $categories,
            'branches'      => $branches,
            'countries'         => Country::where('soft_deleted', '=', 0)->get(),

        ]);
    }
}
