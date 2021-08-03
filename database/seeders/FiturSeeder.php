<?php

namespace Database\Seeders;

use App\Models\Fitur8KelData;
use App\Models\FiturBps;
use App\Models\FiturIndikator;
use App\Models\FiturRpjmd;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FiturSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $fiturs = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
        // $fiturs = collect($fiturs->where('type', 'table')->where('name', 'fitur_8keldata')->first()['data']);
        // $fiturs = $fiturs->map(function ($fitur) {
        //     return [
        //         'id' => $fitur['id_fitur_8keldata'],
        //         'tabel_8keldata_id' => $fitur['id_tabel_8keldata'],
        //         'deskripsi' => $fitur['deskripsi'],
        //         'analisis' => $fitur['analisis'],
        //         'permasalahan' => $fitur['permasalahan'],
        //         'solusi' => $fitur['solusi'],
        //         'saran' => $fitur['saran'],
        //     ];
        // });

        // $fiturs->each(function ($fitur) {
        //     $tabel = Tabel8KelData::where('id', $fitur['tabel_8keldata_id'])->first();
        //     if (!is_null($tabel)) {
        //         Fitur8KelData::create($fitur);
        //     }
        // });

        // $fiturs = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
        // $fiturs = collect($fiturs->where('type', 'table')->where('name', 'fitur_bps')->first()['data']);
        // $fiturs = $fiturs->map(function ($fitur) {
        //     return [
        //         'id' => $fitur['id_fitur_bps'],
        //         'tabel_bps_id' => $fitur['id_tabel_bps'],
        //         'deskripsi' => $fitur['deskripsi'],
        //         'analisis' => $fitur['analisis'],
        //         'permasalahan' => $fitur['permasalahan'],
        //         'solusi' => $fitur['solusi'],
        //         'saran' => $fitur['saran'],
        //     ];
        // });

        // $fiturs->each(function ($fitur) {
        //     $tabel = TabelBps::where('id', $fitur['tabel_bps_id'])->first();
        //     if (!is_null($tabel)) {
        //         FiturBps::create($fitur);
        //     }
        // });


        // $fiturs = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
        // $fiturs = collect($fiturs->where('type', 'table')->where('name', 'fitur_indikator')->first()['data']);
        // $fiturs = $fiturs->map(function ($fitur) {
        //     return [
        //         'id' => $fitur['id_fitur_indikator'],
        //         'tabel_indikator_id' => $fitur['id_tabel_indikator'],
        //         'deskripsi' => $fitur['deskripsi'],
        //         'analisis' => $fitur['analisis'],
        //         'permasalahan' => $fitur['permasalahan'],
        //         'solusi' => $fitur['solusi'],
        //         'saran' => $fitur['saran'],
        //     ];
        // });

        // $fiturs->each(function ($fitur) {
        //     $tabel = TabelIndikator::where('id', $fitur['tabel_indikator_id'])->first();
        //     if (!is_null($tabel)) {
        //         FiturIndikator::create($fitur);
        //     }
        // });

        // $fiturs = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
        // $fiturs = collect($fiturs->where('type', 'table')->where('name', 'fitur_rpjmd')->first()['data']);
        // $fiturs = $fiturs->map(function ($fitur) {
        //     return [
        //         'id' => $fitur['id_fitur_rpjmd'],
        //         'tabel_rpjmd_id'  => $fitur['id_tabel_rpjmd'],
        //         'deskripsi'  => $fitur['deskripsi'],
        //         'analisis'  => $fitur['analisis'],
        //         'permasalahan' => $fitur['permasalahan'],
        //         'saran' => $fitur['solusi'],
        //         'solusi' => $fitur['saran'],
        //     ];
        // });

        // $fiturs->each(function ($fitur) {
        //     $tabel = TabelRpjmd::where('id', $fitur['tabel_rpjmd_id'])->first();
        //     if (!is_null($tabel)) {
        //         FiturRpjmd::create($fitur);
        //     }
        // });

        $pusdaBaru = collect(json_decode(Storage::get('seeds/pusda_baru.json'), true));
        $fitur8KelData = $pusdaBaru->where('type', 'table')->where('name', 'fitur_8keldata')->first()['data'];
        $fiturBps = $pusdaBaru->where('type', 'table')->where('name', 'fitur_bps')->first()['data'];
        $fiturIndikator = $pusdaBaru->where('type', 'table')->where('name', 'fitur_indikator')->first()['data'];
        $fiturRpjmd = $pusdaBaru->where('type', 'table')->where('name', 'fitur_rpjmd')->first()['data'];

        foreach (array_chunk($fitur8KelData, 1000) as $fitur) {
            Fitur8KelData::insert($fitur);
        }

        foreach (array_chunk($fiturBps, 1000) as $fitur) {
            FiturBps::insert($fitur);
        }

        foreach (array_chunk($fiturIndikator, 1000) as $fitur) {
            FiturIndikator::insert($fitur);
        }

        foreach (array_chunk($fiturRpjmd, 1000)  as $fitur) {
            FiturRpjmd::insert($fitur);
        }
    }
}
