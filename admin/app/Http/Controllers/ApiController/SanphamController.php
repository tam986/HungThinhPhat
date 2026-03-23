<?php

namespace App\Http\Controllers\ApiController;

use App\Models\BienThe;
use App\Models\Danhmuc;
use App\Models\Sanpham;
use App\Models\Nhacungcap;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SanphamController extends Controller
{
    /**
     * Display a paginated listing of variants (the primary sellable item).
     */
    public function index(Request $request)
    {
        $query = BienThe::with(['sanpham.danhmuc', 'sanpham.nhacungcap', 'khoiluong', 'nhanbanh'])
            ->whereHas('sanpham', function($q) {
                $q->where('anhien', 1);
            });

        // 1. Search by product name
        if ($search = $request->query('search')) {
            $query->whereHas('sanpham', function($q) use ($search) {
                $q->where('tensp', 'like', '%' . $search . '%');
            });
        }

        // 2. Filter by Category (multiple selection)
        if ($categorySlugs = $request->query('category')) {
            $slugs = is_string($categorySlugs) ? explode(',', $categorySlugs) : (array) $categorySlugs;
            
            // Categories don't have slug column, using accessor logic
            $danhmucIds = Danhmuc::all()->filter(function($d) use ($slugs) {
                return in_array($d->slug, $slugs);
            })->pluck('id');

            $query->whereHas('sanpham', function($q) use ($danhmucIds) {
                $q->whereIn('id_danhmuc', $danhmucIds);
            });
        }

        // 3. Filter by Specific Product Name (multiple selection)
        if ($productNames = $request->query('product')) {
            $names = is_string($productNames) ? explode(',', $productNames) : (array) $productNames;
            $query->whereHas('sanpham', function($q) use ($names) {
                $q->whereIn('tensp', $names);
            });
        }


        // 5. Filter by Supplier
        if ($supplierIds = $request->query('supplier')) {
            $ids = is_string($supplierIds) ? explode(',', $supplierIds) : (array) $supplierIds;
            $query->whereHas('sanpham', function($q) use ($ids) {
                $q->whereIn('id_nhacungcap', $ids);
            });
        }

        // Note: Sorting is handled on the Frontend as per user request.
        // Default order is newest.
        $query->orderByDesc('id');

        $perPage = $request->query('per_page', 12);
        $variants = $query->paginate($perPage)->withQueryString();

        return response()->json([
            'products' => [
                'data' => ProductResource::collection($variants),
                'current_page' => $variants->currentPage(),
                'last_page' => $variants->lastPage(),
                'total' => $variants->total(),
            ],
            'danhmucs' => Danhmuc::where('anhien', 1)->orderBy('thutu')->get(),
            'nhacungcaps' => Nhacungcap::where('anhien', 1)->get()
        ]);
    }

    /**
     * Display the specified variant and its "siblings" (other variants of the same product).
     */
    public function detail($slug)
    {
        $variant = BienThe::with(['sanpham.danhmuc', 'sanpham.nhacungcap', 'khoiluong', 'nhanbanh'])
            ->where('slug', $slug)
            ->firstOrFail();

        $product = $variant->sanpham;
        
        // Variants for attribute matrix
        $variants = BienThe::with(['khoiluong', 'nhanbanh'])
            ->where('id_sp', $product->id)
            ->get();

        $transformedVariants = $variants->map(function($v) {
            return [
                'id' => $v->id,
                'slug' => $v->slug,
                'full_name' => $v->full_name,
                'price' => $v->gia,
                'sale_price' => $v->giakm,
                'stock' => $v->soluong,
                'weight' => $v->khoiluong?->khoiluong,
                'filling' => $v->nhanbanh?->tenNhanBanh,
                'hinh' => $v->hinh,
                'id_khoiluong' => $v->id_khoiluong,
                'id_nhanbanh' => $v->id_nhanbanh,
            ];
        });

        // Sibling products in the same category
        $siblings = Sanpham::where('id_danhmuc', $product->id_danhmuc)
            ->where('anhien', 1)
            ->get(['id', 'tensp']);

        // Attributes with available counts for UI selectors
        $available_weights = $variants->pluck('khoiluong')->filter()->unique('id')->values();
        $available_fillings = $variants->pluck('nhanbanh')->filter()->unique('id')->values();

        return response()->json([
            'product' => [
                'id' => $product->id,
                'tensp' => $product->tensp,
                'mota' => $product->mota,
                'danhmuc' => $product->danhmuc,
                'nhacungcap' => $product->nhacungcap,
            ],
            'targeted_variant_id' => $variant->id,
            'variants' => $transformedVariants,
            'sibling_products' => $siblings->map(function($s) {
                // Get the best variant to build the link (e.g. simplest or featured)
                $v = BienThe::where('id_sp', $s->id)->orderBy('gia', 'asc')->first();
                return [
                    'id' => $s->id,
                    'tensp' => $s->tensp,
                    'img' => $v ? $v->hinh : null,
                    'slug' => $v ? $v->slug : null
                ];
            }),
            'available_weights' => $available_weights,
            'available_fillings' => $available_fillings,
        ]);
    }

    /**
     * Get the latest variants.
     */
    public function latest()
    {
        $variants = BienThe::with(['sanpham.danhmuc'])
            ->whereHas('sanpham', function($q) {
                $q->where('anhien', 1);
            })
            ->latest()
            ->take(8)
            ->get();

        return ProductResource::collection($variants);
    }

    /**
     * Get variants with discounts.
     */
    public function sale()
    {
        $variants = BienThe::with(['sanpham.danhmuc', 'khoiluong', 'nhanbanh'])
            ->where('giakm', '>', 0)
            ->whereColumn('giakm', '<', 'gia')
            ->whereHas('sanpham', function($q) {
                $q->where('anhien', 1);
            })
            ->latest()
            ->take(8)
            ->get();

        return ProductResource::collection($variants);
    }

    /**
     * Quick lookup for a specific variant by attribute combo.
     */
    public function findVariant(Request $request)
    {
        $validated = $request->validate([
            'id_sp' => 'required|exists:sanphams,id',
            'id_loaibanh' => 'required|exists:loaibanhs,id',
            'id_khoiluong' => 'required|exists:khoiluongs,id',
            'id_nhanbanh' => 'nullable|exists:nhanbanhs,id',
        ]);

        $variant = BienThe::where('id_sp', $validated['id_sp'])
            ->where('id_loaibanh', $validated['id_loaibanh'])
            ->where('id_khoiluong', $validated['id_khoiluong'])
            ->where('id_nhanbanh', $validated['id_nhanbanh'] ?? null)
            ->firstOrFail();

        return response()->json([
            'id' => $variant->id,
            'price' => $variant->gia,
            'sale_price' => $variant->giakm,
            'stock' => $variant->soluong,
            'slug' => $variant->slug
        ]);
    }

    public function updateLuotXem($id)
    {
        $sp = Sanpham::find($id);
        if ($sp) {
            $sp->increment('luotxem');
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}
