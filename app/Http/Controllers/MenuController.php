<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class MenuController extends Controller
{
public function index()
{
// Récupère toutes les catégories avec leurs produits
$categories = Category::with('products')->get();

return view('menu.index', compact('categories'));
}
}