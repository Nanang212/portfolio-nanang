<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExperienceRequest;
use App\Services\ExperienceService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ExperienceCrudController extends Controller
{
    public function __construct(private ExperienceService $experienceService) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Experiences/Index', [
            'experiences' => $this->experienceService->getAll()->values(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Experiences/Form');
    }

    public function store(StoreExperienceRequest $request): RedirectResponse
    {
        $this->experienceService->create($request->validated());
        return redirect()->route('admin.experiences.index')->with('success', 'Experience created.');
    }

    public function edit(int $id): Response
    {
        return Inertia::render('Admin/Experiences/Form', [
            'experience' => $this->experienceService->findById($id),
        ]);
    }

    public function update(StoreExperienceRequest $request, int $id): RedirectResponse
    {
        $this->experienceService->update($id, $request->validated());
        return redirect()->route('admin.experiences.index')->with('success', 'Experience updated.');
    }

    public function reorder(\Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
    {
        $order = $request->input('order', []);
        foreach ($order as $index => $id) {
            \App\Models\Experience::where('id', $id)->update(['order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->experienceService->delete($id);
        return redirect()->route('admin.experiences.index')->with('success', 'Experience deleted.');
    }
}
