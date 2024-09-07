<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Repositories\VisitorRepository;

class HomeController extends Controller
{
	public function __invoke(VisitorRepository $visitor)
	{
		return view('front.home', compact('visitor'));
	}
}
