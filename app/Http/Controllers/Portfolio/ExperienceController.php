<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Services\ExperienceService;
use Inertia\Inertia;
use Inertia\Response;

class ExperienceController extends Controller
{
    public function __construct(private ExperienceService $experienceService) {}

    public function index(): Response
    {
        return Inertia::render('Portfolio/Experience', [
            'experiences' => $this->experienceService->getAll(),
        ]);
    }
}
