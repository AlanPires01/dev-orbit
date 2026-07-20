<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function index(Request $request){
        $tag = $request->input('tag','aws');
        $response = Http::get("https://dev.to/api/articles",[
            'tag'=>$tag,
            'per_page'=>12
        ]);
        $articles = $response->successful()? $response->json():[];

        return view('news.index',[
            'articles'=>$articles,
            'tag'=>$tag
        ]);
    }
}
