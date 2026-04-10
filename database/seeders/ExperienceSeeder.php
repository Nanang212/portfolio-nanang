<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        Experience::truncate();

        $experiences = [
            // 1. PT Jasa Marga – Back End Developer (Mar 2025 - Apr 2025)
            [
                'company'      => 'PT Jasa Marga (Persero) Tbk',
                'role'         => 'Back End Developer',
                'period_start' => '2025-03-01',
                'period_end'   => '2025-04-30',
                'is_current'   => false,
                'order'        => 1,
                'tech_stack'   => ['Laravel', 'PHP', 'PostgreSQL', 'Jenkins', 'GitLab', 'Postman', 'Jira'],
                'projects'     => [
                    [
                        'name'           => 'JIMMS (Jasa Marga Integrated Maintenance Management System)',
                        'description_en' => 'Developed a website for environmental maintenance on Jasa Marga toll roads using PHP Laravel and PostgreSQL. Fixed dashboard environmental features, added roles & permissions for GH approval, and edited enum evaluations.',
                        'description_id' => 'Mengembangkan website untuk pemeliharaan lingkungan jalan tol Jasa Marga menggunakan PHP Laravel dan PostgreSQL. Memperbaiki fitur lingkungan pada dashboard, menambahkan roles & permissions untuk approval GH, dan mengedit enum evaluasi.',
                    ],
                ],
            ],

            // 2. PT Adira Dinamika Multi Finance – Programmer (Mar 2024 - Feb 2025)
            [
                'company'      => 'PT Adira Dinamika Multi Finance',
                'role'         => 'Programmer',
                'period_start' => '2024-03-01',
                'period_end'   => '2025-02-28',
                'is_current'   => false,
                'order'        => 2,
                'tech_stack'   => ['Java', 'Spring Boot', 'Apache POI', 'SQL', 'ZK Framework', '.Net', 'Docker', 'Kafka'],
                'projects'     => [
                    [
                        'name'           => 'Core Application Maintenance (Action)',
                        'description_en' => 'Maintained and improved the "Action" core application used for branch customer loan applications. Analyzed and resolved ticket issues from branches by validating data using SQL queries.',
                        'description_id' => 'Memelihara dan meningkatkan aplikasi inti "Action" yang digunakan untuk pengajuan pinjaman nasabah cabang. Menganalisis dan menyelesaikan isu tiket dari cabang dengan validasi data menggunakan query SQL.',
                    ],
                    [
                        'name'           => 'Document Digitization System',
                        'description_en' => 'Developed a document digitization system using Spring Boot and Apache POI to automate manual digital document creation. Built UI for digital signatures and integrated Kafka consumers.',
                        'description_id' => 'Mengembangkan sistem digitalisasi dokumen menggunakan Spring Boot dan Apache POI untuk mengotomatiskan pembuatan dokumen digital secara manual. Membangun UI untuk tanda tangan digital dan mengintegrasikan Kafka consumers.',
                    ],
                    [
                        'name'           => 'Autofill & Pengkinian Data',
                        'description_en' => 'Automated document filling and customer data updates integrated with Dukcapil data system.',
                        'description_id' => 'Otomatisasi pengisian dokumen dan pembaruan data nasabah yang terintegrasi dengan sistem data Dukcapil.',
                    ],
                ],
            ],

            // 3. PT Mitra Integrasi Informatika – Programmer/Trainee (Sep 2023 - Feb 2024)
            [
                'company'      => 'PT Mitra Integrasi Informatika',
                'role'         => 'Programmer / Trainee',
                'period_start' => '2023-09-01',
                'period_end'   => '2024-02-29',
                'is_current'   => false,
                'order'        => 3,
                'tech_stack'   => ['Java', 'Spring Boot', 'TailwindCSS', 'JavaScript', 'SQL', 'Postman', 'DataTables', 'Draw.io'],
                'projects'     => [
                    [
                        'name'           => 'Training Management Application',
                        'description_en' => 'Built training management applications for internal and external company needs using Spring Boot during the application management training program.',
                        'description_id' => 'Membangun aplikasi manajemen pelatihan untuk kebutuhan internal dan eksternal perusahaan menggunakan Spring Boot selama program pelatihan manajemen aplikasi.',
                    ],
                ],
            ],

            // 4. Lavin Technologies – Full Stack Developer (May 2023 - Jul 2023)
            [
                'company'      => 'Lavin Technologies',
                'role'         => 'Full Stack Developer',
                'period_start' => '2023-05-01',
                'period_end'   => '2023-07-31',
                'is_current'   => false,
                'order'        => 4,
                'tech_stack'   => ['Laravel', 'JavaScript', 'Bootstrap', 'Ag-Grid', 'MySQL', 'Laragon'],
                'projects'     => [
                    [
                        'name'           => 'Supermarket Cashier Application',
                        'description_en' => 'Developed a web-based supermarket cashier application using Laravel with full transaction management, sales recording, product management, and financial reports. Used Ag-Grid for dynamic data tables.',
                        'description_id' => 'Mengembangkan aplikasi kasir supermarket berbasis web menggunakan Laravel dengan manajemen transaksi lengkap, pencatatan penjualan, manajemen produk, dan laporan keuangan. Menggunakan Ag-Grid untuk tabel data dinamis.',
                    ],
                ],
            ],

            // 5. PT Unicam Digital Studio Pictvres – Full Stack Developer Intern (Aug 2022 - Dec 2022)
            [
                'company'      => 'PT Unicam Digital Studio Pictvres',
                'role'         => 'Full Stack Developer (Internship)',
                'period_start' => '2022-08-01',
                'period_end'   => '2022-12-31',
                'is_current'   => false,
                'order'        => 5,
                'tech_stack'   => ['Laravel', 'JavaScript', 'Bootstrap', 'DataTables', 'MySQL', 'Laragon'],
                'projects'     => [
                    [
                        'name'           => 'Student Counseling Website',
                        'description_en' => 'Developed a counseling website for middle and high school students in Yogyakarta using Laravel, providing online guidance and session management features.',
                        'description_id' => 'Mengembangkan website konseling untuk siswa SMP dan SMA di Yogyakarta menggunakan Laravel, menyediakan fitur bimbingan online dan manajemen sesi.',
                    ],
                ],
            ],
        ];

        foreach ($experiences as $exp) {
            Experience::create($exp);
        }
    }
}
