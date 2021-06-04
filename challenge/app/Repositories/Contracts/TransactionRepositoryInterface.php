<?php

namespace App\Repositories\Contracts;

interface TransactionRepositoryInterface
{
    public function create ($data);
    public function update (array $data);
    public function delete ();
    public function paginate (int $integer);
    public function orderBy ($column, $clause = 'DESC');
}
