<?php

namespace App\Repositories;
use App\Models\Visitor;
use Illuminate\Support\Carbon;

class VisitorRepository
{
	public function all_count(): int
	{
		return Visitor::count();
	}

	public function day_count(): int
	{
		return Visitor::whereDay('created_at', Carbon::today())->count();
	}

	public function week_count(): int
	{
		return Visitor::whereBetween('created_at', [
			Carbon::now()->startOfWeek(),
			Carbon::now()->endOfWeek()
		])->count();
	}

	public function month_count(): int
	{
		return Visitor::whereMonth('created_at', Carbon::now()->month)->count();
	}

	public function year_count(): int
	{
		return Visitor::whereYear('created_at', Carbon::now()->year)->count();
	}
}
