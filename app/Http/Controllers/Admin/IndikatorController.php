<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserLogged;
use App\Http\Controllers\Controller;
use App\Models\FileIndikator;
use App\Models\FiturIndikator;
use App\Models\IsiIndikator;
use App\Models\TabelIndikator;
use App\Models\UraianIndikator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IndikatorController extends Controller
{

    public function index(TabelIndikator $tabelIndikator = null)
    {
        $categories = TabelIndikator::all();

        if (is_null($tabelIndikator)) {
            return view('admin.isiuraian.indikator.index', compact('categories'));
        }

        $uraianIndikator = UraianIndikator::getUraianByTableId($tabelIndikator->id);
        $fiturIndikator = FiturIndikator::getFiturByTableId($tabelIndikator->id);
        $files = FileIndikator::where('tabel_indikator_id', $tabelIndikator->id)->get();
        $years = IsiIndikator::getYears();

        return view('admin.isiuraian.indikator.create', compact('tabelIndikator', 'categories', 'uraianIndikator',  'fiturIndikator', 'files', 'years'));
    }

    public function edit(Request $request, UraianIndikator $uraianIndikator)
    {
        abort_if(!$request->ajax(), 404);

        $isiIndikator = $uraianIndikator->isiIndikator()
            ->orderByDesc('tahun')
            ->groupBy('tahun')->take(5)
            ->get(['tahun', 'isi']);

        $response = [
            'uraian_id' => $uraianIndikator->id,
            'uraian_parent_id' => $uraianIndikator->parent_id,
            'uraian' => $uraianIndikator->uraian,
            'satuan' => $uraianIndikator->satuan,
            'isi' =>  $isiIndikator,
        ];

        return response()->json($response);
    }

    public function update(Request $request)
    {
        $request->validate([
            'uraian' => ['required', 'string'],
            'satuan' => ['required', 'string'],
            'tahun' => ['required', 'numeric'],
            'isi' => ['required', 'numeric'],
        ]);

        $uraianIndikator = UraianIndikator::findOrFail($request->uraian_id);
        $uraianIndikator->uraian = $request->uraian;
        $uraianIndikator->satuan = $request->satuan;
        $uraianIndikator->save();

        $isiIndikator = IsiIndikator::where('uraian_indikator_id', $request->uraian_id)
            ->where('tahun',$request->tahun)
            ->get();

        foreach ($isiIndikator as $value) {
            $push = IsiIndikator::findOrFail($value->id);
            $push->isi = $request->isi;
            $push->save();
        }
        event(new UserLogged($request->user(), "Mengubah uraian  {$uraianIndikator->uraian}  Indikator"));
        return back()->with('alert-success', 'Isi uraian berhasil diupdate');
    }

    public function destroy(Request $request, UraianIndikator $uraianIndikator)
    {
        $uraianIndikator->delete();
        event(new UserLogged($request->user(), "Menghapus uraian  <i>{$uraianIndikator->uraian}</i>  Indikator"));
        return back()->with('alert-success', 'Isi uraian berhasil dihapus');
    }

    public function updateFitur(Request $request, FiturIndikator $fiturIndikator)
    {
        $validated = $this->validate($request, [
            'deskripsi' => ['nullable', 'string'],
            'analisis'  => ['nullable', 'string'],
            'permasalahan'  => ['nullable', 'string'],
            'solusi'  => ['nullable', 'string'],
            'saran'  => ['nullable', 'string']
        ]);

        $fiturIndikator->update($validated);
        event(new UserLogged($request->user(), "Mengubah fitur  <i>{$fiturIndikator}</i>  Indikator"));
        return back()->with('alert-success', 'Fitur berhasil diupdate');
    }

    public function storeFile(Request $request, TabelIndikator $tabelIndikator)
    {
        $request->validate([
            'file_document' => ['required', 'max:10000', 'mimes:pdf,doc,docx,xlsx,xls,csv'],
        ]);

        $file = $request->file('file_document');
        $fileName = (FileIndikator::latest()->first()->id ?? '') . $file->getClientOriginalName();
        $file->storeAs('file_pusda', $fileName, 'public');

        FileIndikator::create([
            'tabel_indikator_id' => $tabelIndikator->id,
            'file_name' =>  $fileName
        ]);
        event(new UserLogged($request->user(), "Menambah file pendukung  <i>{$fileName}</i>  pada menu  <i>{$tabelIndikator->menu_name}</i>  Indikator"));
        return back()->with('alert-success', 'File pendukung berhasil diupload');
    }

    public function destroyFile(Request $request, FileIndikator $fileIndikator)
    {
        Storage::delete('public/file_pusda/' . $fileIndikator->file_name);
        $fileIndikator->delete();
        event(new UserLogged($request->user(), "Menghapus file pendukung  <i>{$fileIndikator->file_name}</i>  Indikator"));
        return back()->with('alert-success', 'File pendukung berhasil dihapus');
    }

    public function downloadFile(Request $request, FileIndikator $fileIndikator)
    {
        return Storage::download('public/file_pusda/' . $fileIndikator->file_name);
        event(new UserLogged($request->user(), "Mendownload file pendukung  <i>{$fileIndikator->file_name}</i>  Indikator"));
    }
}
