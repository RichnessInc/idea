<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Favourite;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Favourites extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $deleteFormVisible;
    public $favouriteID;

    public function confirmbillDelete($id) {
        $this->deleteFormVisible = true;
        $this->favouriteID = $id;
    }

    public function destroy() {
        $favourite = Favourite::findOrFail($this->favouriteID);
        $favourite->update(['soft_deleted' => 1]);
        // $this->storeLog($favourite, Favourite::class);
        $this->hideModel();
        $this->alert('success', 'تم حذف المنتج من الفضلة بنجاح', [
             'position' =>  'cenetr',
             'timer' =>  3000,
             'toast' =>  true,
             'text' =>  '',
             'confirmButtonText' =>  'Ok',
             'cancelButtonText' =>  'Cancel',
             'showCancelButton' =>  false,
             'showConfirmButton' =>  false,
         ]);
        return redirect()->route('frontend.favourites');

    }

    public function hideModel() {
        $this->deleteFormVisible = false;
        return redirect()->route('frontend.favourites');
    }

    public function get_favourites() {
        return Favourite::with('product:id,name,price,main_image,slug')
        ->where('soft_deleted', '=', 0)
        ->where('client_id', '=', Auth::guard('clients')->user()->id)->paginate(50);
    }

    public function render()
    {
        return view('livewire.frontend.favourites', [
            'favourites' => $this->get_favourites()
        ]);
    }
}
