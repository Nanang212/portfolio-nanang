<?php

namespace App\Repositories\Interfaces;

interface ProjectRepositoryInterface
{
    public function allPublished(): \Illuminate\Database\Eloquent\Collection;
    public function all(): \Illuminate\Database\Eloquent\Collection;
    public function findById(int $id): ?\App\Models\Project;
    public function findBySlug(string $slug): ?\App\Models\Project;
    public function create(array $data): \App\Models\Project;
    public function update(int $id, array $data): \App\Models\Project;
    public function delete(int $id): void;
    public function togglePublish(int $id): \App\Models\Project;
}
