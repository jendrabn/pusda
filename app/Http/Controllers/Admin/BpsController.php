<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserLogged;
use App\Http\Controllers\Controller;
use App\Models\FileBps;
use App\Models\FiturBps;
use App\Models\IsiBps;
use App\Models\TabelBps;
use App\Models\UraianBps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BpsController extends Controller
{
    public function index(TabelBps $tabelBps = null)
    {
        $categories = TabelBps::all();

        if (is_null($tabelBps)) {
            return view('admin.isiuraian.bps.index', compact('categories'));
        }

        $uraianBps = UraianBps::getUraianByTableId($tabelBps->id);
        $fiturBps = FiturBps::getFiturByTableId($tabelBps->id);
        $files = FileBps::where('tabel_bps_id', $tabelBps->id)->get();
        $years = IsiBps::getYears();

        return view('admin.isiuraian.bps.create', compact('tabelBps', 'categories', 'uraianBps',  'fiturBps', 'files', 'years'));
    }

    public function edit(Request $request, UraianBps $uraianBps)
    {
        abort_if(!$request->ajax(), 404);

        $isiBps = $uraianBps->isiBps()
            ->orderByDesc('tahun')
            ->groupBy('tahun')
            ->take(5)
            ->get(['tahun', 'isi']);

        $response = [
            'uraian_id' => $uraianBps->id,
            'uraian_parent_id' => $uraianBps->parent_id,
            'uraian' => $uraianBps->uraian,
            'satuan' => $uraianBps->satuan,
            'isi' =>  $isiBps,
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

        $uraianBps = UraianBps::findOrFail($request->uraian_id);
        $uraianBps->uraian = $request->uraian;
        $uraianBps->satuan = $request->satuan;
        $uraianBps->save();

        $isiBps = IsiBps::where('uraian_bps_id', $request->uraian_id)
            ->where('tahun', $request->tahun)
            ->get();

        foreach ($isiBps as $value) {
            $push = IsiBps::findOrFail($value->id);
            $push->isi = $request->isi;
            $push->save();
        }
        event(new UserLogged($request->user(), "Mengubah uraian  <i>{$uraianBps->uraian}</i>  BPS"));
        return back()->with('alert-success', 'Isi uraian berhasil diupdate');
    }

    public function destroy(Request $request, UraianBps $uraianBps)
    {
        $uraianBps->delete();
        event(new UserLogged($request->user(), "Menghapus uraian  <i>{$uraianBps->uraian}</i>  BPS"));
        return back()->with('alert-success', 'Isi uraian berhasil dihapus');
    }

    public function updateFitur(Request $request, FiturBps $fiturBps)
    {
        $validated = $this->validate($request, [
            'deskripsi' => ['nullable', 'string'],
            'analisis'  => ['nullable', 'string'],
            'permasalahan'  => ['nullable', 'string'],
            'solusi'  => ['nullable', 'string'],
            'saran'  => ['nullable', 'string']
        ]);

        $fiturBps->update($validated);
        event(new UserLogged($request->user(), "Mengubah fitur  <i>{$fiturBps}</i>  BPS"));
        return back()->with('alert-success', 'Fitur berhasil diupdate');
    }


    public function storeFile(Request $request, TabelBps $tabelBps)
    {
        $request->validate([
            'file_document' => ['required', 'max:10000', 'mimes:pdf,doc,docx,xlsx,xls,csv'],
        ]);

        $file = $request->file('file_document');
        $fileName = (FileBps::latest()->first()->id ?? '') . $file->getClientOriginalName();
        $file->storeAs('file_pusda', $fileName, 'public');

        FileBps::create([
            'tabel_bps_id' => $tabelBps->id,
            'file_name' =>  $fileName
        ]);
        event(new UserLogged($request->user(), "Menambah file pendukung  <i>{$fileName}</i>  pada menu  <i>{$tabelBps->menu_name}</i>  BPS"));
        return back()->with('alert-success', 'File pendukung berhasil diupload');
    }

    public function destroyFile(Request $request, FileBps $fileBps)
    {
        Storage::delete('public/file_pusda/' . $fileBps->file_name);
        $fileBps->delete();
        event(new UserLogged($request->user(), "Menghapus file pendukung  <i>{$fileBps->file_name}</i>  BPS"));
        return back()->with('alert-success', 'File pendukung berhasil dihapus');
    }

    public function downloadFile(Request $request, FileBps $fileBps)
    {
        event(new UserLogged($request->user(), "Mendownload file pendukung  <i>{$fileBps->file_name}</i>  BPS"));
        return Storage::download('public/file_pusda/' . $fileBps->file_name);
    }
}
