<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

class UsersExport extends DefaultValueBinder implements
	FromCollection,
	WithMapping,
	WithHeadings,
	ShouldAutoSize,
	WithStyles,
	WithCustomValueBinder

{
	use Exportable;

	public function collection()
	{
		return User::with(['skpd'])->get();
	}

	public function map($user): array
	{
		return [
			$user->id,
			$user->name,
			$user->username,
			$user->email,
			$user->email_verified_at,
			$user->phone,
			$user->address,
			$user->birth_date,
			$user->skpd?->nama,
			$user->role,
			$user->created_at
		];
	}

	public function headings(): array
	{
		return [
			'ID',
			'Name',
			'Username',
			'Email',
			'Email Verified At',
			'Phone',
			'Address',
			'Birth Date',
			'SKPD',
			'Role',
			'Created At',
		];
	}

	public function bindValue(Cell $cell, $value)
	{
		if (is_numeric($value)) {
			$cell->setValueExplicit($value, DataType::TYPE_STRING); // Fix phone number

			return true;
		}

		// else return default behavior
		return parent::bindValue($cell, $value);
	}

	public function styles(Worksheet $sheet): array
	{
		return [
			// Style the first row as bold text.
			1 => ['font' => ['bold' => true]],
		];
	}
}
