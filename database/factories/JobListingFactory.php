<?php

namespace Database\Factories;

use App\Models\JobListing;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends Factory<JobListing>
 */
class JobListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create([
                'role' => 'seeker',
            ])->id,
            'title' => $this->faker->randomElement([
                'Junior Backend Developer (Node.js)',
                'Full Stack Engineer (Laravel & React)',
                'Senior DevOps Engineer',
                'Android Developer',
                'UI/UX Designer'
            ]),
            'company_name' => $this->faker->company(),
            'location' => $this->faker->city(),
            'description' => $this->faker->paragraph(3, true),
            'requirements' => $this->faker->sentence(4, true),
            'salary_range' => $this->faker->randomElement(['$2k - $4k', '$4k - $6k', '$6k - $8k', '$100k - $120k/year']),
            'type' => $this->faker->randomElement(['Full-time', 'Part-time', 'Contract']),
            'latitude' => $this->faker->latitude(29.5, 33.3),
            'longitude' => $this->faker->longitude(34.2, 36.6),
        ];
    }
}
