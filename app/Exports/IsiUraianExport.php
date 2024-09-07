<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IsiUraianExport implements FromView, ShouldAutoSize, WithStyles
{
	public function __construct(
		private $routePart,
		private $fitur,
		private $uraians,
		private $tahuns
	) {

	}

	public function view(): View
	{
		return view('export-isi-uraian', [
			'routePart' => $this->routePart,
			'fitur' => $this->fitur,
			'uraians' => $this->uraians,
			'tahuns' => $this->tahuns
		]);
	}

	public function styles(Worksheet $sheet)
	{
		return [
			// Style the first row as bold text.
			1 => ['font' => ['bold' => true]],
		];
	}
}
