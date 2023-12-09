<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->count(1000)->create();
        // $categories = collect([
        //     [
        //         "id" => 1,
        //         "name" => "Laptop",
        //         'slug'  => 'laptops'
        //     ],
        //     [
        //         "id" => 2,
        //         "name" => "Desktop",
        //         'slug'  => 'desktop'
        //     ],
        //     [
        //         'id'    => 3,
        //         'name'  => 'Hardware',
        //         'slug'  => 'hardware'
        //     ],
        // ]);
        // $categories->each(function ($category) {
        //     Category::insert($category);
        // });
    }
}
