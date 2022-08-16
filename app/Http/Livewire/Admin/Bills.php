<?php

namespace App\Http\Livewire\Admin;

use App\Models\Bill;
use App\Models\Receipt;
use Livewire\Component;
use Livewire\WithPagination;

class Bills extends Component
{
    use WithPagination;
    public $contentFormVisible  = false;
    public $searchForm          = '';
    public $modelId;
    public $data;
    public function showContent($id) {
        $this->data = Bill::findOrFail($id);
        $this->modelId = $id;
        $this->contentFormVisible = true;
    }
    public function hideModel() {
        $this->contentFormVisible = false;
    }
    public function all_users() {
        $bills = Bill::with('client:id,email')
            ->where('soft_deleted', '=', 0)
            ->where('status', '=', 0)
            ->orWhere('status', '=', 1);

        $data = $this->searchForm;

        if ($this->searchForm != '') {

            $bills = $bills->where('reference_number', '=', $data);
        }

        return $bills->orderBy('created_at', 'DESC')->paginate(20);


    }
    public function render()
    {
        return view('livewire.admin.bills', [
            'bills' => $this->all_users()
        ]);
    }
}
