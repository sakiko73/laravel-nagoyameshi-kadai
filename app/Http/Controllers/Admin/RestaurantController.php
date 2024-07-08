<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\RegularHoliday;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        // 検索キーワードを取得
        $keyword = $request->input('keyword');

        // クエリビルダを作成
        $query = Restaurant::query();

        // キーワードが存在する場合は、店舗名で部分一致検索を行う
        if ($keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        }

        // ページネーション適用済みのrestaurantsテーブルのデータを取得
        $restaurants = $query->paginate(10);

        // 取得したデータの総数
        $total = $restaurants->total();

        // ビューに渡す変数
        return view('admin.restaurants.index', [
            'restaurants' => $restaurants,
            'keyword' => $keyword,
            'total' => $total,
        ]);
    }

    public function show(Restaurant $restaurant)
    {
        return view('admin.restaurants.show', compact('restaurant'));
    }

    public function edit(Restaurant $restaurant)
    {
        $categories = Category::all();
        $regular_holidays = RegularHoliday::all();
        // 設定されたカテゴリのIDを配列化する
        $category_ids = $restaurant->categories->pluck('id')->toArray();
        $regular_holiday_ids = $restaurant->regular_holidays->pluck('id')->toArray();

        return view('admin.restaurants.edit', compact('restaurant', 'categories', 'category_ids', 'regular_holidays', 'regular_holiday_ids'));
    }

    public function create()
    {
        $categories = Category::all();
        $regular_holidays = RegularHoliday::all();
        return view('admin.restaurants.create', compact('categories', 'regular_holidays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,bmp,gif,svg,webp|max:2048',
            'description' => 'required|string',
            'lowest_price' => 'required|integer|min:0|lte:highest_price',
            'highest_price' => 'required|integer|min:0|gte:lowest_price',
            'postal_code' => 'required|numeric|digits:7',
            'address' => 'required|string',
            'opening_time' => 'required|date_format:H:i|before:closing_time',
            'closing_time' => 'required|date_format:H:i|after:opening_time',
            'seating_capacity' => 'required|integer',
        ]);

        $restaurant = new Restaurant($request->all());

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('restaurants', 'public');
            $restaurant->image = $path;
        }

        $restaurant->save();

        $category_ids = array_filter($request->input('category_ids'));
        $restaurant->categories()->sync($category_ids);

        $regular_holiday_ids = array_filter($request->input('regular_holiday_ids'));
        $restaurant->regular_holidays()->sync($regular_holiday_ids);

        return redirect()->route('admin.restaurants.index')->with('flash_message', '店舗情報を登録しました。');
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,bmp,gif,svg,webp|max:2048',
            'description' => 'required|string',
            'lowest_price' => 'required|integer|min:0|lte:highest_price',
            'highest_price' => 'required|integer|min:0|gte:lowest_price',
            'postal_code' => 'required|numeric|digits:7',
            'address' => 'required|string',
            'opening_time' => 'required|date_format:H:i|before:closing_time',
            'closing_time' => 'required|date_format:H:i|after:opening_time',
            'seating_capacity' => 'required|integer',
        ]);

        $restaurant->update($request->all());

        $category_ids = array_filter($request->input('category_ids'));
        $restaurant->categories()->sync($category_ids);

        $regular_holiday_ids = array_filter($request->input('regular_holiday_ids'));
        $restaurant->regular_holidays()->sync($regular_holiday_ids);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('restaurants', 'public');
            $restaurant->update(['image' => $path]);
        }

        return redirect()->route('admin.restaurants.index')->with('flash_message', '店舗を編集しました。');
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return redirect()->route('admin.restaurants.index')->with('flash_message', '店舗を削除しました。');
    }
}
