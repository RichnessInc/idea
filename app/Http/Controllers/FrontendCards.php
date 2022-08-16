<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendCards extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'from'              => 'required|min:4|max:255',
            'to'                => 'required|min:4|max:255',
            'text'              => 'required|min:4|max:1250',
            'background_id'     => 'required|numeric',
            'sound_id'          => 'nullable|numeric',
            'video_id'          => 'nullable|numeric',

        ]);
        if ($request->image != null) {
            $imageName =  md5($request->image . microtime()) . '_.' . $request->image->extension();
            $request->image->storeAs('/', $imageName, 'uploads');
            $image = ['image' => $imageName];
        } else {
            $image = [];
        }


        if ($request->sound != null) {
            $soundName =  md5($request->sound . microtime()) . '_.' . $request->sound->extension();
            $request->sound->storeAs('/', $soundName, 'uploads');
            $sound = ['sound' => $soundName];
        } else {
            $sound = [];
        }

        $slug = ['slug' => $request->slug.'-'.microtime()];
        $client_id = ['client_id' => Auth::guard('clients')->user()->id];

        Card::create($client_id + $slug + $image + $sound + $request->all());
        return redirect()->route('frontend.cards.index');
    }

     public function update(Request $request, $id) {
         $request->validate([
             'from'              => 'required|min:4|max:255',
             'to'                => 'required|min:4|max:255',
             'text'              => 'required|min:4|max:1250',
             'background_id'     => 'required|numeric',
             'sound_id'          => 'nullable|numeric',
             'video_id'          => 'nullable|numeric',

         ]);
         if ($request->image != null) {
             $imageName =  md5($request->image . microtime()) . '_.' . $request->image->extension();
             $request->image->storeAs('/', $imageName, 'uploads');
             $image = ['image' => $imageName];
         } else {
             $image = [];
         }


         if ($request->sound != null) {
             $soundName =  md5($request->sound . microtime()) . '_.' . $request->sound->extension();
             $request->sound->storeAs('/', $soundName, 'uploads');
             $sound = ['sound' => $soundName];
         } else {
             $sound = [];
         }
         Card::findOrFail($id)->update($image + $sound + $request->all());
         return redirect()->route('frontend.cards.index');

     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Card::findOrFail($id)->delete();
        return redirect()->route('frontend.cards.index');
    }
}
