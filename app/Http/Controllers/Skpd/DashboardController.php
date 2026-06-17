<?php

namespace App\Http\Controllers\Skpd;

use App\Http\Controllers\Controller;
use App\Models\Isi8KelData;
use App\Models\IsiRpjmd;
use App\Models\Tabel8KelData;
use App\Models\TabelRpjmd;
use App\Models\Uraian8KelData;
use App\Models\UraianBps;
use App\Models\UraianIndikator;
use App\Models\UraianRpjmd;
use App\Models\User;
use App\Models\AuditLog;
use App\Models\File8KelData;
use App\Models\FileRpjmd;
use App\Models\FileIndikator;
use App\Models\FileBps;
use App\Models\IsiBps;
use App\Models\IsiIndikator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

  public function __invoke(Request $request)
  {
    $skpdId = auth()->user()->skpd_id;

    $totalTabel8kel = Tabel8KelData::where('skpd_id', $skpdId)->count();
    $totalTabelRpjmd = TabelRpjmd::where('skpd_id', $skpdId)->count();
    $totalTabel = $totalTabel8kel + $totalTabelRpjmd;

    $totalUraian8kel = Uraian8KelData::where('skpd_id', $skpdId)->count();
    $totalUraianRpjmd = UraianRpjmd::where('skpd_id', $skpdId)->count();
    $totalUraianIndikator = UraianIndikator::where('skpd_id', $skpdId)->count();
    $totalUraianBps = UraianBps::where('skpd_id', $skpdId)->count();
    $totalUraian = $totalUraian8kel + $totalUraianRpjmd + $totalUraianIndikator + $totalUraianBps;

    $totalIsi8kel = Isi8KelData::whereHas('uraian8KelData', fn($q) => $q->where('skpd_id', $skpdId))->count();
    $totalIsiRpjmd = IsiRpjmd::whereHas('uraianRpjmd', fn($q) => $q->where('skpd_id', $skpdId))->count();
    $totalIsiIndikator = IsiIndikator::whereHas('uraianIndikator', fn($q) => $q->where('skpd_id', $skpdId))->count();
    $totalIsiBps = IsiBps::whereHas('uraianBps', fn($q) => $q->where('skpd_id', $skpdId))->count();
    $totalIsi = $totalIsi8kel + $totalIsiRpjmd + $totalIsiIndikator + $totalIsiBps;

    $totalFiles = File8KelData::whereHas('tabel8KelData', fn($q) => $q->where('skpd_id', $skpdId))->count()
      + FileRpjmd::whereHas('tabelRpjmd', fn($q) => $q->where('skpd_id', $skpdId))->count()
      + FileIndikator::whereHas('tabelIndikator', fn($q) => $q->whereHas('uraianIndikator', fn($q2) => $q2->where('skpd_id', $skpdId)))->count()
      + FileBps::whereHas('tabelBps', fn($q) => $q->whereHas('uraianBps', fn($q2) => $q2->where('skpd_id', $skpdId)))->count();

    $ketersediaanTersedia = Uraian8KelData::where('skpd_id', $skpdId)->where('ketersediaan_data', true)->count();
    $ketersediaanTotal = Uraian8KelData::where('skpd_id', $skpdId)->whereNotNull('ketersediaan_data')->count();
    $ketersediaanPersen = $ketersediaanTotal > 0 ? round(($ketersediaanTersedia / $ketersediaanTotal) * 100) : 0;

    $usersSkpd = User::where('skpd_id', $skpdId)->count();

    $dataPerYear8kel = Isi8KelData::select('tahun', DB::raw('count(*) as total'))
      ->whereHas('uraian8KelData', fn($q) => $q->where('skpd_id', $skpdId))
      ->whereNotNull('tahun')->groupBy('tahun')->orderBy('tahun')->get();
    $dataPerYearRpjmd = IsiRpjmd::select('tahun', DB::raw('count(*) as total'))
      ->whereHas('uraianRpjmd', fn($q) => $q->where('skpd_id', $skpdId))
      ->whereNotNull('tahun')->groupBy('tahun')->orderBy('tahun')->get();
    $dataPerYearIndikator = IsiIndikator::select('tahun', DB::raw('count(*) as total'))
      ->whereHas('uraianIndikator', fn($q) => $q->where('skpd_id', $skpdId))
      ->whereNotNull('tahun')->groupBy('tahun')->orderBy('tahun')->get();
    $dataPerYearBps = IsiBps::select('tahun', DB::raw('count(*) as total'))
      ->whereHas('uraianBps', fn($q) => $q->where('skpd_id', $skpdId))
      ->whereNotNull('tahun')->groupBy('tahun')->orderBy('tahun')->get();

    $allYears = collect();
    $dataPerYear8kel->each(fn($d) => $allYears->push($d->tahun));
    $dataPerYearRpjmd->each(fn($d) => $allYears->push($d->tahun));
    $dataPerYearIndikator->each(fn($d) => $allYears->push($d->tahun));
    $dataPerYearBps->each(fn($d) => $allYears->push($d->tahun));
    $allYears = $allYears->unique()->sort()->values();

    $chartYears = $allYears;
    $chart8kel = $chartYears->map(fn($y) => $dataPerYear8kel->firstWhere('tahun', $y)->total ?? 0);
    $chartRpjmd = $chartYears->map(fn($y) => $dataPerYearRpjmd->firstWhere('tahun', $y)->total ?? 0);
    $chartIndikator = $chartYears->map(fn($y) => $dataPerYearIndikator->firstWhere('tahun', $y)->total ?? 0);
    $chartBps = $chartYears->map(fn($y) => $dataPerYearBps->firstWhere('tahun', $y)->total ?? 0);

    $tabelSummaries = collect();
    Tabel8KelData::where('skpd_id', $skpdId)->whereNull('parent_id')->withCount('uraian8KelData')->each(function ($tabel) use ($tabelSummaries) {
      $isiCount = Isi8KelData::whereHas('uraian8KelData', fn($q) => $q->where('tabel_8keldata_id', $tabel->id))->count();
      $tabelSummaries->push([
        'nama' => $tabel->nama_menu,
        'tipe' => '8 Kel. Data',
        'uraian' => $tabel->uraian_8keldata_count,
        'isi' => $isiCount,
      ]);
    });
    TabelRpjmd::where('skpd_id', $skpdId)->whereNull('parent_id')->withCount('uraianRpjmd')->each(function ($tabel) use ($tabelSummaries) {
      $isiCount = IsiRpjmd::whereHas('uraianRpjmd', fn($q) => $q->where('tabel_rpjmd_id', $tabel->id))->count();
      $tabelSummaries->push([
        'nama' => $tabel->nama_menu,
        'tipe' => 'RPJMD',
        'uraian' => $tabel->uraian_rpjmd_count,
        'isi' => $isiCount,
      ]);
    });
    $tabelSummaries = $tabelSummaries->sortByDesc('isi')->take(10);

    $recentLogs = AuditLog::where('user_id', auth()->id())
      ->orWhereIn('user_id', User::where('skpd_id', $skpdId)->pluck('id'))
      ->with('user')->latest()->take(10)->get();

    $skpd = auth()->user()->skpd;

    return view('skpd.dashboard', compact(
      'skpd',
      'totalTabel',
      'totalTabel8kel',
      'totalTabelRpjmd',
      'totalUraian',
      'totalUraian8kel',
      'totalUraianRpjmd',
      'totalUraianIndikator',
      'totalUraianBps',
      'totalIsi',
      'totalFiles',
      'ketersediaanPersen',
      'ketersediaanTersedia',
      'ketersediaanTotal',
      'usersSkpd',
      'chartYears',
      'chart8kel',
      'chartRpjmd',
      'chartIndikator',
      'chartBps',
      'tabelSummaries',
      'recentLogs',
    ));
  }
}
