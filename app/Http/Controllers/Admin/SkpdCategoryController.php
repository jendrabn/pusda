<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkpdCategory;
use Illuminate\Http\Request;

class SkpdCategoryController extends Controller
{

    public function index()
    {
        $categories = SkpdCategory::all();
        return view('admin.skpd-category', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => ['required', 'string', 'max:50', 'unique:skpd_categories,name']]);
        SkpdCategory::create($request->all());

        return back()->with('alert-success', 'Berhasil menambahkan data');
    }

    public function update(Request $request, $id)
    {
        $category = SkpdCategory::findOrFail($id);
        $request->validate(['name' => ['required', 'string', 'max:50', 'unique:skpd_categories,name,' . $id]]);
        $category->update($request->all());

        return back()->with('alert-success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $category = SkpdCategory::findOrFail($id);
        $category->delete();

        return back()->with('alert-success', 'Data berhasil dihapus');
    }
}
