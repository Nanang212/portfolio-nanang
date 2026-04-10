<?php

namespace App\Repositories\Interfaces;

interface SkillRepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection;
    public function groupedByCategory(): array;
    public function findById(int $id): ?\App\Models\Skill;
    public function create(array $data): \App\Models\Skill;
    public function update(int $id, array $data): \App\Models\Skill;
    public function delete(int $id): void;
}
