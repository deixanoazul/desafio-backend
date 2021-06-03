<?php

namespace App\Repositories\Eloquent;

abstract class AbstractRepository 
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    public function findOrFail (int $id) 
    {
        return $this->model->findOrFail($id);
    }

    public function create ($data) 
    {
        return $this->model->create($data);
    }
    
    public function update (array $data)
    {
        return $this->model->update($data);
    }

    public function paginate (int $integer)
    {
        return $this->model->paginate($integer);
    }

    public function orderBy ($column, $clause = 'DESC')
    {
        return $this->model->orderBy($column, $clause);
    }

    public function delete ()
    {
        return $this->model->update();
    }

    protected function resolveModel () 
    {
        return app($this->model);
    }
}