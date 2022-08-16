<?php

namespace App\Http\Livewire\Admin;

use App\Models\Notification;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Notifications extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $deleteFormVisible   = false;
    public $searchForm = '';
    public $rowData;

    public function confirmUserDelete($id) {
        $this->deleteFormVisible = true;
        $this->rowData = Notification::findOrFail($id)->content;
    }
    public function all_users() {
        $data = $this->searchForm;
        if ($this->searchForm != '') {
            return Notification::with('client')
                ->whereHas('client', function($q) use($data) {
                    return $q->where('name', 'LIKE', "%{$data}%")
                        ->orWhere('email', 'LIKE', "%{$data}%")
                        ->orWhere('whatsapp_phone', '=', $data);
                })->paginate(20);

        } else {
            return Notification::orderBy('created_at', 'DESC')->paginate(20);
        }
    }
    public function hideModel() {
        $this->deleteFormVisible   = false;
    }
    public function render()
    {
        return view('livewire.admin.notifications', [
            'rows' => $this->all_users()
        ]);
    }
}
