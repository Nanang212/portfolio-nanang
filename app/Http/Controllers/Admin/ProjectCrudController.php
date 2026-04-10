<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Services\ProjectService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProjectCrudController extends Controller
{
    public function __construct(private ProjectService $projectService) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Projects/Index', [
            'projects' => $this->projectService->getAll()->values(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Projects/Form');
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $this->projectService->create($request->validated(), $request->file('image'));
        return redirect()->route('admin.projects.index')->with('success', 'Project created.');
    }

    public function edit(int $id): Response
    {
        return Inertia::render('Admin/Projects/Form', [
            'project' => $this->projectService->findById($id),
        ]);
    }

    public function update(StoreProjectRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();
        // Handle explicit image removal
        if ($request->boolean('remove_image')) {
            $project = $this->projectService->findById($id);
            if ($project?->image_path) {
                app(\App\Services\FileUploadService::class)->delete($project->image_path);
            }
            $data['image_path'] = null;
        }
        $this->projectService->update($id, $data, $request->file('image'));
        return redirect()->route('admin.projects.index')->with('success', 'Project updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->projectService->delete($id);
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted.');
    }

    public function reorder(\Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
    {
        $order = $request->input('order', []);
        foreach ($order as $index => $id) {
            \App\Models\Project::where('id', $id)->update(['order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    public function togglePublish(int $id): RedirectResponse
    {
        $this->projectService->togglePublish($id);
        return back()->with('success', 'Publish status updated.');
    }
}
