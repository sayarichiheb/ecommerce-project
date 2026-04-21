<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Électronique', 'description' => 'Téléphones, ordinateurs, tablettes...']);
        Category::create(['name' => 'Vêtements', 'description' => 'Habits, chaussures, accessoires...']);
        Category::create(['name' => 'Alimentation', 'description' => 'Nourriture, boissons, épices...']);
        Category::create(['name' => 'Maison', 'description' => 'Meubles, décoration, cuisine...']);
        Category::create(['name' => 'Sport', 'description' => 'Équipements sportifs, fitness...']);
    }
}