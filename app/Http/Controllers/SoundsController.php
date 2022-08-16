<?php

namespace App\Http\Controllers;

use App\Models\CardsSound;
use Illuminate\Http\Request;

class SoundsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('admin.cards.videos');
    }

    public function store(Request $request)
    {
        if($request->audio != '') {

            $name =  md5($request->audio  . microtime()) . '_.' . $request->audio->extension();

            $image =  ['sound_name' => $name];

            $request->audio->storeAs('/', $name, 'uploads');

            CardsSound::create($image + ['name' => $request->name]);
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        CardsSound::findOrFail($id)->delete();

        return redirect()->back();
    }
}
