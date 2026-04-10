<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::truncate();

        $projects = [
            [
                'title_en'       => 'Digitalisasi Document',
                'title_id'       => 'Digitalisasi Dokumen',
                'description_en' => 'A project to move manual submission documents into digital format. This project works together with tax integration to obtain e-stamps, and includes a UI for Adira\'s digital signature so document processes are auto-generated and ready to print.',
                'description_id' => 'Proyek untuk memindahkan dokumen pengajuan manual ke format digital. Proyek ini berintegrasi dengan perpajakan untuk memperoleh e-meterai, serta membuat UI tanda tangan digital Adira agar proses dokumen dapat digenerate otomatis dan siap cetak.',
                'tech_stack'     => ['ZK', 'Java 7', 'Java 17', 'SQL', 'Postman', 'Unit Test', 'Kafka', 'Docker'],
                'github_url'     => null,
                'is_published'   => true,
                'order'          => 1,
                'period'         => 'Dec 2024 – Feb 2025',
            ],
            [
                'title_en'       => 'PreiBalap',
                'title_id'       => 'PreiBalap',
                'description_en' => 'A registration website for car racing competitions throughout East Java. A freelance project built by a team of 2, featuring full event registration flow and participant management.',
                'description_id' => 'Website registrasi kompetisi balap mobil se-Jawa Timur. Proyek freelance yang dikerjakan oleh 2 orang, mencakup alur pendaftaran event lengkap dan manajemen peserta.',
                'tech_stack'     => ['Laravel', 'React JS', 'TypeScript', 'TailwindCSS', 'Postman', 'Git'],
                'github_url'     => null,
                'is_published'   => true,
                'order'          => 2,
                'period'         => 'Sep 2024 – Dec 2024',
            ],
            [
                'title_en'       => 'Autofill Document',
                'title_id'       => 'Autofill Dokumen',
                'description_en' => 'Automates document prefilling in the loan application process. When a customer applies for a different loan but shares document requirements with a previous application, eligible documents are automatically filled in.',
                'description_id' => 'Mengotomatiskan pengisian dokumen dalam proses pengajuan pinjaman. Jika nasabah mengajukan pinjaman berbeda namun memiliki persyaratan dokumen yang sama dengan pengajuan sebelumnya, dokumen yang memenuhi syarat akan terisi otomatis.',
                'tech_stack'     => ['ZK', 'Java 7', '.Net', 'SQL', 'Postman'],
                'github_url'     => null,
                'is_published'   => true,
                'order'          => 3,
                'period'         => 'Aug 2024 – Sep 2024',
            ],
            [
                'title_en'       => 'Pengkinian Data',
                'title_id'       => 'Pengkinian Data',
                'description_en' => 'Reduces Dukcapil API hit frequency by requiring validated fields to change before triggering updates. Also improves the Pop-Up display for failed data updates to show detailed discrepancies with Dukcapil, helping field teams identify failure causes clearly.',
                'description_id' => 'Mengurangi frekuensi hit API Dukcapil dengan mewajibkan perubahan pada field yang divalidasi. Meningkatkan tampilan Pop-Up gagal pembaruan data untuk menampilkan detail ketidaksesuaian dengan Dukcapil, membantu tim lapangan memahami penyebab kegagalan.',
                'tech_stack'     => ['ZK', 'Java 7', '.Net', 'SQL', 'Postman'],
                'github_url'     => null,
                'is_published'   => true,
                'order'          => 4,
                'period'         => 'Jul 2024 – Aug 2024',
            ],
            [
                'title_en'       => 'Connect by BCA',
                'title_id'       => 'Connect by BCA',
                'description_en' => 'An m-banking service application available on Android and web, built as the final project of the Synergy Academy × BCA bootcamp. Responsible for the full UI using React and consuming APIs from the backend team.',
                'description_id' => 'Aplikasi layanan m-banking tersedia di Android dan web, sebagai proyek akhir bootcamp Synergy Academy × BCA. Bertanggung jawab atas seluruh tampilan UI menggunakan React dan konsumsi API dari tim backend.',
                'tech_stack'     => ['React JS', 'TailwindCSS', 'JavaScript', 'Postman'],
                'github_url'     => null,
                'is_published'   => true,
                'order'          => 5,
                'period'         => 'Feb 2024 – Aug 2024',
            ],
            [
                'title_en'       => 'Training Management',
                'title_id'       => 'Training Management',
                'description_en' => 'Final assignment for the Metrodata Coding Camp. A training management website featuring datatables, document preview, attachment uploads, REST API creation, and API consumption.',
                'description_id' => 'Tugas akhir Metrodata Coding Camp. Website manajemen pelatihan dengan fitur datatables, preview dokumen, upload lampiran, pembuatan REST API, dan konsumsi API.',
                'tech_stack'     => ['Spring Boot', 'TailwindCSS', 'JavaScript', 'SQL', 'Postman'],
                'github_url'     => null,
                'is_published'   => true,
                'order'          => 6,
                'period'         => 'Nov 2023',
            ],
            [
                'title_en'       => 'Pokémon Explorer',
                'title_id'       => 'Pokémon Explorer',
                'description_en' => 'An assignment to consume the PokéAPI dummy data during the Metrodata Coding Camp, displaying Pokémon data in an interactive interface.',
                'description_id' => 'Tugas konsumsi PokéAPI selama Metrodata Coding Camp, menampilkan data Pokémon dalam antarmuka interaktif.',
                'tech_stack'     => ['HTML', 'CSS', 'TailwindCSS', 'JavaScript'],
                'github_url'     => null,
                'is_published'   => true,
                'order'          => 7,
                'period'         => 'Oct 2023',
            ],
            [
                'title_en'       => 'Supermarket POS',
                'title_id'       => 'Supermarket POS',
                'description_en' => 'A freelance project to build a supermarket management website featuring ag-Grid for dynamic tables, export to PDF, print receipts, and full REST API implementation.',
                'description_id' => 'Proyek freelance membuat website manajemen supermarket dengan ag-Grid untuk tabel dinamis, ekspor PDF, cetak struk, dan implementasi REST API penuh.',
                'tech_stack'     => ['Laravel', 'Bootstrap', 'JavaScript', 'SQL', 'Postman', 'Ag-Grid'],
                'github_url'     => null,
                'is_published'   => true,
                'order'          => 8,
                'period'         => 'May 2023 – Jul 2023',
            ],
            [
                'title_en'       => 'Care for Orphans',
                'title_id'       => 'Care for Orphans',
                'description_en' => 'Final college assignment: a donation website to support PENS orphans, featuring datatables, PDF export, REST API creation, and API consumption.',
                'description_id' => 'Tugas akhir kuliah: website donasi untuk anak yatim PENS, dilengkapi datatables, ekspor PDF, pembuatan REST API, dan konsumsi API.',
                'tech_stack'     => ['Laravel', 'Bootstrap', 'JavaScript', 'SQL', 'Postman', 'Query Builder'],
                'github_url'     => null,
                'is_published'   => true,
                'order'          => 9,
                'period'         => 'Jan 2023 – Jun 2023',
            ],
            [
                'title_en'       => 'KONSEL',
                'title_id'       => 'KONSEL',
                'description_en' => 'Built during internship: KONSEL (Online Counseling) is a website for middle and high school students throughout Yogyakarta. Features multi-role access, datatables, PDF export, and a full REST API.',
                'description_id' => 'Dibuat saat magang: KONSEL (Konseling Online) adalah website untuk siswa SMP dan SMA se-Yogyakarta. Fitur multi-role, datatables, ekspor PDF, dan REST API lengkap.',
                'tech_stack'     => ['Laravel', 'Bootstrap', 'JavaScript', 'SQL', 'Postman'],
                'github_url'     => null,
                'is_published'   => true,
                'order'          => 10,
                'period'         => 'Aug 2022 – Dec 2022',
            ],
            [
                'title_en'       => 'SIABDI',
                'title_id'       => 'SIABDI',
                'description_en' => 'SIABDI (Sistem Abdi) is a community service management website for the campus, featuring datatables, PDF import, and filtering by lecturer name and service title.',
                'description_id' => 'SIABDI (Sistem Abdi) adalah website manajemen pengabdian masyarakat kampus, dengan fitur datatables, import PDF, dan filter berdasarkan nama dan judul pengabdian dosen.',
                'tech_stack'     => ['Laravel', 'Bootstrap', 'JavaScript', 'SQL', 'Postman'],
                'github_url'     => null,
                'is_published'   => true,
                'order'          => 11,
                'period'         => 'Nov 2021 – May 2022',
            ],
        ];

        foreach ($projects as $project) {
            $period = $project['period'] ?? '';
            unset($project['period']);
            $slug = Str::slug($project['title_en']) . '-' . Str::random(5);
            // Add period to description if needed
            Project::create(array_merge($project, ['slug' => $slug]));
        }
    }
}
