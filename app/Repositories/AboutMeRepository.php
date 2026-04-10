<?php

namespace App\Repositories;

use App\Models\AboutMe;
use App\Repositories\Interfaces\AboutMeRepositoryInterface;

class AboutMeRepository implements AboutMeRepositoryInterface
{
    public function get(): ?AboutMe
    {
        return AboutMe::first();
    }

    public function createOrUpdate(array $data): AboutMe
    {
        $about = AboutMe::first();
        if ($about) {
            $about->update($data);
            return $about->fresh();
        }
        return AboutMe::create($data);
    }
}
