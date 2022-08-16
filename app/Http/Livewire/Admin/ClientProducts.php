<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use App\Models\productExtra;
use App\Models\ProductsCategory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ClientProducts extends Component
{
    use LivewireAlert;
    use WithPagination;
    use WithFileUploads;
    public $searchForm              = "";
    public $createFormVisible       = false;
    public $updateFormVisible       = false;
    public $deleteFormVisible       = false;
    public $addProductExtraVisible  = false;
    public $ProductExtraVisible     = false;
    public $ProductDisableVisible   = false;
    public $ProductActiveVisible    = false;

    public $cid;
    public $name;
    public $modelId;
    public $extras;

    public $category_id;
    public $desc;
    public $wight;
    public $width;
    public $height;
    public $price;
    public $aval_count;
    public $main_image;
    public $images;
    public $tags;
    public $status;
    public $receipt_days;
    public $slug;
    public $tagsArr = [];
    public $image_name;
    public $images_names;

    public function ProductDisable($id) {
        $this->ProductDisableVisible = true;
        $this->modelId = $id;
    }
    public function ProductActive($id) {
        $this->ProductActiveVisible = true;
        $this->modelId = $id;
    }
        public function addProductExtra () {
            $validatedData = $this->validate([
                'name'                      => 'required|string|max:255',
                'price'                     => "required|regex:/^\d*(\.\d{1,2})?$/",
                'main_image'                => 'required|image|mimes:jpeg,png,jpg,gif,webp'
            ]);
            if ($this->main_image != '') {
                $name = md5(microtime()) . '_' . date('d') . '.' . $this->main_image->extension();
                $this->main_image->storeAs('/', $name, 'uploads');
                $file = ['main_image' => $name];
                productExtra::create([
                        'name'          => $this->name,
                        'price'         => $this->price,
                        'product_id'    => $this->modelId,
                    ] + $file);
                $this->name         = null;
                $this->price        = null;
                $this->main_image   = null;
                $this->hideModel();
            } else {
                $this->alert('error', 'يجب رفع صورة الملحق ', [
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
    public function ProductDisableFun() {
        $row = Product::findOrFail($this->modelId);
        $Client = $row->update(['status' => 0]);
        $this->hideModel();
        $this->alert('success', 'تم ايقاف المنتج بنجاح', [
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
    public function ProductActiveFun() {
        $row = Product::findOrFail($this->modelId);
        $Client = $row->update(['status' => 1]);
        $this->hideModel();
        $this->alert('success', 'تم عرض المنتج بنجاح', [
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

    public function showAddProductExtraModel($id)
    {
        $this->addProductExtraVisible = true;
        $this->modelId = $id;
    }

    public function showProductExtrasModel($id)
    {
        $this->ProductExtraVisible = true;
        $this->modelId = $id;
        $this->extras = productExtra::where('product_id', '=', $id)->where('soft_deleted', '=', 0)->get();
    }

    public function add_tag() {
        $this->tagsArr[] = $this->tags;
        $this->tags = null;
    }

    public function delete_tag($del_val) {
        if (($key = array_search($del_val, $this->tagsArr)) !== false) {
            unset($this->tagsArr[$key]);
            $this->tags = null;
        }
    }

    public function modelData() {
        return [
            'category_id'       => $this->category_id,
            'desc'              => $this->desc,
            'wight'             => $this->wight,
            'price'             => $this->price,
            'aval_count'        => $this->aval_count,
            'receipt_days'      => $this->receipt_days,
            'slug'              => $this->slug,
            'name'              => $this->name,
            'width'              => $this->width,
            'height'            => $this->height,
            'tags'              => implode(',',$this->tagsArr),

        ];
    }
    public function updateModelData() {
        return [
            'category_id'       => $this->category_id,
            'desc'              => $this->desc,
            'wight'             => $this->wight,
            'price'             => $this->price,
            'aval_count'        => $this->aval_count,
            'receipt_days'      => $this->receipt_days,
            'slug'              => $this->slug,
            'name'              => $this->name,
            'tags'              => implode(',',$this->tagsArr),
            'width'              => $this->width,
            'height'            => $this->height,

        ];
    }
    public function loadModelData() {
        $data = Product::find($this->modelId);
        $this->category_id          = $data->category_id;
        $this->desc                 = $data->desc;
        $this->wight                = $data->wight;
        $this->price                = $data->price;
        $this->aval_count           = $data->aval_count;
        $this->receipt_days         = $data->receipt_days;
        $this->slug                 = $data->slug;
        $this->name                 = $data->name;
        $this->tagsArr              = explode(',', $data->tags);
        $this->image_name           = $data->main_image;
        $this->images_names         = $data->images;
        $this->width                = $data->width;
        $this->height                = $data->height;

    }

    public function resetFormDate() {
        $this->category_id          = null;
        $this->desc                 = null;
        $this->wight                = null;
        $this->price                = null;
        $this->aval_count           = null;
        $this->receipt_days         = null;
        $this->slug                 = null;
        $this->name                 = null;
        $this->tags                 = null;
        $this->tagsArr              = [];
        $this->image_name           = null;
        $this->images_names         = null;
        $this->width                = null;
        $this->height                = null;

    }

    public function rules() {
        return [
            'category_id'           => 'required',
            'desc'                  => 'required',
            'wight'                 => 'required',
            'price'                 => 'required',
            'aval_count'            => 'required',
            'receipt_days'          => 'required',
            'slug'                  => 'required',
            'width'                  => 'required',
            'height'                  => 'required',
            'name'                  => 'required|max:255',

            'images'                  => 'required',
            'main_image'                  => 'required',

        ];

    }



    public function store() {
        $this->validate();
        $images = [];
        foreach ($this->images as $image) {
            $name = md5($image . microtime()) . '_.' . $image->extension();
            $image->storeAs('/', $name, 'uploads');
            $images[] = $name;
        }
        $files = ['images' => implode(',', $images)];


        $name = md5($this->main_image . microtime()) . '_.' . $this->main_image->extension();
        $this->main_image->storeAs('/', $name, 'uploads');
        $file = ['main_image' => $name];
        $Client = Product::create(['client_id' => $this->cid] + $files + $file + $this->modelData());
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم انشاء المنتج بنجاح', [
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

    public function update() {
        $row = Product::findOrFail($this->modelId);
        $images = [];
        if ($this->images != '') {
            foreach ($this->images as $image) {
                $name = md5($image . microtime()) . '_.' . $image->extension();
                $image->storeAs('/', $name, 'uploads');
                $images[] = $name;
            }
            $files = ['images' => implode(',', $images)];
        } else {
            $files = [];
        }

        if ($this->main_image != '') {
            $name = md5($this->main_image . microtime()) . '_.' . $this->main_image->extension();
            $this->main_image->storeAs('/', $name, 'uploads');
            $file = ['main_image' => $name];
        } else {
            $file = [];
        }
        $Client = $row->update($files + $file + $this->updateModelData());
        $this->resetFormDate();
        $this->hideModel();
        $this->alert('success', 'تم تعديل المنتج بنجاح', [
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

    public function destroy() {
        $Client = Product::findOrFail($this->modelId);
        $Client->update(['soft_deleted' => 1]);
        // $this->storeLog($Client, Client::class);
        $this->hideModel();
        $this->alert('success', 'تم حذف المنتج بنجاح', [
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

    public function hideModel() {
        $this->createFormVisible        = false;
        $this->updateFormVisible        = false;
        $this->deleteFormVisible        = false;
        $this->addProductExtraVisible   = false;
        $this->ProductExtraVisible      = false;
        $this->ProductDisableVisible    = false;
        $this->ProductActiveVisible     = false;
    }

    public function render()
    {
        $users = Product::with('category:id,name')
        ->withCount('requests')
        ->where('soft_deleted', '=', 0)
        ->where('client_id', '=', $this->cid);
        $data = $this->searchForm;
        if ($this->searchForm != '') {
            $users = $users->where('name', 'LIKE', "%{$data}%");
        }
        $users      = $users->orderBy('created_at', 'DESC')->paginate(20);
        $categories = ProductsCategory:: where('soft_deleted', '=', 0)->get();
            return view('livewire.admin.client-products', [
            'rows'          => $users,
            'categories'    => $categories
        ]);
    }
}
