<?php

namespace App\Http\Livewire\Admin;

use App\Models\mainPage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class MainPages extends Component
{
    use LivewireAlert;



    public function render()

    {
        $data = mainPage::where('slug', '=', $this->slug)->first();
        $this->name                 = $data->name;
        $this->page_text            = $data->content;
        return view('admin.main-pages',  compact('data'));
    }
}
