<?php

namespace App\Http\Livewire\Admin;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use LivewireAlert;

    use WithPagination;
    public function render()
    {
        return view('livewire.admin.products');
    }
}
