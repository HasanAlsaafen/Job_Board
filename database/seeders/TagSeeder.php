<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'Laravel', 'slug' => 'laravel', 'color' => '#ffffff', 'bg' => '#FF2D20'],
            ['name' => 'React', 'slug' => 'react', 'color' => '#ffffff', 'bg' => '#61DAFB'],
            ['name' => 'Vue.js', 'slug' => 'vuejs', 'color' => '#ffffff', 'bg' => '#42B883'],
            ['name' => 'Remote', 'slug' => 'remote', 'color' => '#ffffff', 'bg' => '#6366F1'],
            ['name' => 'Full-time', 'slug' => 'full-time', 'color' => '#ffffff', 'bg' => '#10B981'],
            ['name' => 'Node.js', 'slug' => 'nodejs', 'color' => '#ffffff', 'bg' => '#339933'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['slug' => $tag['slug']], $tag);
        }
    }
}
