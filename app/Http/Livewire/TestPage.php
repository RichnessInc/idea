<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TestPage extends Component
{
    public  $selectedBranches = [];

    public function removeBranch($id) {
        if (($key = array_search($id, $this->selectedBranches)) !== false) {
            //dd($this->selectedBranches);
            unset($this->selectedBranches[$key]);
            //dd($this->selectedBranches);
            // $this->emit('fireEv', $this->selectedBranches);
        }
    }
    public function addBranch($id) {
        if (!in_array($id, $this->selectedBranches)) {
            $this->selectedBranches[] = $id;
        }
    }
    public function render()
    {
        $branches = \App\Models\Address::with('government')->where('branch', '=', 1)->where('client_id','=', Auth::guard('clients')->user()->id)->get();

        return view('livewire.test-page', [
            'branches'      => $branches
        ]);
    }
}
