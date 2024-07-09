<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * 会社概要ページを表示する
     */
    public function index()
    {
        $company = Company::first();
        return view('admin.company.index', compact('company'));
    }

    /**
     * 会社概要編集ページを表示する
     */
    public function edit(Company $company)
    {
        return view('admin.company.edit', compact('company'));
    }


/**
     * 会社概要を更新する
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string',
            'postal_code' => 'required|numeric|digits:7',
            'address' => 'required|string',
            'representative' => 'required|string',
            'establishment_date' => 'required|string',
            'capital' => 'required|string',
            'business' => 'required|string',
            'number_of_employees' => 'required|string',
        ]);

        $company->update($request->all());

        return redirect()->route('admin.company.index')->with('flash_message', '会社概要を編集しました。');
    }

}
