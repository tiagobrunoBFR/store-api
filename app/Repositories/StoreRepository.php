<?php

namespace App\Repositories;

use App\Models\Store;
use App\Repositories\Contracts\StoreRepositoryInterface;
use Illuminate\Support\Collection;

class StoreRepository implements StoreRepositoryInterface
{
    private $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    public function create($request)
    {
        return $this->store->create($request->only($this->store->getFillable()));
    }

    public function update($id, $request)
    {
        $store = $this->store->find($id);

        if ($store) {
            $store->name = $request->name;
            $store->email = $request->email;
            $store->save();

            return $store;
        }

        return null;
    }

    public function find($id)
    {
        $store = $this->store->find($id);

        if ($store) {
            return $store;
        }

        return null;
    }

    public function delete($id)
    {
        $store = $this->store->find($id);

        if ($store) {
            $store->delete();
            return true;
        }

        return false;
    }

    public function list(object $request, bool $paginate = true, bool $withProducts = true)
    {
        $stores = $this->store->newQuery();

        if ($request->has('name')) {
            $stores->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('email')) {
            $stores->where('email', $request->email);
        }

        if ($withProducts) {
            $stores->with('products');
        }

        if ($paginate) {
            return $stores->paginate();
        }

        return $stores->get();
    }
}
