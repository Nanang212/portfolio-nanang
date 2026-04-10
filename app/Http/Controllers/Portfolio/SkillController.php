<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Services\SkillService;
use Inertia\Inertia;
use Inertia\Response;

class SkillController extends Controller
{
    public function __construct(private SkillService $skillService) {}

    public function index(): Response
    {
        return Inertia::render('Portfolio/Skills', [
            'skills'   => $this->skillService->getAll()->values(),
            'grouped'  => $this->skillService->getGrouped(),
        ]);
    }
}
