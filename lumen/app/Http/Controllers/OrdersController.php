<?php
namespace App\Http\Controllers;

use App\Http\Controllers\CrudController;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class OrdersController extends CrudController {

    protected $orderService;

    public function __construct(OrderService $orderService) 
    {
        parent::__construct(Order::class);
        $this->orderService = $orderService;
    }

    public function index()
    {
        return Response::json($this->orderService->index());
    }

    public function storeOrder(Request $request)
    {
        return Response::json($this->orderService->storeOrder($request->all()));
    }

    public function show($id)
    {
        return Response::json($this->orderService->show($id));
    }

    public function update(Request $request, int $id)
    {
        return Response::json($this->orderService->update($request->all(), $id));
    }

    public function destroy(int $id)
    {
        return Response::json($this->orderService->destroy($id));
    }
}