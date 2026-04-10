<?php

namespace App\Services;

use App\Jobs\SendContactNotificationJob;
use App\Repositories\Interfaces\ContactMessageRepositoryInterface;

class ContactService
{
    public function __construct(
        private ContactMessageRepositoryInterface $contactRepo,
    ) {}

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->contactRepo->all();
    }

    public function findById(int $id): ?\App\Models\ContactMessage
    {
        return $this->contactRepo->findById($id);
    }

    public function submitMessage(array $data): \App\Models\ContactMessage
    {
        $message = $this->contactRepo->create($data);
        SendContactNotificationJob::dispatch($message);
        return $message;
    }

    public function countUnread(): int
    {
        return $this->contactRepo->countUnread();
    }

    public function markAsRead(int $id): void
    {
        $this->contactRepo->markAsRead($id);
    }

    public function delete(int $id): void
    {
        $this->contactRepo->delete($id);
    }
}
