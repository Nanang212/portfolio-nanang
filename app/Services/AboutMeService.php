<?php

namespace App\Services;

use App\Repositories\Interfaces\AboutMeRepositoryInterface;
use Illuminate\Http\UploadedFile;

class AboutMeService
{
    public function __construct(
        private AboutMeRepositoryInterface $aboutMeRepo,
        private FileUploadService $fileUpload,
    ) {}

    public function get(): ?\App\Models\AboutMe
    {
        return $this->aboutMeRepo->get();
    }

    public function save(array $data, ?UploadedFile $photo = null): \App\Models\AboutMe
    {
        if (isset($data['highlights']) && is_string($data['highlights'])) {
            $data['highlights'] = array_filter(array_map('trim', explode("\n", $data['highlights'])));
        }
        if ($photo) {
            $existing = $this->aboutMeRepo->get();
            if ($existing?->photo_path) {
                $this->fileUpload->delete($existing->photo_path);
            }
            $data['photo_path'] = $this->fileUpload->uploadLocal($photo, 'about');
        }
        return $this->aboutMeRepo->createOrUpdate($data);
    }
}
