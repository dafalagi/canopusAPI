<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->sentence(mt_rand(1, 3)),
            'intro' => collect($this->faker->paragraphs(mt_rand(5, 10)))->map(fn ($p) => "<p>$p</p>")->implode(''),
            'history' => collect($this->faker->paragraphs(mt_rand(5, 10)))->map(fn ($p) => "<p>$p</p>")->implode(''),
            'excerpt' => $this->faker->paragraph(mt_rand(5, 10)),
            'slug' => $this->faker->unique()->slug(),
            'category' => collect(['Planet', 'Bintang', 'Rasi Bintang', 'Lainnya di Angkasa'])->random(),
            'trivia' => $this->faker->paragraph(mt_rand(5, 10)),
            'distance' => $this->faker->randomNumber(5, false)." ".collect(['Milyar Tahun Cahaya', 'Juta Tahun Cahaya', 'Tahun Cahaya'])->random(),
            'event' => collect(['Merkurius', 'Venus', 'Bumi', 'Mars', 'Jupiter', 'Saturnus', 'Uranus', 'Neptunus', 'Ceres', 'Eris', 'Pluto', 'Makemake', 'Haumea'])->random(),
            'coordinate' => $this->faker->randomNumber(5, false).".".$this->faker->randomNumber(5, false).":".$this->faker->randomNumber(5, false),
        ];
    }
}
