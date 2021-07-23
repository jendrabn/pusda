<?php

namespace App\Http\Controllers\Skpd;

use App\Exports\DelapanKelDataExport;
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
use Maatwebsite\Excel\Facades\Excel;

class DelapanKelDataController extends Controller
{

    public function index(Tabel8KelData $tabel8KelData = null)
    {
        $skpd = Auth::user()->skpd;
        $categories = Tabel8KelData::all();
        $tabel8KelDataIds = Uraian8KelData::select('tabel_8keldata_id as id')
            ->where('skpd_id', $skpd->id)
            ->groupBy('tabel_8keldata_id')
            ->get();

        if (is_null($tabel8KelData)) {
            return view('skpd.isiuraian.8keldata.index', compact('skpd', 'tabel8KelDataIds', 'categories'));
        }

        $uraian8KelData = Uraian8KelData::getUraianByTableId($tabel8KelData->id);
        $fitur8KelData = Fitur8KelData::getFiturByTableId($tabel8KelData->id);
        $files = File8KelData::where('tabel_8keldata_id', $tabel8KelData->id)->get();
        $years = Isi8KelData::getYears();
        $allSkpd = Skpd::all()->pluck('singkatan', 'id');

        return view('skpd.isiuraian.8keldata.create', compact('tabel8KelDataIds', 'allSkpd', 'tabel8KelData', 'skpd', 'categories', 'uraian8KelData',  'fitur8KelData', 'files', 'years'));
    }

    public function edit(Request $request, Uraian8KelData $uraian8KelData)
    {
        abort_if(!$request->ajax(), 404);

        $isi8KelData = $uraian8KelData
            ->isi8KelData()
            ->orderByDesc('tahun')
            ->groupBy('tahun')
            ->take(5)
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
        $request->validate([
            'uraian' => ['required', 'string'],
            'satuan' => ['required', 'string'],
            'ketersediaan_data' => ['required', 'boolean']
        ]);

        $uraian8KelData = Uraian8KelData::findOrFail($request->uraian_id);
        $uraian8KelData->uraian = $request->uraian;
        $uraian8KelData->satuan = $request->satuan;
        $uraian8KelData->ketersediaan_data = $request->ketersediaan_data;
        $uraian8KelData->save();

        $isi8KelData = Isi8KelData::where('uraian_8keldata_id', $request->uraian_id)->take(5)->get()->sortBy('tahun');

        $n = 1;
        foreach ($isi8KelData as $value) {
            $push = Isi8KelData::findOrFail($value->id);
            if ($n == 1) {
                $push->isi = $request->t1;
            } else if ($n == 2) {
                $push->isi = $request->t2;
            } else if ($n == 3) {
                $push->isi = $request->t3;
            } else if ($n == 4) {
                $push->isi = $request->t4;
            } else {
                $push->isi = $request->t5;
            }
            $push->save();
            $n++;
        }

        return back()->with('alert-success', 'Isi uraian berhasil diupdate');
    }

    public function destroy(Uraian8KelData $uraian8KelData)
    {
        $uraian8KelData->delete();
        return back()->with('alert-success', 'Isi uraian berhasil dihapus');
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

        return back()->with('alert-success', 'Fitur berhasil diupdate');
    }

    public function storeFile(Request $request, Tabel8KelData $tabel8KelData)
    {
        $request->validate([
            'file_document' => ['required', 'max:10000', 'mimes:pdf,doc,docx,xlsx,xls,csv'],
        ]);

        $file = $request->file('file_document');
        $fileName = (File8KelData::latest()->first()->id ?? '') . $file->getClientOriginalName();
        $file->storeAs('file_pusda', $fileName, 'public');

        File8KelData::create([
            'tabel_8keldata_id' => $tabel8KelData->id,
            'file_name' =>  $fileName
        ]);

        return back()->with('alert-success', 'File pendukung berhasil diupload');
    }

    public function destroyFile(File8KelData $file8KelData)
    {
        Storage::delete('public/file_pusda/' . $file8KelData->file_name);
        $file8KelData->delete();

        return back()->with('alert-success', 'File pendukung berhasil dihapus');
    }

    public function downloadFile(File8KelData $file8KelData)
    {
        return Storage::download('public/file_pusda/' . $file8KelData->file_name);
    }
}
