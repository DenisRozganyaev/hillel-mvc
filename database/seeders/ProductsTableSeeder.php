<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory(2)->create()->each(function ($category) {
            Product::factory(3, ['category_id' => $category->id])->create()->each(function($product) {
                ProductImage::factory(2, ['product_id' => $product->id])->create();
            });
        });
    }
}
