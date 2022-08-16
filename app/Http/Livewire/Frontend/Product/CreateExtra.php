<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\productExtra;
use Illuminate\Support\Facades\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CreateExtra extends Component
{
    use WithFileUploads, WithPagination, LivewireAlert;
    public $main_image;
    public $name;
    public $price;
    public $mid;
    public function store() {
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
            'product_id'    => $this->mid,
        ] + $file);
            $this->name         = null;
            $this->price        = null;
            $this->main_image   = null;
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
    public function removeExtra($id)
    {
        $extra = productExtra::findOrFail($id);
        if(File::exists(public_path('uploads/'.$extra->main_image))){
            File::delete(public_path('uploads/'.$extra->main_image));
        }
        $extra->update(['soft_deleted' => 1]);
        $this->alert('success', 'تم حذف الملحق', [
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

    public function render()
    {
        $product = \App\Models\Product::with('extras')->findOrFail($this->mid);
        return view('livewire.frontend.product.create-extra', [
            'product' => $product
        ]);
    }
}
