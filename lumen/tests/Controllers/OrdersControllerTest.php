<?php

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Services\OrderService;
use Laravel\Lumen\Testing\DatabaseTransactions;

class OrdersControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $service;
    protected $products;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(OrderService::class);

        $i = 0;
        while ($i <= 1) {
            $this->products[] = factory(Product::class)->create();
            $i++;
        }
    }

    public function testCreateProductNotFound(): void
    {
        $this->expectExceptionMessage("Produto não encontrado");
        $data = [
            "items" => [
                "product_id" => 1,
                "quantity" => 10
            ]
        ];
        $this->service->storeOrder($data);        
    }

    public function testCreate(): void
    {        
        $order = $this->storeOrder();
        $this->seeInDatabase('orders_products', ['product_id' => $this->products[0]->id]);
        $this->seeInDatabase('orders_products', ['product_id' => $this->products[1]->id]);
        $this->seeInDatabase('orders', ['id' => $order->id]);
    }

    public function testList(): void
    {
        $this->storeOrder();
        $this->get('/orders')
        ->seeJsonStructure([
            '*' => [
                "id",
                "amount",
                "created_at",
                "updated_at",
                "deleted_at",
                "products" => [
                    '*' => [
                        "id",
                        "product_id",
                        "order_id",
                        "quantity",
                        "amount",
                        "created_at",
                        "updated_at",
                        "deleted_at"
                    ]
                ]
            ]
        ]);
        $this->seeStatusCode(200);
    }

    private function storeOrder()
    {
        $data = [
            "items" => [
            [
                "product_id" => $this->products[0]->id,
                "quantity" => 10
            ], [
                "product_id" => $this->products[1]->id,
                "quantity" => 20
            ]]
        ];
        return $this->service->storeOrder($data);
    }

    public function testShow(): void
    {
        $order = $this->storeOrder();
        $this->get("/orders/{$order->id}")
        ->seeJsonStructure([
            '*' => 
                "id",
                "amount",
                "created_at",
                "updated_at",
                "deleted_at",
                "products" => [
                    '*' => [
                        "id",
                        "product_id",
                        "order_id",
                        "quantity",
                        "amount",
                        "created_at",
                        "updated_at",
                        "deleted_at"
                    ]
                ]
        ]);
        $this->seeStatusCode(200);
    }

    public function testDelete(): void
    {
        $order = $this->storeOrder();
        $this->delete("/orders/{$order->id}");
        $this->seeStatusCode(200);

        $this->assertNull(Order::find($order->id));
        $this->assertEmpty(OrderProduct::where('order_id', $order->id)->get());
    }

    public function testUpdate(): void 
    {
        $order = $this->storeOrder();
        $orderProduct = OrderProduct::where('order_id', $order->id)->get();
        
        $newData = ["quantity" => 5];
        $this->put("orders/order-product/{$orderProduct[0]->id}", $newData);// update($newData, $orderProduct[0]->id);
        $this->seeStatusCode(200);
        $orderAfter = Order::find($order->id);
        
        $this->assertNotEquals($orderProduct[0]->amount, $orderAfter->amount);
    }
}