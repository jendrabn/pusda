<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\TabelBps;
use App\Models\UraianBps;
use App\Repositories\BpsRepository;
use Illuminate\Support\Facades\View;

class BpsController extends Controller
{
	public function __construct(private BpsRepository $repository)
	{
		View::share([
			'routePart' => 'bps',
			'title' => 'BPS'
		]);
	}

	public function index()
	{
		$categories = TabelBps::with('childs.childs.childs')->where('parent_id', 1)->get();

		return view('front.index', compact('categories'));
	}

	public function tabel(TabelBps $tabel)
	{
		$uraians = $tabel->uraianBps()->with('childs.isiBps')->whereNull('parent_id')->get();
		$fitur = $tabel->fiturBps;
		$tahuns = $this->repository->all_tahun($tabel->id);

		return view('front.tabel', compact('tabel', 'uraians', 'fitur', 'tahuns'));
	}

	public function chart(UraianBps $uraian)
	{
		return response()->json($this->repository->grafik($uraian->id));
	}
}
