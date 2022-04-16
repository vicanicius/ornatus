<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $order;
    protected $product;
    protected $orderProdcut;
    
    public function __construct(Order $order, Product $product, OrderProduct $orderProdcut) 
    {
        $this->order = $order;
        $this->product = $product;
        $this->orderProdcut = $orderProdcut;
    }

    public function index()
    {
        return $this->order->with('products')->get();
    }

    public function show($id)
    {
        $order = $this->order->find($id);
        if(!$order) {
            throw new Exception('Pedido não encontrado');
        }
        return $order->load('products');
    }

    public function storeOrder($request)
    {
        DB::beginTransaction();
        $order = $this->order::create();
        foreach ($request['items'] as $item) {
            if (!$product = $this->getProduct($item['product_id'])) {
                DB::rollBack();
                throw new Exception('Produto não encontrado');
            }
            
            $this->orderProdcut::create([
                'product_id' => $item['product_id'],
                'order_id' => $order->getKey(),
                'quantity' => $item['quantity'],
                'amount' => $product->price * $item['quantity']
            ]);
        }

        $this->updateAmountOrder($order->getKey());

        DB::commit();
        return $order;
    }

    public function destroy($id)
    {
        $order = $this->order->find($id);
        
        $orderProdcut = $this->orderProdcut->where('order_id', $id);
        $orderProdcut->delete();
        
        return $order->delete();
    }

    public function update($request, $id)
    {
        $orderProduct = OrderProduct::find($id);
        $orderProduct->update([
            'quantity' => $request['quantity'],
            'amount' => $request['quantity'] * $this->getProduct($orderProduct->product_id)->price
        ]);

        $order = $this->updateAmountOrder($orderProduct->order_id);
        return $order->load('products');
    }

    private function getProduct($id)
    {
        return $this->product::find($id);
    }

    private function updateAmountOrder($orderId)
    {
        $order = Order::find($orderId);   
        $orderProduct = OrderProduct::where('order_id', $orderId)->get();
        
        $order->update([
            'amount' => $orderProduct->sum('amount')
        ]);

        return $order;
    }
}
