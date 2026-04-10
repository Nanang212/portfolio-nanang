<?php

namespace App\Repositories\Interfaces;

interface AboutMeRepositoryInterface
{
    public function get(): ?\App\Models\AboutMe;
    public function createOrUpdate(array $data): \App\Models\AboutMe;
}
