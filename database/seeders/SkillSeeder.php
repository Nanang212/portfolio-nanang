<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            ['category' => 'Backend', 'name' => 'Laravel', 'level' => 'expert', 'order' => 1],
            ['category' => 'Backend', 'name' => 'Express.js', 'level' => 'expert', 'order' => 2],
            ['category' => 'Backend', 'name' => 'Node.js', 'level' => 'expert', 'order' => 3],
            ['category' => 'Backend', 'name' => 'PHP', 'level' => 'expert', 'order' => 4],
            ['category' => 'DevOps', 'name' => 'Docker', 'level' => 'advanced', 'order' => 1],
            ['category' => 'DevOps', 'name' => 'GitLab CI/CD', 'level' => 'advanced', 'order' => 2],
            ['category' => 'DevOps', 'name' => 'Nginx', 'level' => 'advanced', 'order' => 3],
            ['category' => 'Storage', 'name' => 'MinIO', 'level' => 'advanced', 'order' => 1],
            ['category' => 'Storage', 'name' => 'AWS S3', 'level' => 'intermediate', 'order' => 2],
            ['category' => 'Cache', 'name' => 'Redis', 'level' => 'advanced', 'order' => 1],
            ['category' => 'Database', 'name' => 'MySQL', 'level' => 'expert', 'order' => 1],
            ['category' => 'Database', 'name' => 'PostgreSQL', 'level' => 'advanced', 'order' => 2],
            ['category' => 'Frontend', 'name' => 'React.js', 'level' => 'advanced', 'order' => 1],
            ['category' => 'Frontend', 'name' => 'Inertia.js', 'level' => 'advanced', 'order' => 2],
            ['category' => 'Frontend', 'name' => 'TailwindCSS', 'level' => 'advanced', 'order' => 3],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(
                ['category' => $skill['category'], 'name' => $skill['name']],
                $skill
            );
        }
    }
}
