<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Term;

class TermController extends Controller
{
    public function index()
    {
        $term = Term::first(); // termsテーブルの最初のデータを取得
        return view('terms.index', compact('term'));
    }
}
