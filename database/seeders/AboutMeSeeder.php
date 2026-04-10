<?php

namespace Database\Seeders;

use App\Models\AboutMe;
use Illuminate\Database\Seeder;

class AboutMeSeeder extends Seeder
{
    public function run(): void
    {
        AboutMe::updateOrCreate(
            ['id' => 1],
            [
                'bio_en'       => "I'm a Fullstack Developer specializing in building robust, scalable enterprise applications. With deep expertise in Laravel and Node.js (Express), I design systems that are clean, maintainable, and production-ready. I have hands-on experience building construction monitoring systems, project document management platforms, and centralized data APIs serving multiple internal applications.",
                'bio_id'       => "Saya adalah Fullstack Developer yang spesialisasi dalam membangun aplikasi enterprise yang robust dan skalabel. Dengan keahlian mendalam di Laravel dan Node.js (Express), saya merancang sistem yang bersih, mudah dipelihara, dan siap produksi. Saya memiliki pengalaman langsung membangun sistem monitoring konstruksi, platform manajemen dokumen proyek, dan API data terpusat yang melayani berbagai aplikasi internal.",
                'job_title_en' => 'Software Engineer',
                'job_title_id' => 'Software Engineer Fullstack',
                'highlights'   => ['3+ Years Experience', 'Enterprise Systems', 'Backend Specialist', 'Docker & DevOps'],
            ]
        );
    }
}
