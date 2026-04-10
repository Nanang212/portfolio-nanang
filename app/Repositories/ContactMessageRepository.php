<?php

namespace App\Repositories;

use App\Models\ContactMessage;
use App\Repositories\Interfaces\ContactMessageRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ContactMessageRepository implements ContactMessageRepositoryInterface
{
    public function all(): Collection
    {
        return ContactMessage::latest()->get();
    }

    public function findById(int $id): ?ContactMessage
    {
        return ContactMessage::find($id);
    }

    public function create(array $data): ContactMessage
    {
        return ContactMessage::create($data);
    }

    public function countUnread(): int
    {
        return ContactMessage::unread()->count();
    }

    public function markAsRead(int $id): void
    {
        ContactMessage::findOrFail($id)->markAsRead();
    }

    public function delete(int $id): void
    {
        ContactMessage::findOrFail($id)->delete();
    }
}
