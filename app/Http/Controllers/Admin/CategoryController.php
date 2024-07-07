<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * カテゴリ一覧ページ
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $query = Category::query();

        if ($keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        }

        $categories = $query->paginate(10);
        $total = $categories->total();

        return view('admin.categories.index', compact('categories', 'keyword', 'total'));
    }
/**
     * カテゴリ作成ページ
     */
    public function create()
    {
        return view('admin.categories.create');
    }



    /**
     * カテゴリ登録機能
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.categories.index')->with('flash_message', 'カテゴリを登録しました。');
    }

    /**
     * カテゴリ編集ページ
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * カテゴリ更新機能
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.categories.index')->with('flash_message', 'カテゴリを編集しました。');
    }

    /**
     * カテゴリ削除機能
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('flash_message', 'カテゴリを削除しました。');
    }
}