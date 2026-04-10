<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function allPublished(): Collection
    {
        return Project::published()->ordered()->get();
    }

    public function all(): Collection
    {
        return Project::ordered()->get();
    }

    public function findById(int $id): ?Project
    {
        return Project::find($id);
    }

    public function findBySlug(string $slug): ?Project
    {
        return Project::where('slug', $slug)->first();
    }

    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function update(int $id, array $data): Project
    {
        $project = Project::findOrFail($id);
        $project->update($data);
        return $project->fresh();
    }

    public function delete(int $id): void
    {
        Project::findOrFail($id)->delete();
    }

    public function togglePublish(int $id): Project
    {
        $project = Project::findOrFail($id);
        $project->update(['is_published' => !$project->is_published]);
        return $project->fresh();
    }
}
