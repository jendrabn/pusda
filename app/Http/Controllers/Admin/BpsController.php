<?php

namespace App\Http\Controllers\Admin;

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
    public function index()
    {
        $categories = TabelBps::with('childs.childs.childs')->get();

        return view('admin.isiuraian.bps.index', compact('categories'));
    }

    public function input(TabelBps $tabelBps)
    {
        $categories = TabelBps::with('childs.childs.childs')->get();
        $uraianBps = UraianBps::getUraianByTableId($tabelBps->id);
        $fiturBps = FiturBps::getFiturByTableId($tabelBps->id);
        $files = $tabelBps->fileBps;
        $years = IsiBps::getYears($tabelBps->id);

        return view('admin.isiuraian.bps.input', compact('tabelBps', 'categories', 'uraianBps',  'fiturBps', 'files', 'years'));
    }

    public function edit(Request $request, UraianBps $uraianBps)
    {
        abort_if(!$request->ajax(), 404);

        $isiBps = $uraianBps->isiBps()
            ->orderByDesc('tahun')
            ->groupBy('tahun')
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
        $uraianBps = UraianBps::findOrFail($request->uraian_id);

        $years = $uraianBps->isiBps()
            ->select('tahun')
            ->get()
            ->map(fn ($year) => $year->tahun);

        $rules = [
            'uraian' => ['required', 'string'],
            'satuan' => ['required', 'string'],
        ];

        $customMessages = [];

        foreach ($years as $year) {
            $key = 'tahun_' . $year;
            $rules[$key] = ['required', 'numeric'];
            $customMessages[$key . '.required'] = "Data tahun {$year} wajib diisi";
            $customMessages[$key . '.numeric'] = "Data tahun {$year} harus berupa angka";
        }

        $this->validate($request, $rules, $customMessages);

        $uraianBps->update([
            'uraian' => $request->uraian,
            'satuan' =>  $request->satuan,
        ]);

        $isiBps = IsiBps::where('uraian_bps_id', $request->uraian_id)
            ->get()
            ->sortBy('tahun');

        foreach ($isiBps as $value) {
            $isi = IsiBps::find($value->id);
            $isi->isi = $request->get('tahun_' . $isi->tahun);
            $isi->save();
        }
        save_user_log('Mengubah isi uraian tabel BPS');

        return back()->with('alert-success', 'Isi uraian tabel BPS berhasil diupdate');
    }

    public function destroy(UraianBps $uraianBps)
    {
        $uraianBps->delete();
        save_user_log('Menghapus uraian tabel BPS');

        return back()->with('alert-success', 'Uraian tabel BPS berhasil dihapus');
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
        save_user_log('Mengubah fitur tabel BPS');

        return back()->with('alert-success', 'Fitur tabel BPS berhasil diupdate');
    }


    public function storeFile(Request $request, TabelBps $tabelBps)
    {
        $request->validate([
            'file_document' => ['required', 'max:10000', 'mimes:pdf,doc,docx,xlsx,xls,csv'],
        ]);

        $file = $request->file('file_document');
        $latestFileId = FileBps::latest()->first()->id ?? '0';
        $fileName = $latestFileId  . '_' .  $file->getClientOriginalName();
        $file->storeAs('file_pusda', $fileName, 'public');

        FileBps::create([
            'tabel_bps_id' => $tabelBps->id,
            'file_name' =>  $fileName
        ]);

        save_user_log('Mengupload file pendukung tabel BPS');

        return back()->with('alert-success', 'File pendukung tabel BPS berhasil diupload');
    }

    public function destroyFile(FileBps $fileBps)
    {
        Storage::disk('public')->delete('file_pusda/' . $fileBps->file_name);
        $fileBps->delete();
        save_user_log('Menghapus file pendukung tabel BPS');

        return back()->with('alert-success', 'File pendukung tabel BPS berhasil dihapus');
    }

    public function downloadFile(FileBps $fileBps)
    {
        $path = 'file_pusda/' . $fileBps->file_name;

        if (Storage::disk('public')->exists($path)) {
            save_user_log('Mengunduh file pendukung tabel BPS');

            return Storage::disk('public')->download($path);
        }

        return back()->with('alert-danger', 'File pendukung tidak ditemukan atau sudah terhapus');
    }

    public function storeTahun(Request $request, TabelBps $tabelBps)
    {
        $request->validate(['tahun' => ['required', 'array']]);

        $tabelBps->uraianBps->each(function ($uraian) use ($request) {
            foreach ($request->tahun as $tahun) {
                if ($uraian->parent_id) {
                    $isiBps = IsiBps::where('uraian_bps_id', $uraian->id)->where('tahun', $tahun)->first();
                    if (is_null($isiBps)) {
                        IsiBps::create([
                            'uraian_bps_id' => $uraian->id,
                            'tahun' => $tahun,
                            'isi' => 0
                        ]);
                    }
                }
            }
        });
        save_user_log('Menambahkan tahun tabel BPS');

        return back()->with('alert-success', 'Berhasil menambahkan tahun tabel BPS');
    }

    public function destroyTahun(TabelBps $tabelBps, $year)
    {
        $uraianBps = $tabelBps->uraianBps;
        $uraianBps->each(function ($uraian) use ($year) {
            $uraian->isibps()->where('tahun', $year)->delete();
        });
        save_user_log('Menghapus tahun tabel BPS');

        return back()->with('alert-success', 'Berhasil menghapus tahun tabel BPS');
    }
}
