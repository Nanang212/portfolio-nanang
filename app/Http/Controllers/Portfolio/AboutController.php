<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Services\AboutMeService;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function __construct(private AboutMeService $aboutMeService) {}

    public function index(): Response
    {
        return Inertia::render('Portfolio/About', [
            'about' => $this->aboutMeService->get(),
        ]);
    }
}
