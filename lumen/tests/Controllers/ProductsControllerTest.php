<?php

use App\Models\Product;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ProductsControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->product = factory(Product::class)->create();
    }

    public function testCreate(): void
    {
        $product = factory(Product::class)->raw();
        $response = $this->json('POST', '/products', $product);
        $response->assertResponseStatus(200);

        $this->seeInDatabase('products', ['name' => $product['name']]);
    }

    public function testList(): void
    {
        $this->get('/products');
        $this->seeStatusCode(200);
    }

    public function testShow(): void
    {
        $this->get("/products/{$this->product['id']}");
        $this->seeStatusCode(200);
    }

    public function testDelete(): void
    {
        $this->delete("/products/{$this->product['id']}");
        $this->seeStatusCode(200);

        $this->assertNull(Product::find($this->product['id']));
    }

    public function testUpdate(): void 
    {
        $newData = ["price" => 10];
        $this->put("/products/{$this->product['id']}", $newData);
        $this->seeStatusCode(200);

        $this->assertEquals(Product::find($this->product['id'])->price, $newData["price"]);
    }
}