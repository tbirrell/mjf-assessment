<?php

use Illuminate\Database\Seeder;
use App\Models\Drink;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Drink::create(['name' => 'Monster Ultra Sunrise', 'servings' => 2, 'caffeine_per_serving' => 75, 'image_url' => '/images/monster_ultra_sunrise']);
        Drink::create(['name' => 'Black Coffee', 'servings' => 1, 'caffeine_per_serving' => 95, 'image_url' => '/images/black_coffee']);
        Drink::create(['name' => 'Americano', 'servings' => 1, 'caffeine_per_serving' => 77, 'image_url' => '/images/americano']);
        Drink::create(['name' => 'Sugar Free NOS', 'servings' => 2, 'caffeine_per_serving' => 130, 'image_url' => '/images/sugar_free_nos']);
        Drink::create(['name' => '5 Hour Energy', 'servings' => 1, 'caffeine_per_serving' => 200, 'image_url' => '/images/5_hour_energy']);
    }
}
