<?php

namespace App\Services;

use App\Repositories\Interfaces\SkillRepositoryInterface;

class SkillService
{
    public function __construct(
        private SkillRepositoryInterface $skillRepo,
    ) {}

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->skillRepo->all();
    }

    public function getGrouped(): array
    {
        return $this->skillRepo->groupedByCategory();
    }

    public function findById(int $id): ?\App\Models\Skill
    {
        return $this->skillRepo->findById($id);
    }

    public function create(array $data): \App\Models\Skill
    {
        return $this->skillRepo->create($data);
    }

    public function update(int $id, array $data): \App\Models\Skill
    {
        return $this->skillRepo->update($id, $data);
    }

    public function delete(int $id): void
    {
        $this->skillRepo->delete($id);
    }
}
