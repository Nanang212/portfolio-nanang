<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Services\ContactService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function __construct(private ContactService $contactService) {}

    public function index(): Response
    {
        return Inertia::render('Portfolio/Contact');
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        $this->contactService->submitMessage($request->validated());
        return back()->with('success', 'Message sent! I will get back to you soon.');
    }
}
