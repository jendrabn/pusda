<?php

namespace Database\Seeders;

use App\Models\TabelIndikator;
use App\Models\UraianIndikator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class UraianIndikatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $uraians = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
        // $uraians = collect($uraians->where('type', 'table')->where('name', 'uraian_indikator')->first()['data']);
        // $uraians = $uraians->map(function ($uraian) {
        //     return [
        //         'id' => $uraian['id_uraian_indikator'],
        //         'parent_id'  => $uraian['id_parent'] === '0' ? null : $uraian['id_parent'],
        //         'skpd_id'  => $uraian['id_skpd'],
        //         'tabel_indikator_id'  => $uraian['id_tabel_indikator'],
        //         'uraian'  => $uraian['uraian'],
        //         'satuan'  => $uraian['satuan'],
        //     ];
        // });

        // $uraians->each(function ($uraian) {
        //     $parent = UraianIndikator::where('id', $uraian['parent_id'])->first();
        //     $tabel = TabelIndikator::where('id', $uraian['tabel_indikator_id'])->first();
        //     if (!is_null($parent) && !is_null($tabel) || is_null($uraian['parent_id']) && !is_null($tabel)) {
        //         UraianIndikator::create($uraian);
        //     }
        // });

        $uraians = collect(json_decode(Storage::get('seeds/pusda_baru.json'), true));
        $uraians = $uraians->where('type', 'table')->where('name', 'uraian_indikator')->first()['data'];

        foreach (array_chunk($uraians, 1000) as $uraian) {
            UraianIndikator::insert($uraian);
        }
    }
}
