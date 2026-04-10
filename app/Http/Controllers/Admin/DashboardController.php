<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContactService;
use App\Services\ExperienceService;
use App\Services\ProjectService;
use App\Services\SkillService;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(
        private ProjectService $projectService,
        private ExperienceService $experienceService,
        private SkillService $skillService,
        private ContactService $contactService,
    ) {}

    public function index(): Response
    {
        $projects = $this->projectService->getAll();
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'total_projects'   => $projects->count(),
                'published_projects' => $projects->where('is_published', true)->count(),
                'total_experiences' => $this->experienceService->getAll()->count(),
                'total_skills'      => $this->skillService->getAll()->count(),
                'unread_messages'   => $this->contactService->countUnread(),
            ],
        ]);
    }
}
