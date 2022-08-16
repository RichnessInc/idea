<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\Product;
use App\Models\ProductsCategory;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Edit extends Component
{
    use WithFileUploads, WithPagination, LivewireAlert;
    public $row;
    public $main_image;
    public $images;
    public $productname;
    public $category_id;
    public $desc;
    public $wight;
    public $width;
    public $height;
    public $price;
    public $tagsArr;
    public $receipt_days;
    public $aval_count;
    public $slug;
    public $tags;
    public $image_name;
    public $images_names;
    public $myFiles;
    protected $listeners = ['uploadedFiles' => 'uploadedFiles'];
    private STATIC $count = 0;
    public  $selectedBranches = ['empty'];


    public function delete_tag($del_val) {
        if (($key = array_search($del_val, $this->tagsArr)) !== false) {
            unset($this->tagsArr[$key]);
            $this->tags = null;
        }
    }
    public function add_tag() {
        if ($this->tags != null) {
            $this->tagsArr[] = $this->tags;
            $this->tags = null;
        }
    }

    public function loadProductData()
    {
        $data = Product::findOrFail($this->row->id);
        return [
            $this->productname = $data->name,
            $this->category_id = $data->category_id,
            $this->desc = $data->desc,
            $this->wight = $data->wight,
            $this->width = $data->width,
            $this->height = $data->height,
            $this->price = $data->price,
            $this->tagsArr = explode(',', $data->tags),
            $this->receipt_days = $data->receipt_days,
            $this->aval_count = $data->aval_count,
            $this->image_name = $data->main_image,
            $this->images_names = $data->images,
            $this->selectedBranches = explode(',', $data->branches)
        ];
    }
    public function uploadedFiles($data) {
        dd($data);
    }
    public function submit()
    {
        $validatedData = $this->validate([
            'main_image'                => 'nullable|image|mimes:jpeg,png,jpg,gif,webp'
        ]);
        $names = [];
        if ($this->myFiles != '') {
            foreach ($this->images as $image) {
                $name = md5($image . microtime()) . '_.' . $image->extension();
                $image->storeAs('/', $name, 'uploads');
                $images[] = $name;
            }
            $files = ['images' => implode(',', $names)];
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
        Product::findOrFail($this->row->id)->update($file + $files + [
            'name' => $this->productname,
            'category_id' => $this->category_id,
            'desc' => $this->desc,
            'wight' => $this->wight,
            'width' => $this->width,
            'height' => $this->height,
            'price' => $this->price,
            'tags' => implode(',', $this->tagsArr),
            'receipt_days' => $this->receipt_days,
            'aval_count' => $this->aval_count,
                'branches'      => implode(',', $this->selectedBranches)

            ]);
        return redirect()->route('frontend.product.edit', ['id' => $this->row->id]);
    }

    public function removeBranch($id) {

        if (($key = array_search($id, $this->selectedBranches)) !== false) {
            unset($this->selectedBranches[$key]);
        }
        //dd($this->selectedBranches);
    }
    public function addBranch($id) {
        if (!in_array($id, $this->selectedBranches)) {
            $this->selectedBranches[] = $id;
        }
    }
    public function render()
    {
        if ($this->selectedBranches == ['empty']){
            $this->loadProductData();
            //dd(self::$count);
        }
        //$this->selectedBranches = explode(',',$this->row->branches);
        $categories = ProductsCategory::get();
        $branches = \App\Models\Address::with('government')->where('branch', '=', 1)
            ->where('client_id','=', Auth::guard('clients')->user()->id)
            ->whereNotIn('id',$this->selectedBranches)
            ->get();

        return view('livewire.frontend.product.edit', [
            'categories' => $categories,
            'branches' => $branches,
        ]);
    }
}
