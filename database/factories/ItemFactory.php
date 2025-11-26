<?php

namespace Database\Factories;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Bikin kode barang random
            'item_code' => 'ITEM-' . fake()->unique()->numberBetween(1000, 9999),
            // Bikin nama barang random dengan 3 kata
            'item_name' => ucfirst(fake()->words(3, true)),
            // Bikin deskripsi barang random dengan 10 kata
            'id_category' => Category::inRandomOrder()->first()->id_category ?? Category::factory(),
            // Deskripsi Barang
            'description' => fake()->sentence(),
            // Stok barang
            'stock' => fake()->numberBetween(1, 100),
            // Harga barang
            'price' => fake()->numberBetween(10, 1000) * 1000,
        ];
    }
}
