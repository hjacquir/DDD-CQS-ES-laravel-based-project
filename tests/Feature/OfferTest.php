<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Infrastructure\Database\Eloquent\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class OfferTest extends TestCase
{
    public function test_query_existing_offer()
    {
        $user = User::factory()->create();

        $this->post('/login', [
          'email' => $user->email,
          'password' => 'password',
        ]);

        $offerName = str()->random(5);
        $offerSlug = str()->random(5);
        $offerDesc = str()->random(5);

        $this
          ->actingAs($user)
          ->post('/offers/', [
            'name' => $offerName,
            'slug' => $offerSlug,
            'image' => UploadedFile::fake()->image('offer.png'),
            'state' => 'published',
            'description' => $offerDesc,
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

        $response = $this->actingAs($user)->get('/offers/1');

        $content = $response->getContent();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString($offerName, $content);
        $this->assertStringContainsString($offerSlug, $content);
        $this->assertStringContainsString($offerDesc, $content);
        $this->assertStringContainsString('Publié', $content);
        $this->assertStringContainsString($productName, $content);
        $this->assertStringContainsString($productSku, $content);
        $this->assertStringContainsString('4 455,00 €', $content);
        $this->assertStringContainsString('Publié', $content);
        // @todo pour les images : faire le test avec le path et de vraies images
        $this->assertStringContainsString('storage/offers/', $content);
        $this->assertStringContainsString('storage/products/', $content);
        $this->assertStringContainsString('.png', $content);
    }
}
