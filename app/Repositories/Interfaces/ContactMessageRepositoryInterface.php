<?php

namespace App\Repositories\Interfaces;

interface ContactMessageRepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection;
    public function findById(int $id): ?\App\Models\ContactMessage;
    public function create(array $data): \App\Models\ContactMessage;
    public function countUnread(): int;
    public function markAsRead(int $id): void;
    public function delete(int $id): void;
}
