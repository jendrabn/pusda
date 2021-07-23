<?php

namespace Database\Seeders;

use App\Models\TabelBps;
use App\Models\UraianBps;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class UraianBpsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $uraians = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
        // $uraians = collect($uraians->where('type', 'table')->where('name', 'uraian_bps')->first()['data']);
        // $uraians = $uraians->map(function ($uraian) {
        //     return [
        //         'id' => $uraian['id_uraian_bps'],
        //         'parent_id' => $uraian['id_parent'] === '0' ? null : $uraian['id_parent'],
        //         'skpd_id' => $uraian['id_skpd'],
        //         'tabel_bps_id' => $uraian['id_tabel_bps'],
        //         'uraian' => $uraian['uraian'],
        //         'satuan' => $uraian['satuan'],
        //     ];
        // });

        // $uraians->each(function ($uraian) {
        //     $parent = UraianBps::where('id', $uraian['parent_id'])->first();
        //     $tabel = TabelBps::where('id', $uraian['tabel_bps_id'])->first();
        //     if (!is_null($parent) && !is_null($tabel) || is_null($uraian['parent_id']) && !is_null($tabel)) {
        //         UraianBps::create($uraian);
        //     }
        // });

        $uraians = collect(json_decode(Storage::get('seeds/pusda_baru.json'), true));
        $uraians = $uraians->where('type', 'table')->where('name', 'uraian_bps')->first()['data'];

        foreach (array_chunk($uraians, 1000) as $uraian) {
            UraianBps::insert($uraian);
        }
    }
}
