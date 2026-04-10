<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Services\AboutMeService;
use App\Services\ProjectService;
use App\Services\SkillService;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __construct(
        private AboutMeService $aboutMeService,
        private ProjectService $projectService,
        private SkillService $skillService,
    ) {}

    public function index(): Response
    {
        return Inertia::render('Portfolio/Home', [
            'about'    => $this->aboutMeService->get(),
            'projects' => $this->projectService->getAllPublished()->take(3)->values(),
            'skills'   => $this->skillService->getGrouped(),
        ]);
    }
}
