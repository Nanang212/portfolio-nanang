<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function __construct(private ProjectService $projectService) {}

    public function index(): Response
    {
        return Inertia::render('Portfolio/Projects', [
            'projects' => $this->projectService->getAllPublished()->values(),
        ]);
    }
}
