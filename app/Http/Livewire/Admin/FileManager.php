<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\File;
use Livewire\Component;

class FileManager extends Component
{
    public function remove($file) {
        if(File::exists(public_path('uploads/'.$file))){
            File::delete(public_path('uploads/'.$file));
        }
    }
    public function render()
    {
        $allFiles = File::allFiles(public_path('uploads'));
        return view('livewire.admin.file-manager', [
            'allFiles' => $allFiles
        ]);
    }
}
