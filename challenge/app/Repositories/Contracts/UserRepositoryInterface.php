<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface 
{
    public function findOrFail (int $id);
    public function create ($data);
    public function update (array $data);
    public function delete ();
    public function paginate (int $integer);
    public function orderBy (string $column, $clause = 'DESC');
}