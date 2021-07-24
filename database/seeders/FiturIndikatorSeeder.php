<?php

namespace Database\Seeders;

use App\Models\FiturIndikator;
use App\Models\TabelIndikator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FiturIndikatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fiturs = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
        $fiturs = collect($fiturs->where('type', 'table')->where('name', 'fitur_indikator')->first()['data']);
        $fiturs = $fiturs->map(function ($fitur) {
            return [
                'id' => $fitur['id_fitur_indikator'],
                'tabel_indikator_id' => $fitur['id_tabel_indikator'],
                'deskripsi' => $fitur['deskripsi'],
                'analisis' => $fitur['analisis'],
                'permasalahan' => $fitur['permasalahan'],
                'solusi' => $fitur['solusi'],
                'saran' => $fitur['saran'],
            ];
        });

        $fiturs->each(function ($fitur) {
            $tabel = TabelIndikator::where('id', $fitur['tabel_indikator_id'])->first();
            if (!is_null($tabel)) {
                FiturIndikator::create($fitur);
            }
        });

        //  $fiturs = collect(json_decode(Storage::get('seeds/pusda_baru.json'), true));
        //  $fiturs = $fiturs->where('type', 'table')->where('name', 'fitur_indikator')->first()['data'];

        // foreach (array_chunk($fiturs, 1000) as $fitur) {
        //   FiturIndikator::insert($fitur);
        // }
    }
}
