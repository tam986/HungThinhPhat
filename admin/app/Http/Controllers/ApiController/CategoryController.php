<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Danhmuc;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Lấy danh sách danh mục
     */
    public function index()
    {
        $categories = Danhmuc::where('anhien', 1)->orderBy('thutu', 'asc')->get();
        return response()->json($categories);
    }

    /**
     * Lấy cấu trúc cây danh mục > sản phẩm > loại bánh
     */
    public function tree()
    {
        $tree = Danhmuc::where('anhien', 1)
            ->with(['sanphams' => function($q) {
                $q->where('anhien', 1)->with(['bienthe.loaibanh']);
            }])
            ->orderBy('thutu', 'asc')
            ->get();

        $transformed = $tree->map(function($cat) {
            return [
                'id' => $cat->id,
                'name' => $cat->tendanhmuc,
                'slug' => $cat->slug,
                'products' => $cat->sanphams->map(function($sp) {
                    $uniqueTypes = $sp->bienthe->pluck('loaibanh')
                        ->filter()
                        ->unique('id')
                        ->values()
                        ->map(function($lb) {
                            return [
                                'id' => $lb->id,
                                'name' => $lb->tenLoaiBanh
                            ];
                        });

                    return [
                        'id' => $sp->id,
                        'name' => $sp->tensp,
                        'types' => $uniqueTypes
                    ];
                })
            ];
        });

        return response()->json($transformed);
    }
}
