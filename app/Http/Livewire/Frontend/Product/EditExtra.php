<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\productExtra;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class EditExtra extends Component
{
    use \Livewire\WithFileUploads, \Livewire\WithPagination, \Jantinnerezo\LivewireAlert\LivewireAlert;
    public $main_image;
    public $name;
    public $price;
    public $mid;
    protected $listeners = ['loadData' => 'loadData'];

    public function store() {
        if ($this->main_image != '') {
            $validatedData = $this->validate([
                'main_image' => 'image|mimes:jpg,jpeg,png,webp',
                'name' => 'required|string|max:255',
                'price' => "required",
            ]);
        } else {
            $validatedData = $this->validate([
                'name' => 'required|string|max:255',
                'price' => "required",
            ]);
        }
        if ($this->main_image != '') {
            $name = md5(microtime()) . '_' . date('d') . '.' . $this->main_image->extension();
            $this->main_image->storeAs('/', $name, 'uploads');
            $file = ['main_image' => $name];
        } else {
            $file = [];
        }
        $extra = productExtra::with('product:id,name')->findOrFail($this->mid);
        $proID = $extra->product->id;
        if(File::exists(public_path('uploads/'.$extra->main_image))){
            File::delete(public_path('uploads/'.$extra->main_image));
        }
        $extra->update([
                'name'          => $this->name,
                'price'         => $this->price,
            ] + $file);
        $this->main_image   = null;
        return redirect()->route('frontend.product.create-extra', [
            'id' => $proID
        ]);
    }
    public function remove($id)
    {
        $extra = productExtra::with('product:id,name')->findOrFail($id);
        $proID = $extra->product->id;
        if(File::exists(public_path('uploads/'.$extra->main_image))){
            File::delete(public_path('uploads/'.$extra->main_image));
        }
        $extra->update(['soft_deleted' => 1]);
       return redirect()->route('frontend.product.create-extra', [
           'id' => $proID
       ]);

    }
    public function loadData() {
        $extra = productExtra::findOrFail($this->mid);
        $this->name = $extra->name;
        $this->price = $extra->price;
    }
    public function render()
    {
        $extra = productExtra::findOrFail($this->mid);
        return view('livewire.frontend.product.edit-extra', [
            'extra' => $extra
        ]);
    }
}
