<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Nhacungcap;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Lấy danh sách đối tác / danh sách nhà cung cấp
     */
    public function index()
    {
        $partners = Nhacungcap::where('anhien', 1)->get();
        return response()->json($partners);
    }
}
