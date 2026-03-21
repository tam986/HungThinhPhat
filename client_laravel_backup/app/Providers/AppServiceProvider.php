<?php

namespace App\Providers;

use App\Models\Danhmuc;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Yeuthich;
use App\Models\DanhMucBaiViet;


use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        $danhmucAll = Danhmuc::all();
        $danhmucBv = DanhMucBaiViet::orderBy('tendm','asc')->get();
        View::composer('*', function ($view) {
            $cart = Session::get('cart', []);
            if (!is_array($cart)) {
                $cart = [];
            }
            $totalItems = count($cart);
            $view->with('totalItems', $totalItems);

            if (Auth::check()) {

                $favoritesCount = Yeuthich::where('id_user', Auth::id())->count();
            } else {

                $favoritesCount = count(session('favorites', []));
            }

            $view->with('favoritesCount', $favoritesCount);
        });
        View::share('danhmucAll', $danhmucAll);
        View::share('danhmucBv',$danhmucBv);
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
