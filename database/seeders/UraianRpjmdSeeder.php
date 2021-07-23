<?php

namespace Database\Seeders;

use App\Models\TabelRpjmd;
use App\Models\UraianRpjmd;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class UraianRpjmdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $uraians = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
        // $uraians = collect($uraians->where('type', 'table')->where('name', 'uraian_rpjmd')->first()['data']);
        // $uraians = $uraians->map(function ($uraian) {
        //     return [
        //         'id' => $uraian['id_uraian_rpjmd'],
        //         'parent_id'  => $uraian['id_parent'] === '0' ? null : $uraian['id_parent'],
        //         'skpd_id' => $uraian['id_skpd'],
        //         'tabel_rpjmd_id' => $uraian['id_tabel_rpjmd'],
        //         'uraian' => $uraian['uraian'],
        //         'satuan' => $uraian['satuan'],
        //         'ketersediaan_data' => null,
        //     ];
        // });

        // $uraians->each(function ($uraian) {
        //     $parent = UraianRpjmd::where('id', $uraian['parent_id'])->first();
        //     $tabel = TabelRpjmd::where('id', $uraian['tabel_rpjmd_id'])->first();
        //     if (!is_null($parent) && !is_null($tabel) || is_null($uraian['parent_id']) && !is_null($tabel)) {
        //         UraianRpjmd::create($uraian);
        //     }
        // });

        $uraians = collect(json_decode(Storage::get('seeds/pusda_baru.json'), true));
        $uraians = $uraians->where('type', 'table')->where('name', 'uraian_rpjmd')->first()['data'];

        foreach (array_chunk($uraians, 1000) as $uraian) {
            UraianRpjmd::insert($uraian);
        }
    }
}
