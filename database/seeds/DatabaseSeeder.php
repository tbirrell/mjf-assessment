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
        Drink::create(['name' => 'Monster Ultra Sunrise', 'servings' => 2, 'caffeine_per_serving' => 75, 'image_url' => '/storage/images/monster_ultra_sunrise.png']);
        Drink::create(['name' => 'Black Coffee', 'servings' => 1, 'caffeine_per_serving' => 95, 'image_url' => '/storage/images/black_coffee.jpg']);
        Drink::create(['name' => 'Americano', 'servings' => 1, 'caffeine_per_serving' => 77, 'image_url' => '/storage/images/americano.jpg']);
        Drink::create(['name' => 'Sugar Free NOS', 'servings' => 2, 'caffeine_per_serving' => 130, 'image_url' => '/storage/images/sugar_free_nos.jpeg']);
        Drink::create(['name' => '5 Hour Energy', 'servings' => 1, 'caffeine_per_serving' => 200, 'image_url' => '/storage/images/5_hour_energy.jpeg']);
    }
}
