<?php

namespace App\Services;

use Illuminate\Http\Response;

class CrudService
{
    protected $model;

    public function __construct($model)
    {
        $this->model = new $model();
    }

    public function index()
    {
        return $this->respond(Response::HTTP_OK, $this->model->all());
    }

    public function show($id)
    {
        $model = $this->model->find($id);
        if(is_null($model)) {
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        return $this->respond(Response::HTTP_OK, $model);
    }

    public function store($request)
    {
        return $this->respond(Response::HTTP_CREATED, $this->model->firstOrcreate($request));
    }

    public function update($request, $id)
    {
        $model = $this->model->find($id);
        if(is_null($model)) {
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        $model->update($request);
        return $this->respond(Response::HTTP_OK, $model);
    }

    public function destroy($id)
    {
        $model = $this->model->find($id);
        if(is_null($model)) {
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        $model->delete($id);
        return $this->respond(Response::HTTP_NO_CONTENT);
    }

    protected function respond($status, $data = [])
    {
        return response()->json($data, $status);
    }
}
