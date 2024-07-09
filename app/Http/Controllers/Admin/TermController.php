<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * 利用規約ページを表示する
     */
    public function index()
    {
        $term = Term::first();
        return view('admin.terms.index', compact('term'));
    }

    /**
     * 利用規約編集ページを表示する
     */
    public function edit(Term $term)
    {
        return view('admin.terms.edit', compact('term'));
    }

    /**
     * 利用規約を更新する
     */
    public function update(Request $request, Term $term)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $term->update($request->all());

        return redirect()->route('admin.terms.index')->with('flash_message', '利用規約を編集しました。');
    }
}

