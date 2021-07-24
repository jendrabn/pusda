<?php

namespace Database\Seeders;

use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class Uraian8KelDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uraians = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
        $uraians =  collect($uraians->where('type', 'table')->where('name', 'uraian_8keldata')->first()['data']);
        $uraians = $uraians->map(function ($uraian) {
            return [
                'id' => $uraian['id_uraian_8keldata'],
                'parent_id' => $uraian['id_parent'] === '0' ? null : $uraian['id_parent'],
                'skpd_id' => $uraian['id_skpd'],
                'tabel_8keldata_id' => $uraian['id_tabel_8keldata'],
                'uraian' => $uraian['uraian'],
                'satuan' => $uraian['satuan'],
                'ketersediaan_data' => null,
            ];
        });

        $uraians->each(function ($uraian) {
            $parent = Uraian8KelData::where('id', $uraian['parent_id'])->first();
            $tabel = Tabel8KelData::where('id', $uraian['tabel_8keldata_id'])->first();
            if (!is_null($parent) && !is_null($tabel) || is_null($uraian['parent_id']) && !is_null($tabel)) {
                Uraian8KelData::create($uraian);
            }
        });

        //$uraians = collect(json_decode(Storage::get('seeds/pusda_baru.json'), true));
        //$uraians =  $uraians->where('type', 'table')->where('name', 'uraian_8keldata')->first()['data'];

        //foreach (array_chunk($uraians, 1000) as $uraian) {
        //    Uraian8KelData::insert($uraian);
        //}
    }
}
