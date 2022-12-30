<?php

namespace Database\Seeders;

use App\Models\Skpd;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SkpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skpds = collect(json_decode(Storage::get('seeds/pusda_lama.json'), true));
        $skpds = collect($skpds->where('type', 'table')->where('name', 'skpd')->first()['data']);
        Skpd::insert($skpds->map(function ($skpd) {
            $categories = [
                'Dinas' => 1,
                'Badan' => 2,
                'Bagian' => 3,
                'UPTD' => 4,
                'Lainnya' => 5
            ];

            return [
                'id' => $skpd['id_skpd'],
                'nama' => $skpd['nama_skpd'],
                'singkatan'  => $skpd['singkatan_skpd'],
                'kategori_skpd_id' => $categories[$skpd['kategori_skpd']] ?? null,
            ];
        })->toArray());

        // $skpds = collect(json_decode(Storage::get('seeds/pusda_baru.json'), true));
        // $skpds = $skpds->where('type', 'table')->where('name', 'skpd')->first()['data'];
        // Skpd::insert($skpds);
    }
}
