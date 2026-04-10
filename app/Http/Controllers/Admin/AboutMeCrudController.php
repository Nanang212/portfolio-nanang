<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAboutMeRequest;
use App\Services\AboutMeService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AboutMeCrudController extends Controller
{
    public function __construct(private AboutMeService $aboutMeService) {}

    public function edit(): Response
    {
        return Inertia::render('Admin/About/Edit', [
            'about' => $this->aboutMeService->get(),
        ]);
    }

    public function update(UpdateAboutMeRequest $request): RedirectResponse
    {
        $this->aboutMeService->save($request->validated(), $request->file('photo'));
        return back()->with('success', 'About Me updated.');
    }
}
