<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContactService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactMessageController extends Controller
{
    public function __construct(private ContactService $contactService) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Messages/Index', [
            'messages' => $this->contactService->getAll()->values(),
        ]);
    }

    public function show(int $id): Response
    {
        $message = $this->contactService->findById($id);
        $this->contactService->markAsRead($id);
        return Inertia::render('Admin/Messages/Show', [
            'message' => $message->fresh(),
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->contactService->delete($id);
        return redirect()->route('admin.messages.index')->with('success', 'Message deleted.');
    }
}
