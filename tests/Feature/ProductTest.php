<?php

declare(strict_types=1);

use App\Infrastructure\Database\Eloquent\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_query_existing_product()
    {
        $user = User::factory()->create();

        $this->post('/login', [
          'email' => $user->email,
          'password' => 'password',
        ]);

        $this
          ->actingAs($user)
          ->post('/offers/', [
            'name' => str()->random(5),
            'slug' => str()->random(5),
            'image' => UploadedFile::fake()->image('offer.png'),
            'state' => 'draft',
            'description' => str()->random(5),
          ]);

        $productName = str()->random(5);
        $productSku = str()->random(5);

        $this
          ->actingAs($user)
          ->post('/offers/1/products/', [
            'name' => $productName,
            'sku' => $productSku,
            'image' => UploadedFile::fake()->image('product.png'),
            'price' => 4455,
            'state' => 'published',
          ]);

        $response = $this->actingAs($user)->get('/offers/1/products/');

        $content = $response->getContent();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString($productName, $content);
        $this->assertStringContainsString($productSku, $content);
        $this->assertStringContainsString('4 455,00 €', $content);
        $this->assertStringContainsString('Publié', $content);
        // pour les images
        $this->assertStringContainsString('storage/products/', $content);
        $this->assertStringContainsString('.png', $content);
    }
}
