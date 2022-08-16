<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Backups extends Component
{
    public $deleteFormVisible;
    public $modelName;
    public function confirmUserDelete($file) {
        $this->deleteFormVisible = true;
        $this->modelName = $file;
    }
    public function hideModel() {
        $this->deleteFormVisible = false;
    }
    public function download() {
    }
    public function render()
    {
        $path = storage_path('app/Altaawus/');
        $files = File::allFiles($path);
        $filesInfos = [];
        foreach ($files as $key => $file) {
            $filesInfos[] = [
                'name'      => $file->getFilename(),
                'size'      => number_format($file->getSize() / 1000000, 1) . ' MB '
            ];
        }
        return view('livewire.admin.backups', [
            'filesInfos'    => $filesInfos
        ]);
    }
}
