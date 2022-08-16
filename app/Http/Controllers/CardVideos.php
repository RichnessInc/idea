<?php

namespace App\Http\Controllers;

use App\Models\CardsVideo;
use Illuminate\Http\Request;

class CardVideos extends Controller
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

            $image =  ['video_name' => $name];

            $request->audio->storeAs('/', $name, 'uploads');
            CardsVideo::create($image +  ['category_id' => $request->category_id]);
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        CardsVideo::findOrFail($id)->update(['soft_deleted' => 1]);

        return redirect()->back();
    }
}
