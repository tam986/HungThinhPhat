<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function getBanners()
    {
        return response()->json(['message' => 'Hello Banners Debug']);
        // $banners = Banner::where('anhien', 1)->orderBy('thutu', 'asc')->get();
        // return response()->json($banners);
    }
}
