<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File8KelData;
use App\Models\Fitur8KelData;
use App\Models\Isi8KelData;
use App\Models\Skpd;
use App\Models\SkpdCategory;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DelapanKelDataController extends Controller
{

    public function index(Request $request)
    {
        $title = '8 Kelompok Data';
        $crudRoutePart = 'delapankeldata';
        $skpd = Skpd::find($request->skpd);
        $categories = Tabel8KelData::all();
        $tabelIds = $skpd?->uraian8KelData()
            ->select('tabel_8keldata_id as tabel_id')
            ->where('skpd_id', $request->skpd)
            ->groupBy('tabel_id')
            ->get();

        return view('admin.isiuraian.index', compact('title', 'crudRoutePart', 'categories', 'skpd', 'tabelIds'));
    }

    public function category(SkpdCategory $category)
    {
        $title = '8 Kelompok Data';
        $crudRoutePart = 'delapankeldata';

        return view('admin.isiUraian.category', compact('category', 'title', 'crudRoutePart'));
    }


    public function input(Request $request,  Tabel8KelData $tabel)
    {
        $title = '8 Kelompok Data';
        $crudRoutePart = 'delapankeldata';
        $skpd = Skpd::find($request->skpd);
        $categories = Tabel8KelData::all();
        $tabelIds = $skpd?->uraian8KelData()
            ->select('tabel_8keldata_id as tabel_id')
            ->where('skpd_id', $request->skpd)
            ->groupBy('tabel_id')
            ->get();

        $uraians = Uraian8KelData::getUraianByTableId($tabel->id);
        $fitur = Fitur8KelData::getFiturByTableId($tabel->id);
        $files = $tabel->file8KelData;
        $tahuns = $this->tahunList($tabel->id);
        $allSkpd = Skpd::all()->pluck('singkatan', 'id');


        return view('admin.isiuraian.input', compact('categories', 'skpd', 'tabel', 'uraians',  'fitur', 'files', 'tahuns', 'allSkpd', 'tabelIds', 'title', 'crudRoutePart'));
    }

    public function edit(Request $request, Uraian8KelData $uraian)
    {
        $isi = $uraian->isi8KelData()
            ->orderByDesc('tahun')
            ->groupBy('tahun')
            ->get(['tahun', 'isi']);

        $title = '8 Kelompok Data';
        $crudRoutePart = 'delapankeldata';
        $tahuns = $this->tahunList($uraian->tabel_8keldata_id);

        return view('admin.isiUraian.edit', compact('uraian', 'isi', 'title', 'crudRoutePart', 'tahuns'));
    }


    public function update(Request $request, Uraian8KelData $uraian)
    {

        $tahuns = $uraian->isi8KelData()
            ->select('tahun')
            ->get()
            ->map(fn ($tahun) => $tahun->tahun);

        $rules = [
            'uraian' => ['required', 'string'],
            'satuan' => ['required', 'string'],
            'ketersediaan_data' => ['required', 'boolean'],
        ];

        foreach ($tahuns as $tahun) {
            $rules['tahun_' . $tahun] = ['required', 'numeric'];
        }

        $this->validate($request, $rules);

        $uraian->update([
            'uraian' => $request->uraian,
            'satuan' =>  $request->satuan,
            'ketersediaan_data' => $request->ketersediaan_data
        ]);

        $isi = Isi8KelData::where('uraian_8keldata_id', $uraian->id)->get()->sortBy('tahun');

        foreach ($isi as $item) {
            $isi = Isi8KelData::find($item->id);
            $isi->isi = $request->get('tahun_' . $isi->tahun);
            $isi->save();
        }

        return back();
    }

    public function destroy(Uraian8KelData $uraian)
    {
        $uraian->delete();

        return back();
    }

    public function updateFitur(Request $request, Fitur8KelData $fitur)
    {
        $request->validate([
            'deskripsi' => ['nullable', 'string'],
            'analisis'  => ['nullable', 'string'],
            'permasalahan'  => ['nullable', 'string'],
            'solusi'  => ['nullable', 'string'],
            'saran'  => ['nullable', 'string']
        ]);

        $fitur->update($request->all());

        return back();
    }

    public function storeFile(Request $request, Tabel8KelData $tabel)
    {
        $request->validate([
            'file_document' => ['required', 'max:25600', 'mimes:pdf,doc,docx,xlsx,xls,csv'],
        ]);

        $file = $request->file('file_document');
        $fileName = date('dmyhis') . '-' . $file->getClientOriginalName();

        File8KelData::create([
            'tabel_8keldata_id' => $tabel->id,
            'file_name' =>  $file->storeAs('files', $fileName)
        ]);

        return back();
    }

    public function destroyFile(File8KelData $file)
    {

        Storage::delete($file->file_name);

        $file->delete();

        return back();
    }

    public function downloadFile(File8KelData $file)
    {
        return Storage::download($file->file_name);
    }

    public function updateSumberData(Request $request, Uraian8KelData $uraian)
    {
        $request->validate(['sumber_data' => ['required', 'exists:skpd,id']]);

        $uraian->skpd_id = $request->sumber_data;
        $uraian->save();

        return back();
    }

    public function storeTahun(Request $request, Tabel8KelData $tabel)
    {
        $request->validate(['tahun' => ['required', 'array']]);

        $tabel->uraian8KelData->each(function ($uraian) use ($request) {
            foreach ($request->tahun as $tahun) {
                if ($uraian->parent_id) {
                    $isi8KelData = Isi8KelData::where('uraian_8keldata_id', $uraian->id)
                        ->where('tahun', $tahun)
                        ->first();

                    if (is_null($isi8KelData)) {
                        Isi8KelData::create([
                            'uraian_8keldata_id' => $uraian->id,
                            'tahun' => $tahun,
                            'isi' => 0
                        ]);
                    }
                }
            }
        });

        return back();
    }

    public function destroyTahun(Tabel8KelData $tabel, $tahun)
    {
        $tabel->uraian8KelData->each(function ($uraian) use ($tahun) {
            $uraian->isi8KelData()->where('tahun', $tahun)->delete();
        });

        return back();
    }

    private function tahunList($tabelId)
    {
        return
            Isi8KelData::select('tahun')
            ->whereHas('uraian8KelData', function ($q) use ($tabelId) {
                $q->where('tabel_8keldata_id', '=', $tabelId);
            })
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get()
            ->map(fn ($tahun) => $tahun->tahun);
    }

    public function graphic(Request $request, Uraian8KelData $uraian)
    {
        abort_unless($request->ajax(), Response::HTTP_NOT_FOUND);

        $data = [
            'uraian' => $uraian?->uraian,
            'isi' => $uraian?->isi8KelData()->orderByDesc('tahun')->groupBy('tahun')->get(['tahun', 'isi'])
        ];

        return response()->json($data, Response::HTTP_OK);
    }
}
