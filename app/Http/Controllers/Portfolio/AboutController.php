<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Services\AboutMeService;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function __construct(private AboutMeService $aboutMeService) {}

    public function index(): Response
    {
        return Inertia::render('Portfolio/About', [
            'about' => $this->aboutMeService->get(),
        ]);
    }

    public function downloadCv()
    {
        $about = $this->aboutMeService->get();
        if (!$about || !$about->resume_path) {
            return back()->with('error', 'CV not found.');
        }

        $path = storage_path('app/public/' . $about->resume_path);
        if (!file_exists($path)) {
            return back()->with('error', 'CV file missing.');
        }

        return response()->download($path, 'CV.pdf');
    }
}
