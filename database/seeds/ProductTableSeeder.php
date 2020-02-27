<?php

use App\Dish;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $icons = ['flight', 'directions_walk', 'hotel', 'local_cafe', 'restaurant'];

        factory(App\Dish::class, 30)->create();

        factory(App\Category::class, 5)->create();

        factory(App\Variation::class, 3)->create();

        $categories = App\Category::all();
        $variations = App\Variation::all();

        App\Category::all()->each(
            function($category) use ($icons) {
                DB::update('update categories set iconName = ? where id = ?', [$icons[$category->id-1], $category->id]);
        });

        App\Dish::all()->each(
            function ($dish) use ($variations, $categories) {
                DB::update('update dishes set profile_picture = ? where id = ?', ["dish.png", $dish->id]);
                $dish->categories()->attach(
                    $categories->random(rand(1, 5))->pluck('id')->toArray()
                );
                $dish->variations()->attach(
                    $variations->random(rand(0, 3))->pluck('id')->toArray()
                );
        });
    }
}
