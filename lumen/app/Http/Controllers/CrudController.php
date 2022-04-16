<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\CrudService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CrudController extends Controller
{
    protected $crud;
    protected $model;

    public function __construct($model)
    {
        $this->crud = new CrudService($model);
        $this->model = $model;
    }

    public function index()
    {
        return Response::json($this->crud->index());
    }

    public function store(Request $request)
    {
        return Response::json($this->crud->store($request->all()));
    }

    public function show(int $id)
    {
        return Response::json($this->crud->show($id));
    }
    
    public function update(Request $request, int $id)
    {
        return Response::json($this->crud->update($request->all(), $id));
    }

    public function destroy(int $id)
    {
        return Response::json($this->crud->destroy($id));
    }
}
