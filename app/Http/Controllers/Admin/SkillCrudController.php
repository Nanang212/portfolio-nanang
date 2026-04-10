<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkillRequest;
use App\Services\SkillService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SkillCrudController extends Controller
{
    public function __construct(private SkillService $skillService) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Skills/Index', [
            'skills' => $this->skillService->getAll()->values(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Skills/Form');
    }

    public function store(StoreSkillRequest $request): RedirectResponse
    {
        $this->skillService->create($request->validated());
        return redirect()->route('admin.skills.index')->with('success', 'Skill created.');
    }

    public function edit(int $id): Response
    {
        return Inertia::render('Admin/Skills/Form', [
            'skill' => $this->skillService->findById($id),
        ]);
    }

    public function update(StoreSkillRequest $request, int $id): RedirectResponse
    {
        $this->skillService->update($id, $request->validated());
        return redirect()->route('admin.skills.index')->with('success', 'Skill updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->skillService->delete($id);
        return redirect()->route('admin.skills.index')->with('success', 'Skill deleted.');
    }
}
