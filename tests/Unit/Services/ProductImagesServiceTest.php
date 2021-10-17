<?php

namespace Tests\Unit\Services;

use App\Models\Category;
use App\Models\Product;
use App\Services\ProductImagesService;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductImagesServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $category, $product, $images;

    protected function setUpVariables(): void
    {
        $this->category = Category::factory(1)->create()->first();
        $this->product = Product::factory(1, ['category_id' => $this->category->id])->create()->first();
        $this->images = [
            UploadedFile::fake()->image('test.png'),
            UploadedFile::fake()->image('test1.png')
        ];
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_attach_if_images_exists()
    {
        $this->setUpVariables();
        $this->assertEquals(0, $this->product->gallery()->count());

        ProductImagesService::attach($this->product, $this->images);

        $this->assertEquals(2, $this->product->gallery()->count());
    }

    public function test_attach_if_images_are_empty()
    {
        $this->setUpVariables();

        $this->assertEquals(0, $this->product->gallery()->count());

        ProductImagesService::attach($this->product, []);

        $this->assertEquals(0, $this->product->gallery()->count());
    }
}
