<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class BillsCollection extends Component
{
    use WithPagination;
    public $contentFormVisible  = false;
    public $searchForm          = '';
    public $modelId;
    public $data;
    public function showContent($id) {
        $this->data = \App\Models\receiptCollection::findOrFail($id);
        $this->modelId = $id;
        $this->contentFormVisible = true;
    }
    public function hideModel() {
        $this->contentFormVisible = false;
    }
    public function all_users() {
        $bills = \App\Models\receiptCollection::with('client:id,email');

        $data = $this->searchForm;

        if ($this->searchForm != '') {

            $bills = $bills->where('reference_number', '=', $data);
        }

        return $bills->orderBy('created_at', 'DESC')->paginate(20);


    }
    public function render()
    {
        return view('livewire.admin.bills-collection', [
            'bills' => $this->all_users()
        ]);
    }
}
