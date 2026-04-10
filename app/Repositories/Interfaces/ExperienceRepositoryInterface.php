<?php

namespace App\Repositories\Interfaces;

interface ExperienceRepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection;
    public function findById(int $id): ?\App\Models\Experience;
    public function create(array $data): \App\Models\Experience;
    public function update(int $id, array $data): \App\Models\Experience;
    public function delete(int $id): void;
}
