<?php

namespace Database\Seeders;

use App\Models\Isi8KelData;
use App\Models\IsiBps;
use App\Models\IsiIndikator;
use App\Models\IsiRpjmd;
use App\Models\Tabel8KelData;
use App\Models\TabelBps;
use App\Models\TabelIndikator;
use App\Models\TabelRpjmd;
use Illuminate\Database\Seeder;

class IsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tabel8KelData::all()->each(function ($tabel) {
            $tabel->uraian8KelData->each(function ($uraian) {
                $years = [2021, 2020, 2019, 2018, 2017];
                foreach ($years as $year) {
                    if ($uraian->parent_id) {
                        $isi = Isi8KelData::where('uraian_8keldata_id', $uraian->id)->where('tahun', $year)->first();
                        if (is_null($isi)) {
                            Isi8KelData::create([
                                'uraian_8keldata_id' => $uraian->id,
                                'tahun' => $year,
                                'isi' => 0
                            ]);
                        }
                    }
                }
            });
        });

        TabelRpjmd::all()->each(function ($tabel) {
            $tabel->uraianRpjmd->each(function ($uraian) {
                $years = [2021, 2020, 2019, 2018, 2017];
                foreach ($years as $year) {
                    if ($uraian->parent_id) {
                        $isi = IsiRpjmd::where('uraian_rpjmd_id', $uraian->id)->where('tahun', $year)->first();
                        if (is_null($isi)) {
                            IsiRpjmd::create([
                                'uraian_rpjmd_id' => $uraian->id,
                                'tahun' => $year,
                                'isi' => 0
                            ]);
                        }
                    }
                }
            });
        });

        TabelIndikator::all()->each(function ($tabel) {
            $tabel->uraianIndikator->each(function ($uraian) {
                $years = [2021, 2020, 2019, 2018, 2017];
                foreach ($years as $year) {
                    if ($uraian->parent_id) {
                        $isi = IsiIndikator::where('uraian_indikator_id', $uraian->id)->where('tahun', $year)->first();
                        if (is_null($isi)) {
                            IsiIndikator::create([
                                'uraian_indikator_id' => $uraian->id,
                                'tahun' => $year,
                                'isi' => 0
                            ]);
                        }
                    }
                }
            });
        });

        TabelBps::all()->each(function ($tabel) {
            $tabel->uraianBps->each(function ($uraian) {
                $years = [2021, 2020, 2019, 2018, 2017];
                foreach ($years as $year) {
                    if ($uraian->parent_id) {
                        $isi = IsiBps::where('uraian_bps_id', $uraian->id)->where('tahun', $year)->first();
                        if (is_null($isi)) {
                            IsiBps::create([
                                'uraian_bps_id' => $uraian->id,
                                'tahun' => $year,
                                'isi' => 0
                            ]);
                        }
                    }
                }
            });
        });
    }
}
