<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SitemapXmlController extends Controller
{
    public function index() {
        $posts = Product::all();
        $pages = \App\Models\mainPage::get();
        return response()->view('sitemap', [
            'posts' => $posts,
            'pages' => $pages
        ])->header('Content-Type', 'text/xml');
    }
}

