<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SkpdsDataTable;
use App\Events\UserLogged;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skpd;
use App\Models\SkpdCategory;

class SkpdController extends Controller
{
    public function index(SkpdsDataTable $dataTable)
    {

        $skpd = Skpd::latest()->get();
        $categories = SkpdCategory::all()->pluck('name', 'id');

        return $dataTable->render('admin.skpd.index', compact('skpd', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'nama' => ['required', 'string', 'max:100'],
            'singkatan' => ['required', 'string', 'max:100'],
            'skpd_category_id' => ['required', 'numeric', 'exists:skpd_categories,id']
        ]);

        $skpd = Skpd::create($validated);

        event(new UserLogged($request->user(), 'Menambahkan SKPD baru dengan nama ' . $skpd->nama));

        return back()->with('alert-success', 'Berhasil menambahkan SKPD baru');
    }

    public function edit(Skpd $skpd)
    {
        $categories = SkpdCategory::all()->pluck('name', 'id');

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

        event(new UserLogged($request->user(), 'Mengubah data SKPD'));

        return back()->with('alert-success', 'SKPD berhasil diupdate');
    }

    public function destroy(Request $request, Skpd $skpd)
    {
        $name = $skpd->nama;
        $skpd->delete();

        event(new UserLogged($request->user(), 'Menghapus SKPD ' . $name));

        return back()->with('alert-success', 'Berhasil menghapus data SKPD');
    }
}
