<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface
{
    public function create(object $request);

    public function find(int $id);

    public function list(object $request);

    public function update(int $id, object $request);

    public function delete(int $id);
}
