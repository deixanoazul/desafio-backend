<?php

namespace App\Repositories\Contracts;

interface TransactionRepositoryInterface
{
    public function handle(array $data);
}
