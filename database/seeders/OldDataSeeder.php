<?php

namespace Database\Seeders;

use App\Models\KategoriSkpd;
use App\Models\Skpd;
use App\Models\Tabel8KelData;
use App\Models\TabelBps;
use App\Models\TabelIndikator;
use App\Models\TabelRpjmd;
use App\Models\Uraian8KelData;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class OldDataSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $data = collect(json_decode(Storage::get('seeds/pusda_lama.json')))->where('type', 'table');

    // Kategori SKPD
    $kategoriSkpd = collect([
      ['id' => 1, 'nama' => 'Dinas'],
      ['id' => 2, 'nama' => 'Badan'],
      ['id' => 3, 'nama' => 'Bagian'],
      ['id' => 4, 'nama' => 'UPTD'],
      ['id' => 5, 'nama' => 'Lainnya'],
    ]);

    KategoriSkpd::insert($kategoriSkpd->toArray());

    // SKPD
    $skpd = collect($data->where('name', 'skpd')->first()->data)
      ->map(fn ($item) => [
        'id' => $item->id_skpd,
        'nama' => $item->nama_skpd,
        'singkatan'  => $item->singkatan_skpd,
        'kategori_skpd_id' => $kategoriSkpd->where('nama', $item->kategori_skpd)->first()['id'] ?? null,
      ]);

    Skpd::insert($skpd->toArray());

    // Users
    $users = collect($data->where('name', 'users')->first()->data)
      ->map(fn ($item) => [
        'id' => $item->id,
        'skpd_id' => $item->id_skpd,
        'name' => $item->name,
        'username' => $item->username,
        'email' => $item->email,
        'phone' => $item->no_hp,
        'address' => $item->alamat,
        'photo' => null,
        'birth_date' => null,
        'role' => intval($item->level) === 1 ? User::ROLE_ADMIN : User::ROLE_SKPD,
        'password' => $item->password,
        "remember_token" => $item->remember_token,
        "created_at" => $item->created_at,
        "updated_at" => $item->updated_at
      ]);

    User::insert($users->toArray());

    // Tabel 8 Kel. Data
    $tabel8KelData = collect($data->where('name', 'tabel_8keldata')->first()->data);
    $tabel8KelData = $tabel8KelData
      ->filter(function ($item) use ($tabel8KelData) {
        $parent = $tabel8KelData->where('id_tabel_8keldata', $item->id_parent)->first();

        return $parent || intval($item->id_parent) === 0;
      })
      ->map(fn ($item) => [
        'id' => $item->id_tabel_8keldata,
        'skpd_id' => $item->id_skpd,
        'parent_id' => intval($item->id_parent) === 0 ? null : $item->id_parent,
        'nama_menu' => $item->nama_menu
      ]);

    Tabel8KelData::insert($tabel8KelData->toArray());

    // Tabel RPJMD
    $tabelRpjmd = collect($data->where('name', 'tabel_rpjmd')->first()->data);
    $tabelRpjmd = $tabelRpjmd
      ->filter(function ($item) use ($tabelRpjmd) {
        $parent = $tabelRpjmd->where('id_tabel_rpjmd', $item->id_parent)->first();

        return $parent || intval($item->id_parent) === 0;
      })->map(fn ($item) => [
        'id' => $item->id_tabel_rpjmd,
        'skpd_id' => $item->id_skpd,
        'parent_id' => intval($item->id_parent) === 0 ? null : $item->id_parent,
        'nama_menu' => $item->nama_menu,
      ]);

    TabelRpjmd::insert($tabelRpjmd->toArray());

    // Tabel Indikator
    $tabelIndikator = collect($data->where('name', 'tabel_indikator')->first()->data);
    $tabelIndikator = $tabelIndikator
      ->filter(function ($item) use ($tabelIndikator) {
        $parent = $tabelIndikator->where('id_tabel_indikator', $item->id_parent)->first();

        return $parent || intval($item->id_parent) === 0;
      })->map(fn ($item) => [
        'id' => $item->id_tabel_indikator,
        // 'skpd_id' => $item->id_skpd,
        'parent_id' => intval($item->id_parent) === 0 ? null : $item->id_parent,
        'nama_menu' => $item->nama_menu,
      ]);

    TabelIndikator::insert($tabelIndikator->toArray());

    // Tabel BPS
    $tabelBps = collect($data->where('name', 'tabel_bps')->first()->data);
    $tabelBps = $tabelBps
      ->filter(function ($item) use ($tabelBps) {
        $parent = $tabelBps->where('id_tabel_bps', $item->id_parent)->first();

        return $parent || intval($item->id_parent) === 0;
      })->map(fn ($item) => [
        'id' => $item->id_tabel_bps,
        // 'skpd_id' => $item->id_skpd,
        'parent_id' => intval($item->id_parent) === 0 ? null : $item->id_parent,
        'nama_menu' => $item->nama_menu,
      ]);

    TabelBps::insert($tabelBps->toArray());

    // Uraian 8 Kel. Data
    // $uraian8KelData = collect($data->where('name', 'uraian_8keldata')->first()->data);
    // $uraian8KelData = $uraian8KelData
    //   ->filter(function ($item) use ($uraian8KelData, $tabel8KelData, $skpd) {
    //     $parent = $uraian8KelData->where('id_uraian_8keldata', $item->id_parent)->first();
    //     $tabel = $tabel8KelData->where('id_tabel_8keldata', $item->id_tabel_8keldata)->first();

    //     return $parent && $tabel || !$parent && $tabel;
    //   })
    //   ->map(fn ($item) => [
    //     'id' => $item->id_uraian_8keldata,
    //     'parent_id' => intval($item->id_parent) === 0 ? null : $item->id_parent,
    //     'skpd_id' => $item->id_skpd,
    //     'tabel_8keldata_id' => $item->id_tabel_8keldata,
    //     'uraian' => $item->uraian,
    //     'satuan' => $item->satuan,
    //     'ketersediaan_data' => match ($item->ketersediaan_data) {
    //       0 => 0,
    //       1 => 1,
    //       default => null
    //     },
    //     // "sumber_data" => null,
    //     'created_at' => $item->created_at,
    //     'updated_at' => $item->updated_at
    //   ]);


    // foreach (array_chunk($uraian8KelData->toArray(), 1000) as $uraian) {
    //   Uraian8KelData::insert($uraian);
    // }
  }
}
