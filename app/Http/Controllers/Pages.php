<?php

namespace App\Http\Controllers;

use App\Models\altaawusVip as ModelsAltaawusVip;
use App\Models\mainPage;
use App\Models\Page;
use Illuminate\Http\Request;

class Pages extends Controller
{
    public function update(Request $request, $slug) {
        $row = mainPage::where('slug', '=', $slug);
        $name = ['name' => $request->name];
        $content = ['content' => $request->content];

        $user = $row->update($name+$content);
        return redirect()->route('admin.main-pages', ['slug' => $slug]);
    }
    public function altaawus_vip(Request $request) {
        $row = ModelsAltaawusVip::findOrFail(1);
        $content = ['text' => $request->text];
        $user = $row->update($content);
        return redirect()->route('admin.altaawus-vip');
    }

    public function updateReeshPageData(Request $request) {
        $row = Page::where('slug','=', 'reesh');
        $user = $row->update(['content' => $request->content]);
        return redirect()->back();
    }
    public function updatGiftsPageData(Request $request) {
        $row = Page::where('slug','=', 'gifts');
        $user = $row->update(['content' => $request->content]);
        return redirect()->back();
    }

}
