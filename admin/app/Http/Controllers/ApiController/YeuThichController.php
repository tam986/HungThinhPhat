<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Bienthe;
use App\Models\Yeuthich;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class YeuThichController extends Controller
{
    public function showProduct()
    {
        if (!Auth::check()) {
            return response()->json(['favorites' => []]);
        }

        $favorites = Yeuthich::where('id_user', Auth::id())
            ->with(['bienthe' => function ($query) {
                $query->with('sanpham');
            }])
            ->orderBy('thutu')
            ->get();

        return response()->json(compact('favorites'));
    }

    public function add(Request $request)
    {
        try {
            $data = $request->validate([
                'id_bienthe' => 'required|numeric',
                'url' => 'nullable|string'
            ]);

            $id_bienthe = $data['id_bienthe'];

            if (Auth::check()) {
                $exists = Yeuthich::where('id_user', Auth::id())
                    ->where('id_bienthe', $id_bienthe)
                    ->exists();

                if ($exists) {
                    $favoritesCount = Yeuthich::where('id_user', Auth::id())->count();
                    return response()->json([
                        'success' => false,
                        'message' => 'Sản phẩm đã có trong yêu thích!',
                        'favoritesCount' => $favoritesCount
                    ]);
                }

                Yeuthich::create([
                    'id_user' => Auth::id(),
                    'id_bienthe' => $id_bienthe,
                    'thutu' => Yeuthich::where('id_user', Auth::id())->max('thutu') + 1
                ]);

                $favoritesCount = Yeuthich::where('id_user', Auth::id())->count();

                return response()->json([
                    'success' => true,
                    'favorited' => true,
                    'message' => 'Đã thêm vào yêu thích',
                    'favoritesCount' => $favoritesCount
                ]);
            } else {
                $wishlist = Session::get('yeuthich', []);
                
                $exists = false;
                foreach($wishlist as $item) {
                    if (isset($item['id_bienthe']) && $item['id_bienthe'] == $id_bienthe) {
                        $exists = true;
                        break;
                    }
                }

                if ($exists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Sản phẩm đã có trong yêu thích!',
                        'favoritesCount' => count($wishlist)
                    ]);
                }

                $wishlist[] = ['id_bienthe' => $id_bienthe];
                Session::put('yeuthich', $wishlist);

                return response()->json([
                    'success' => true,
                    'favorited' => true,
                    'message' => 'Đã thêm vào yêu thích (Khách)',
                    'favoritesCount' => count($wishlist)
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Lỗi thêm yêu thích: ' . $e->getMessage(), $request->all());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi thêm yêu thích'
            ], 500);
        }
    }


    public function remove(Request $request)
    {
        try {
            $id_bienthe = $request->input('id_bienthe');

            if (!$id_bienthe || !is_numeric($id_bienthe)) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID biến thể không hợp lệ'
                ], 400);
            }

            if (Auth::check()) {
                $deleted = Yeuthich::where('id_user', Auth::id())
                    ->where('id_bienthe', $id_bienthe)
                    ->delete();

                return response()->json([
                    'success' => $deleted > 0,
                    'favorited' => false,
                    'message' => $deleted > 0 ? 'Đã xóa khỏi yêu thích' : 'Sản phẩm không có trong yêu thích'
                ]);
            } else {
                $wishlist = Session::get('yeuthich', []);
                $wishlist = array_filter($wishlist, fn($item) => $item['id_bienthe'] != $id_bienthe);
                Session::put('yeuthich', array_values($wishlist));

                return response()->json([
                    'success' => true,
                    'favorited' => false,
                    'message' => 'Đã xóa khỏi yêu thích'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Lỗi xóa yêu thích: ' . $e->getMessage(), [
                'id_bienthe' => $request->input('id_bienthe'),
                'user_id' => Auth::id(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lỗi server khi xóa yêu thích'
            ], 500);
        }
    }

    public function syncFavorites(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            foreach ($request->wishlist as $item) {
                Yeuthich::updateOrCreate(
                    ['id_user' => $user->id, 'id_bienthe' => $item['id_bienthe']],

                );
            }

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'User is not logged in.']);
    }
}
