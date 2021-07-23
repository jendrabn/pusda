<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skpd;
use App\Models\SkpdCategory;

class SkpdController extends Controller
{
    public function index()
    {
        $skpd = Skpd::latest()->get();
        $categories = SkpdCategory::all();
        return view('admin.skpd.index', compact('skpd', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'nama' => ['required', 'string', 'max:100'],
            'singkatan' => ['required', 'string', 'max:100'],
            'skpd_category_id' => ['required', 'numeric', 'exists:skpd_categories,id']
        ]);

        Skpd::create($validated);
        return back()->with('alert-success', 'Berhasil menambahkan data');
    }

    public function edit(Skpd $skpd)
    {
        $categories = SkpdCategory::all();
        return view('admin.skpd.edit', compact('skpd', 'categories'));
    }

    public function update(Request $request, Skpd $skpd)
    {
        $validated =  $this->validate($request, [
            'nama' => ['required', 'string', 'max:100'],
            'singkatan' => ['required', 'string', 'max:100'],
            'skpd_category_id' => ['required', 'numeric', 'exists:skpd_categories,id']
        ]);

        $skpd->update($validated);
        return back()->with('alert-success', 'Data berhasil diupdate');
    }

    public function destroy(Skpd $skpd)
    {
        $skpd->delete();
        return back()->with('alert-success', 'Berhasil menghapus data SKPD');
    }
}
