<?php

namespace App\Repositories\Eloquent;

use App\Models\Transactions\Wallet;

abstract class AbstractRepository
{
    protected $model;

    protected $wallet;

    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    public function findOrFail (int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findWallet(int $id)
    {
        return $this->wallet::findOrFail($id);
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
