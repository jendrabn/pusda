<?php

namespace App\Http\Controllers\Admin;

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

    public function index()
    {
        $categories = TabelIndikator::with(['parent', 'childs.childs.childs'])->get();

        return view('admin.isiuraian.indikator.index', compact('categories'));
    }


    public function input(TabelIndikator $tabelIndikator)
    {
        $categories = TabelIndikator::with('childs.childs.childs')->get();
        $uraianIndikator = UraianIndikator::getUraianByTableId($tabelIndikator->id);
        $fiturIndikator = FiturIndikator::getFiturByTableId($tabelIndikator->id);
        $files = $tabelIndikator->fileIndikator;
        $years = IsiIndikator::getYears($tabelIndikator->id);

        return view('admin.isiuraian.indikator.input', compact('tabelIndikator', 'categories', 'uraianIndikator',  'fiturIndikator', 'files', 'years'));
    }

    public function edit(Request $request, UraianIndikator $uraianIndikator)
    {
        abort_if(!$request->ajax(), 404);

        $isiIndikator = $uraianIndikator->isiIndikator()
            ->orderByDesc('tahun')
            ->groupBy('tahun')
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
        $uraianIndikator = UraianIndikator::findOrFail($request->uraian_id);

        $years = $uraianIndikator->isiIndikator()
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

        $uraianIndikator->update([
            'uraian' => $request->uraian,
            'satuan' =>  $request->satuan,
        ]);

        $isiIndikator = IsiIndikator::where('uraian_indikator_id', $request->uraian_id)
            ->get()
            ->sortBy('tahun');

        foreach ($isiIndikator as $value) {
            $isi = IsiIndikator::find($value->id);
            $isi->isi = $request->get('tahun_' . $isi->tahun);
            $isi->save();
        }
        save_user_log('Mengubah isi uraian tabel indikator');

        return back()->with('alert-success', 'Isi uraian tabel indikator berhasil diupdate');
    }

    public function destroy(UraianIndikator $uraianIndikator)
    {
        $uraianIndikator->delete();
        save_user_log('Menghapus uraian tabel indikator');

        return back()->with('alert-success', 'Uraian tabel indikator berhasil dihapus');
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
        save_user_log('Mengubah fitur tabel indikator');

        return back()->with('alert-success', 'Fitur tabel indikator berhasil diupdate');
    }

    public function storeFile(Request $request, TabelIndikator $tabelIndikator)
    {
        $request->validate([
            'file_document' => ['required', 'max:10000', 'mimes:pdf,doc,docx,xlsx,xls,csv'],
        ]);

        $file = $request->file('file_document');
        $latestFileId = FileIndikator::latest()->first()->id ?? '0';
        $fileName = $latestFileId  . '_' .  $file->getClientOriginalName();
        $file->storeAs('file_pusda', $fileName, 'public');

        FileIndikator::create([
            'tabel_indikator_id' => $tabelIndikator->id,
            'file_name' =>  $fileName
        ]);

        save_user_log('Menambahkan file pendukung tabel indikator');

        return back()->with('alert-success', 'File tabel indikator pendukung berhasil diupload');
    }

    public function destroyFile(FileIndikator $fileIndikator)
    {
        Storage::disk('public')->delete('file_pusda/' . $fileIndikator->file_name);
        $fileIndikator->delete();
        save_user_log('Menghapus file pendukung tabel indikator');

        return back()->with('alert-success', 'File pendukung berhasil dihapus');
    }

    public function downloadFile(FileIndikator $fileIndikator)
    {
        $path = 'file_pusda/' . $fileIndikator->file_name;

        if (Storage::disk('public')->exists($path)) {
            save_user_log('Mengunduh file pendukung tabel indikator');

            return Storage::disk('public')->download($path);
        }

        return back()->with('alert-danger', 'File pendukung tidak ditemukan atau sudah terhapus');
    }

    public function storeTahun(Request $request, TabelIndikator $tabelIndikator)
    {
        $request->validate(['tahun' => ['required', 'array']]);

        $tabelIndikator->uraianIndikator->each(function ($uraian) use ($request) {
            foreach ($request->tahun as $tahun) {
                if ($uraian->parent_id) {
                    $isiIndikator = IsiIndikator::where('uraian_indikator_id', $uraian->id)->where('tahun', $tahun)->first();
                    if (is_null($isiIndikator)) {
                        IsiIndikator::create([
                            'uraian_indikator_id' => $uraian->id,
                            'tahun' => $tahun,
                            'isi' => 0
                        ]);
                    }
                }
            }
        });
        save_user_log('Menambahkan tahun tabel indikator');

        return back()->with('alert-success', 'Berhasil menambahkan tahun tabel indikator');
    }

    public function destroyTahun(TabelIndikator $tabelIndikator, $year)
    {
        $uraianIndikator = $tabelIndikator->uraianIndikator;
        $uraianIndikator->each(function ($uraian) use ($year) {
            $uraian->isiIndikator()->where('tahun', $year)->delete();
        });
        save_user_log('Menghapus tahun tabel indikator');

        return back()->with('alert-success', 'Berhasil menghapus tahun tabel indikator');
    }
}
