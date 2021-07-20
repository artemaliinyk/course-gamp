<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\GoogleAnalyticRepository;

class GoogleAnalyticController extends Controller
{
    public $googleAnalyticRepository;

    public function __construct(GoogleAnalyticRepository $googleAnalyticRepository)
    {
        $this->googleAnalyticRepository = $googleAnalyticRepository;
    }

    public function index(Request $request)
    {
        $this->googleAnalyticRepository->sendEvent($request);

        return view('welcome');
    }
}
