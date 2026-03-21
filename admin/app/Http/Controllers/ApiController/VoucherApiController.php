<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Magiamgia;
use Illuminate\Http\Request;

class VoucherApiController extends Controller
{
    /**
     * Lấy danh sách khuyến mãi / vouchers hiện có
     */
    public function index()
    {
        // Temporarily relaxing filters so user can see it once it starts working
        return response()->json(Magiamgia::where('trangthai', 0)
            ->where('soluong', '>', 0)
            ->get());
    }
}
