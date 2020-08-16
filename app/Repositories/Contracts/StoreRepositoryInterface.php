<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface StoreRepositoryInterface
{
    public function create(object $request);

    public function find(int $id);

    public function list(object $request);

    public function update(int $id, object $request);

    public function delete(int $id);
}
