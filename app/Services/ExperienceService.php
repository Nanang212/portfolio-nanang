<?php

namespace App\Services;

use App\Repositories\Interfaces\ExperienceRepositoryInterface;

class ExperienceService
{
    public function __construct(
        private ExperienceRepositoryInterface $experienceRepo,
    ) {}

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->experienceRepo->all();
    }

    public function findById(int $id): ?\App\Models\Experience
    {
        return $this->experienceRepo->findById($id);
    }

    public function create(array $data): \App\Models\Experience
    {
        if (isset($data['tech_stack']) && is_string($data['tech_stack'])) {
            $data['tech_stack'] = array_filter(array_map('trim', explode(',', $data['tech_stack'])));
        }
        return $this->experienceRepo->create($data);
    }

    public function update(int $id, array $data): \App\Models\Experience
    {
        if (isset($data['tech_stack']) && is_string($data['tech_stack'])) {
            $data['tech_stack'] = array_filter(array_map('trim', explode(',', $data['tech_stack'])));
        }
        return $this->experienceRepo->update($id, $data);
    }

    public function delete(int $id): void
    {
        $this->experienceRepo->delete($id);
    }
}
