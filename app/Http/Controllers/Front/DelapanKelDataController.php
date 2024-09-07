<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Tabel8KelData;
use App\Models\Uraian8KelData;
use App\Repositories\DelapanKelDataRepository;
use Illuminate\Support\Facades\View;

class DelapanKelDataController extends Controller
{
	public function __construct(private DelapanKelDataRepository $repository)
	{
		View::share([
			'routePart' => 'delapankeldata',
			'title' => '8 Kelompok Data'
		]);
	}

	public function index()
	{
		$categories = Tabel8KelData::with('childs.childs.childs')->where('parent_id', 1)->get();

		return view('front.index', compact('categories'));
	}

	public function tabel(Tabel8KelData $tabel)
	{
		$uraians = $this->repository->all_uraian($tabel->id);
		$fitur = $tabel->fitur8KelData;
		$tahuns = $this->repository->all_tahun($tabel->id);

		return view('front.tabel', compact('tabel', 'uraians', 'fitur', 'tahuns'));
	}

	public function chart(Uraian8KelData $uraian)
	{
		return response()->json($this->repository->grafik($uraian->id));
	}
}
