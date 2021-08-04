<?php

namespace App\Http\Controllers\Skpd;

use App\Http\Controllers\Controller;
use App\Models\FileRpjmd;
use App\Models\FiturRpjmd;
use App\Models\IsiRpjmd;
use App\Models\Skpd;
use App\Models\TabelRpjmd;
use App\Models\UraianRpjmd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RpjmdController extends Controller
{
    public function index()
    {
        $categories = TabelRpjmd::with('childs.childs.childs')->get();
        $skpd = Auth::user()->skpd;
        $tabelRpjmdIds = UraianRpjmd::select('tabel_rpjmd_id as id')
            ->where('skpd_id', $skpd->id)
            ->groupBy('tabel_rpjmd_id')
            ->get();

        return view('skpd.isiuraian.rpjmd.index', compact('skpd', 'tabelRpjmdIds', 'categories'));
    }

    public function input(TabelRpjmd $tabelRpjmd)
    {
        $skpd = Auth::user()->skpd;

        $tabelRpjmdIds = UraianRpjmd::select('tabel_rpjmd_id as id')
            ->where('skpd_id', $skpd->id)
            ->groupBy('tabel_rpjmd_id')
            ->get();

        $categories = TabelRpjmd::with('childs.childs.childs')->get();
        $uraianRpjmd = UraianRpjmd::getUraianByTableId($tabelRpjmd->id);
        $fiturRpjmd = FiturRpjmd::getFiturByTableId($tabelRpjmd->id);
        $files = $tabelRpjmd->fileRpjmd;
        $years = IsiRpjmd::getYears($tabelRpjmd->id);
        $allSkpd = Skpd::all()->pluck('singkatan', 'id');

        return view('skpd.isiuraian.rpjmd.input', compact('tabelRpjmdIds', 'allSkpd', 'tabelRpjmd', 'skpd', 'categories', 'uraianRpjmd',  'fiturRpjmd', 'files', 'years'));
    }

    public function edit(Request $request, UraianRpjmd $uraianRpjmd)
    {
        abort_if(!$request->ajax(), 404);

        $isiRpjmd = $uraianRpjmd->isiRpjmd()->orderByDesc('tahun')->groupBy('tahun')->get(['tahun', 'isi']);

        $response = [
            'uraian_id' => $uraianRpjmd->id,
            'uraian_parent_id' => $uraianRpjmd->parent_id,
            'uraian' => $uraianRpjmd->uraian,
            'satuan' => $uraianRpjmd->satuan,
            'ketersediaan_data' => $uraianRpjmd->ketersediaan_data,
            'isi' =>  $isiRpjmd,
        ];

        return response()->json($response);
    }

    public function update(Request $request)
    {

        $uraianRpjmd = UraianRpjmd::findOrFail($request->uraian_id);

        $years = $uraianRpjmd->isiRpjmd()
            ->select('tahun')
            ->get()
            ->map(fn ($year) => $year->tahun);

        $rules = [
            'uraian' => ['required', 'string'],
            'satuan' => ['required', 'string'],
            'ketersediaan_data' => ['required', 'integer'],
        ];

        $customMessages = [];

        foreach ($years as $year) {
            $key = 'tahun_' . $year;
            $rules[$key] = ['required', 'numeric'];
            $customMessages[$key . '.required'] = "Data tahun {$year} wajib diisi";
            $customMessages[$key . '.numeric'] = "Data tahun {$year} harus berupa angka";
        }

        $this->validate($request, $rules, $customMessages);

        $uraianRpjmd->update([
            'uraian' => $request->uraian,
            'satuan' =>  $request->satuan,
            'ketersediaan_data' => $request->ketersediaan_data,
        ]);

        $isiRpjmd = IsiRpjmd::where('uraian_rpjmd_id', $request->uraian_id)
            ->get()
            ->sortBy('tahun');

        foreach ($isiRpjmd as $value) {
            $isi = IsiRpjmd::find($value->id);
            $isi->isi = $request->get('tahun_' . $isi->tahun);
            $isi->save();
        }
        save_user_log('Mengubah isi uraian tabel RPJMD');

        return back()->with('alert-success', 'Isi uraian tabel RPJMD berhasil diupdate');
    }

    public function destroy(UraianRpjmd $uraianRpjmd)
    {
        $uraianRpjmd->delete();
        save_user_log('Menghapus uraian tabel RPJMD');

        return back()->with('alert-success', 'Uraian tabel RPJMD berhasil dihapus');
    }


    public function updateFitur(Request $request, FiturRpjmd $fiturRpjmd)
    {
        $validated =  $this->validate($request, [
            'deskripsi' => ['nullable', 'string'],
            'analisis'  => ['nullable', 'string'],
            'permasalahan'  => ['nullable', 'string'],
            'solusi'  => ['nullable', 'string'],
            'saran'  => ['nullable', 'string']
        ]);

        $fiturRpjmd->update($validated);
        save_user_log('Mengubah fitur tabel RPJMD');

        return back()->with('alert-success', 'Fitur tabel RPJMD berhasil diupdate');
    }

    public function storeFile(Request $request, TabelRpjmd $tabelRpjmd)
    {
        $request->validate([
            'file_document' => ['required', 'max:10000', 'mimes:pdf,doc,docx,xlsx,xls,csv'],
        ]);

        $file = $request->file('file_document');
        $latestFileId = FileRpjmd::latest()->first()->id ?? '0';
        $fileName = $latestFileId  . '_' .  $file->getClientOriginalName();
        $file->storeAs('file_pusda', $fileName, 'public');

        FileRpjmd::create([
            'tabel_rpjmd_id' => $tabelRpjmd->id,
            'file_name' =>  $fileName
        ]);
        save_user_log('Menambahkan file pendukung tabel RPJMD');

        return back()->with('alert-success', 'Berhasil menambahkan file pendukung tabel RPJMD');
    }

    public function destroyFile(FileRpjmd $fileRpjmd)
    {
        Storage::disk('public')->delete('file_pusda/' . $fileRpjmd->file_name);
        $fileRpjmd->delete();
        save_user_log('Menghapus file pendukung tabel RPJMD');

        return back()->with('alert-success', 'File pendukung tabel RPJMD berhasil dihapus');
    }

    public function downloadFile(FileRpjmd $fileRpjmd)
    {
        $path = 'file_pusda/' . $fileRpjmd->file_name;

        if (Storage::disk('public')->exists($path)) {
            save_user_log('Mengunduh file pendukung tabel RPJMD');

            return Storage::disk('public')->download($path);
        }

        return back()->with('alert-danger', 'File pendukung tidak ditemukan atau sudah terhapus');
    }
}
