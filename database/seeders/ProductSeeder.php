<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $entree = Category::where('name', 'Entrées')->first();
        $plat = Category::where('name', 'Plats principaux')->first();
        $dessert = Category::where('name', 'Desserts')->first();
        $boisson = Category::where('name', 'Boissons')->first();

        // Entrées
        Product::create([
            'name' => 'Samoussas',
            'description' => '3 pièces, farce viande ou légumes',
            'price' => 5.50,
            'stock' => 20,
            'category_id' => $entree->id
        ]);

        Product::create([
            'name' => 'Brick à l\'œuf',
            'description' => 'Brick croustillante œuf, thon, persil',
            'price' => 4.50,
            'stock' => 15,
            'category_id' => $entree->id
        ]);

        // Plats
        Product::create([
            'name' => 'Burger Maison',
            'description' => 'Steak haché, cheddar, salade, tomate, frites',
            'price' => 12.90,
            'stock' => 10,
            'category_id' => $plat->id
        ]);

        Product::create([
            'name' => 'Poulet Tikka Massala',
            'description' => 'Poulet mariné, sauce crémeuse, riz basmati',
            'price' => 14.90,
            'stock' => 8,
            'category_id' => $plat->id
        ]);

        // Desserts
        Product::create([
            'name' => 'Fondant au chocolat',
            'description' => 'Cœur coulant, boule vanille',
            'price' => 6.50,
            'stock' => 12,
            'category_id' => $dessert->id
        ]);

        // Boissons
        Product::create([
            'name' => 'Coca-Cola',
            'description' => '33cl',
            'price' => 2.50,
            'stock' => 50,
            'category_id' => $boisson->id
        ]);
    }
}