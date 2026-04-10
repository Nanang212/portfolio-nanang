<?php

namespace App\Repositories;

use App\Models\Experience;
use App\Repositories\Interfaces\ExperienceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ExperienceRepository implements ExperienceRepositoryInterface
{
    public function all(): Collection
    {
        return Experience::ordered()->get();
    }

    public function findById(int $id): ?Experience
    {
        return Experience::find($id);
    }

    public function create(array $data): Experience
    {
        return Experience::create($data);
    }

    public function update(int $id, array $data): Experience
    {
        $exp = Experience::findOrFail($id);
        $exp->update($data);
        return $exp->fresh();
    }

    public function delete(int $id): void
    {
        Experience::findOrFail($id)->delete();
    }
}
