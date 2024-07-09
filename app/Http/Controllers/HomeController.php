<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
     // categoriesテーブルのすべてのデータを取得
     $categories = Category::all();

     // restaurantsテーブルから6つのデータを取得
     $highly_rated_restaurants = Restaurant::take(6)->get();

     // restaurantsテーブルから作成日時が新しい順に6つのデータを取得
     $new_restaurants = Restaurant::orderBy('created_at', 'desc')->take(6)->get();

     // ビューにデータを渡す
     return view('home', compact('categories', 'highly_rated_restaurants', 'new_restaurants'));
 
    }
}
