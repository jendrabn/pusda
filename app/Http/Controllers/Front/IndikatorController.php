<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\TabelIndikator;
use App\Models\UraianIndikator;
use App\Repositories\IndikatorRepository;
use App\Services\IndikatorService;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class IndikatorController extends Controller
{

	public function __construct(private IndikatorRepository $repository)
	{
		View::share([
			'routePart' => 'indikator',
			'title' => 'Indikator'
		]);
	}

	public function index()
	{
		$categories = TabelIndikator::with('childs.childs.childs')->where('parent_id', 1)->get();

		return view('front.index', compact('categories'));
	}
	public function tabel(TabelIndikator $tabel)
	{
		$uraians = $tabel->uraianIndikator()->with('childs.isiIndikator')->whereNull('parent_id')->get();
		$fitur = $tabel->fiturIndikator;
		$tahuns = $this->repository->all_tahun($tabel->id);

		return view('front.tabel', compact('tabel', 'uraians', 'fitur', 'tahuns'));
	}

	public function chart(UraianIndikator $uraian)
	{
		return response()->json($this->repository->grafik($uraian->id));
	}
}
