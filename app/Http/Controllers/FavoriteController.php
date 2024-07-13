<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //indexアクション
    public function index()
    {
        $user = auth()->user();
        $favorite_restaurants = $user->favorite_restaurants()
            ->paginate(15);

        return view('favorites.index', compact('favorite_restaurants'));
    }

    //storeアクション
    public function store(Request $request, $restaurantId)
    {
        $user = auth()->user();
        $restaurant = Restaurant::findOrFail($restaurantId);

        if (!$user->favorite_restaurants()->where('restaurant_id', $restaurantId)->exists()) {
            $user->favorite_restaurants()->attach($restaurantId);
        }

        return redirect()->back()->with('flash_message', 'お気に入りに追加しました。');
    }

    //destroyアクション
    public function destroy($restaurantId)
    {
        $user = auth()->user();
        $restaurant = Restaurant::findOrFail($restaurantId);

        if ($user->favorite_restaurants()->where('restaurant_id', $restaurantId)->exists()) {
            $user->favorite_restaurants()->detach($restaurantId);
        }

        return redirect()->back()->with('flash_message', 'お気に入りを解除しました。');
    }
}
