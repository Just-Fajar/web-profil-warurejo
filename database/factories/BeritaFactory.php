<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Berita>
 */
class BeritaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judul = fake()->sentence(6);
        $status = fake()->randomElement(['published', 'draft']);
        
        return [
            'admin_id' => Admin::factory(),
            'judul' => $judul,
            'slug' => Str::slug($judul) . '-' . fake()->unique()->numberBetween(1, 10000),
            'ringkasan' => fake()->paragraph(2),
            'konten' => fake()->paragraphs(5, true),
            'gambar_utama' => 'berita/test-image.jpg',
            'status' => $status,
            'views' => fake()->numberBetween(0, 1000),
            'published_at' => $status === 'published' ? fake()->dateTimeBetween('-30 days', 'now') : null,
        ];
    }

    /**
     * Indicate that the berita is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ]);
    }

    /**
     * Indicate that the berita is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    /**
     * Indicate that the berita has high views.
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'views' => fake()->numberBetween(500, 5000),
        ]);
    }
}
