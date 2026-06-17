<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\File8KelData;
use App\Models\FileBps;
use App\Models\FileIndikator;
use App\Models\FileRpjmd;
use App\Models\Fitur8KelData;
use App\Models\FiturBps;
use App\Models\FiturIndikator;
use App\Models\FiturRpjmd;
use App\Models\Isi8KelData;
use App\Models\IsiBps;
use App\Models\IsiIndikator;
use App\Models\IsiRpjmd;
use App\Models\Skpd;
use App\Models\Uraian8KelData;
use App\Models\UraianBps;
use App\Models\UraianIndikator;
use App\Models\UraianRpjmd;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function __invoke()
  {
    $totalSkpd = Skpd::count();
    $totalUsers = User::count();

    $totalUraian8kel = Uraian8KelData::count();
    $totalUraianRpjmd = UraianRpjmd::count();
    $totalUraianIndikator = UraianIndikator::count();
    $totalUraianBps = UraianBps::count();
    $totalUraian = $totalUraian8kel + $totalUraianRpjmd + $totalUraianIndikator + $totalUraianBps;

    $totalIsi8kel = Isi8KelData::count();
    $totalIsiRpjmd = IsiRpjmd::count();
    $totalIsiIndikator = IsiIndikator::count();
    $totalIsiBps = IsiBps::count();
    $totalIsi = $totalIsi8kel + $totalIsiRpjmd + $totalIsiIndikator + $totalIsiBps;

    $totalFiles = File8KelData::count() + FileRpjmd::count() + FileIndikator::count() + FileBps::count();

    $totalFitur = Fitur8KelData::count() + FiturRpjmd::count() + FiturIndikator::count() + FiturBps::count();

    $visitorsToday = Visitor::whereDate('date', today())->count();
    $visitorsMonth = Visitor::whereMonth('date', now()->month)->whereYear('date', now()->year)->count();
    $visitorsTotal = Visitor::count();

    $skpdDataCounts = Skpd::withCount([
      'uraian8KelData as count_8keldata',
      'uraianRpjmd as count_rpjmd',
    ])->get()->map(function ($skpd) {
      $indikatorCount = UraianIndikator::where('skpd_id', $skpd->id)->count();
      $bpsCount = UraianBps::where('skpd_id', $skpd->id)->count();
      return [
        'nama' => $skpd->nama,
        'singkatan' => $skpd->singkatan,
        'total' => $skpd->count_8keldata + $skpd->count_rpjmd + $indikatorCount + $bpsCount,
      ];
    })->sortByDesc('total')->take(10)->values();

    $dataPerYear8kel = Isi8KelData::select('tahun', DB::raw('count(*) as total'))
      ->whereNotNull('tahun')->groupBy('tahun')->orderBy('tahun')->get();
    $dataPerYearRpjmd = IsiRpjmd::select('tahun', DB::raw('count(*) as total'))
      ->whereNotNull('tahun')->groupBy('tahun')->orderBy('tahun')->get();
    $dataPerYearIndikator = IsiIndikator::select('tahun', DB::raw('count(*) as total'))
      ->whereNotNull('tahun')->groupBy('tahun')->orderBy('tahun')->get();
    $dataPerYearBps = IsiBps::select('tahun', DB::raw('count(*) as total'))
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

    $recentLogs = AuditLog::with('user')
      ->latest()->take(10)->get();

    $kategoriSkpd = Skpd::select('kategori_skpd.nama', DB::raw('count(*) as total'))
      ->join('kategori_skpd', 'skpd.kategori_skpd_id', '=', 'kategori_skpd.id')
      ->groupBy('kategori_skpd.nama')->orderByDesc('total')->get();

    return view('admin.dashboard', compact(
      'totalSkpd',
      'totalUsers',
      'totalUraian8kel',
      'totalUraianRpjmd',
      'totalUraianIndikator',
      'totalUraianBps',
      'totalUraian',
      'totalIsi8kel',
      'totalIsiRpjmd',
      'totalIsiIndikator',
      'totalIsiBps',
      'totalIsi',
      'totalFiles',
      'totalFitur',
      'visitorsToday',
      'visitorsMonth',
      'visitorsTotal',
      'skpdDataCounts',
      'chartYears',
      'chart8kel',
      'chartRpjmd',
      'chartIndikator',
      'chartBps',
      'recentLogs',
      'kategoriSkpd',
    ));
  }
}
