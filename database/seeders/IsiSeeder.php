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
    private const YEARS = [2021, 2020, 2019, 2018, 2017, 2016];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tabel8KelData::with(['uraian8KelData', 'uraian8KelData.isi8KelData'])->get()->each(function ($tabel) {
            $tabel->uraian8KelData->each(function ($uraian) {
                foreach (self::YEARS as $year) {
                    if ($uraian->parent_id) {
                        $isi = $uraian->isi8KelData->where('tahun', $year)->first();
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

        TabelRpjmd::with(['uraianRpjmd', 'uraianRpjmd.isiRpjmd'])->get()->each(function ($tabel) {
            $tabel->uraianRpjmd->each(function ($uraian) {
                foreach (self::YEARS as $year) {
                    if ($uraian->parent_id) {
                        $isi = $uraian->isiRpjmd->where('tahun', $year)->first();
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

        TabelIndikator::with(['uraianIndikator', 'uraianIndikator.isiIndikator'])->get()->each(function ($tabel) {
            $tabel->uraianIndikator->each(function ($uraian) {
                foreach (self::YEARS as $year) {
                    if ($uraian->parent_id) {
                        $isi = $uraian->isiIndikator->where('tahun', $year)->first();
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

        TabelBps::with(['uraianBps', 'uraianBps.isiBps'])->each(function ($tabel) {
            $tabel->uraianBps->each(function ($uraian) {
                foreach (self::YEARS as $year) {
                    if ($uraian->parent_id) {
                        $isi = $uraian->isiBps->where('tahun', $year)->first();
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
