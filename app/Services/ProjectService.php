<?php

namespace App\Services;

use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ProjectService
{
    public function __construct(
        private ProjectRepositoryInterface $projectRepo,
        private FileUploadService $fileUpload,
    ) {}

    public function getAllPublished(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->projectRepo->allPublished();
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->projectRepo->all();
    }

    public function findById(int $id): ?\App\Models\Project
    {
        return $this->projectRepo->findById($id);
    }

    public function create(array $data, ?UploadedFile $image = null): \App\Models\Project
    {
        $data['slug'] = Str::slug($data['title_en']) . '-' . Str::random(5);

        // Legacy single image
        if ($image) {
            $data['image_path'] = $this->fileUpload->uploadLocal($image, 'projects');
        }

        // Multiple images
        if (!empty($data['images']) && is_array($data['images'])) {
            $paths = [];
            foreach ($data['images'] as $img) {
                if ($img instanceof UploadedFile) {
                    $paths[] = $this->fileUpload->uploadLocal($img, 'projects');
                }
            }
            $data['image_paths'] = $paths;
        }
        unset($data['images'], $data['remove_images']);

        if (isset($data['tech_stack']) && is_string($data['tech_stack'])) {
            $data['tech_stack'] = array_filter(array_map('trim', explode(',', $data['tech_stack'])));
        }
        return $this->projectRepo->create($data);
    }

    public function update(int $id, array $data, ?UploadedFile $image = null): \App\Models\Project
    {
        $project = $this->projectRepo->findById($id);

        // Legacy single image replacement
        if ($image) {
            if ($project?->image_path) {
                $this->fileUpload->delete($project->image_path);
            }
            $data['image_path'] = $this->fileUpload->uploadLocal($image, 'projects');
        }

        // Handle new multi-images appended
        $existingPaths = $project?->image_paths ?? [];

        // Remove specific images
        if (!empty($data['remove_images'])) {
            foreach ($data['remove_images'] as $pathToRemove) {
                $this->fileUpload->delete($pathToRemove);
                $existingPaths = array_values(array_filter($existingPaths, fn($p) => $p !== $pathToRemove));
            }
        }

        // Upload new images
        if (!empty($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $img) {
                if ($img instanceof UploadedFile) {
                    $existingPaths[] = $this->fileUpload->uploadLocal($img, 'projects');
                }
            }
        }

        $data['image_paths'] = array_values($existingPaths);
        unset($data['images'], $data['remove_images']);

        if (isset($data['tech_stack']) && is_string($data['tech_stack'])) {
            $data['tech_stack'] = array_filter(array_map('trim', explode(',', $data['tech_stack'])));
        }
        return $this->projectRepo->update($id, $data);
    }

    public function delete(int $id): void
    {
        $project = $this->projectRepo->findById($id);
        if ($project?->image_path) {
            $this->fileUpload->delete($project->image_path);
        }
        $this->projectRepo->delete($id);
    }

    public function togglePublish(int $id): \App\Models\Project
    {
        return $this->projectRepo->togglePublish($id);
    }
}
