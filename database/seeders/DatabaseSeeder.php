<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobListing;
use App\Models\Tag;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
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
        $tags = Tag::all();
        JobListing::factory(20)->create()->each(function ($job) use ($tags) {
            $job->tags()->sync(
                $tags->random(rand(2, 4))->pluck('id')->toArray()
            );
        });
    }
}
