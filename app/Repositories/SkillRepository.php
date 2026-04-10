<?php

namespace App\Repositories;

use App\Models\Skill;
use App\Repositories\Interfaces\SkillRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SkillRepository implements SkillRepositoryInterface
{
    public function all(): Collection
    {
        return Skill::ordered()->get();
    }

    public function groupedByCategory(): array
    {
        return $this->all()->groupBy('category')->map(fn($items) => $items->values())->toArray();
    }

    public function findById(int $id): ?Skill
    {
        return Skill::find($id);
    }

    public function create(array $data): Skill
    {
        return Skill::create($data);
    }

    public function update(int $id, array $data): Skill
    {
        $skill = Skill::findOrFail($id);
        $skill->update($data);
        return $skill->fresh();
    }

    public function delete(int $id): void
    {
        Skill::findOrFail($id)->delete();
    }
}
