<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $company = Company::first(); // companiesテーブルの最初のデータを取得
        return view('company.index', compact('company'));
    }
}
