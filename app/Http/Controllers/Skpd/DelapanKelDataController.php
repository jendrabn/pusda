<?php

namespace App\Http\Controllers\Skpd;

use App\Http\Controllers\Controller;
use App\Models\File8KelData;
use App\Models\Fitur8KelData;
use App\Models\Isi8KelData;
use App\Models\Skpd;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DelapanKelDataController extends Controller
{

    public function index()
    {
        $skpd = Auth::user()->skpd;
        $categories = Tabel8KelData::with('childs.childs.childs')->get();
        $tabel8KelDataIds = Uraian8KelData::select('tabel_8keldata_id as id')
            ->where('skpd_id', $skpd->id)
            ->groupBy('tabel_8keldata_id')
            ->get();

        return view('skpd.isiuraian.8keldata.index', compact('skpd', 'tabel8KelDataIds', 'categories'));
    }

    public function input(Tabel8KelData $tabel8KelData)
    {
        $skpd = Auth::user()->skpd;
        $categories = Tabel8KelData::with('childs.childs.childs')->get();
        $tabel8KelDataIds = Uraian8KelData::select('tabel_8keldata_id as id')
            ->where('skpd_id', $skpd->id)
            ->groupBy('tabel_8keldata_id')
            ->get();

        $uraian8KelData = Uraian8KelData::getUraianByTableId($tabel8KelData->id);
        $fitur8KelData = Fitur8KelData::getFiturByTableId($tabel8KelData->id);
        $files = $tabel8KelData->file8KelData;
        $years = Isi8KelData::getYears($tabel8KelData->id);
        $allSkpd = Skpd::all()->pluck('singkatan', 'id');

        return view('skpd.isiuraian.8keldata.input', compact('tabel8KelDataIds', 'allSkpd', 'tabel8KelData', 'skpd', 'categories', 'uraian8KelData',  'fitur8KelData', 'files', 'years'));
    }

    public function edit(Request $request, Uraian8KelData $uraian8KelData)
    {
        abort_if(!$request->ajax(), 404);

        $isi8KelData = $uraian8KelData
            ->isi8KelData()
            ->orderByDesc('tahun')
            ->groupBy('tahun')
            ->get(['tahun', 'isi']);

        $response = [
            'uraian_id' => $uraian8KelData->id,
            'uraian_parent_id' => $uraian8KelData->parent_id,
            'uraian' => $uraian8KelData->uraian,
            'satuan' => $uraian8KelData->satuan,
            'ketersediaan_data' => $uraian8KelData->ketersediaan_data,
            'isi' =>  $isi8KelData,
        ];

        return response()->json($response);
    }

    public function update(Request $request)
    {
        $uraian8KelData = Uraian8KelData::findOrFail($request->uraian_id);

        $years = $uraian8KelData->isi8KelData()
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

        $uraian8KelData->update([
            'uraian' => $request->uraian,
            'satuan' =>  $request->satuan,
            'ketersediaan_data' => $request->ketersediaan_data,

        ]);

        $isi8KelData = Isi8KelData::where('uraian_8keldata_id', $request->uraian_id)
            ->get()
            ->sortBy('tahun');

        foreach ($isi8KelData as $value) {
            $isi = Isi8KelData::find($value->id);
            $isi->isi = $request->get('tahun_' . $isi->tahun);
            $isi->save();
        }

        return back()->with('alert-success', 'Isi uraian tabel 8 kelompok data berhasil diupdate');
    }

    public function destroy(Uraian8KelData $uraian8KelData)
    {
        $uraian8KelData->delete();

        return back()->with('alert-success', 'Uraian tabel 8 kelompok data berhasil dihapus');
    }

    public function updateFitur(Request $request, Fitur8KelData $fitur8KelData)
    {
        $validated =  $this->validate($request, [
            'deskripsi' => ['nullable', 'string'],
            'analisis'  => ['nullable', 'string'],
            'permasalahan'  => ['nullable', 'string'],
            'solusi'  => ['nullable', 'string'],
            'saran'  => ['nullable', 'string']
        ]);

        $fitur8KelData->update($validated);

        return back()->with('alert-success', 'Fitur tabel 8 kelompok data berhasil diupdate');
    }

    public function storeFile(Request $request, Tabel8KelData $tabel8KelData)
    {
        $request->validate([
            'file_document' => ['required', 'max:10000', 'mimes:pdf,doc,docx,xlsx,xls,csv'],
        ]);

        $file = $request->file('file_document');
        $latestFileId = File8KelData::latest()->first()->id ?? '0';
        $fileName = $latestFileId  . '_' .  $file->getClientOriginalName();
        $file->storeAs('file_pusda', $fileName, 'public');

        File8KelData::create([
            'tabel_8keldata_id' => $tabel8KelData->id,
            'file_name' =>  $fileName
        ]);

        return back()->with('alert-success', 'File pendukung tabel 8 kelompok data berhasil diupload');
    }

    public function destroyFile(File8KelData $file8KelData)
    {
        Storage::disk('public')->delete('file_pusda/' . $file8KelData->file_name);
        $file8KelData->delete();

        return back()->with('alert-success', 'File pendukung tabel 8 kelompok data berhasil dihapus');
    }

    public function downloadFile(File8KelData $file8KelData)
    {
        $path = 'file_pusda/' . $file8KelData->file_name;

        if (Storage::disk('public')->exists($path)) {

            return Storage::disk('public')->download($path);
        }

        return back()->with('alert-danger', 'File pendukung tidak ditemukan atau sudah terhapus');
    }
}
