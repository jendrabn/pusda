<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\TabelRpjmd;
use App\Models\UraianRpjmd;
use App\Repositories\RpjmdRepository;
use Illuminate\Support\Facades\View;

class RpjmdController extends Controller
{

	public function __construct(private RpjmdRepository $repository)
	{
		View::share([
			'routePart' => 'rpjmd',
			'title' => 'RPJMD'
		]);
	}

	public function index()
	{
		$categories = TabelRpjmd::with('childs.childs.childs')->where('parent_id', 1)->get();

		return view('front.index', compact('categories'));
	}
	public function tabel(TabelRpjmd $tabel)
	{
		$uraians = $tabel->uraianRpjmd()->with('childs.isiRpjmd')->whereNull('parent_id')->get();
		$fitur = $tabel->fiturRpjmd;
		$tahuns = $this->repository->all_tahun($tabel->id);

		return view('front.tabel', compact('tabel', 'uraians', 'fitur', 'tahuns'));
	}

	public function chart(UraianRpjmd $uraian)
	{
		return response()->json($this->repository->grafik($uraian->id));
	}
}
