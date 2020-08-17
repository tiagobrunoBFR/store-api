<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function create($request)
    {
        return $this->product->create($request->only($this->product->getFillable()));
    }

    public function update($id, $request)
    {
        $product = $this->product->find($id);

        if ($product) {
            $product->name = $request->name;
            $product->price = $request->price;
            $product->active = $request->active;
            $product->save();

            return $product;
        }

        return null;
    }

    public function find($id)
    {
        $product = $this->product->find($id);

        if ($product) {
            return $product;
        }

        return null;
    }

    public function delete($id)
    {
        $product = $this->product->find($id);

        if ($product) {
            $product->delete();
            return true;
        }

        return false;
    }

    public function list(object $request, bool $paginate = true)
    {
        $products = $this->product->newQuery();

        if ($request->has('name')) {
            $products->where('name', 'like', '%' . $request->name . '%');
        }

        if ($paginate) {
            return $products->paginate();
        }

        return $products->get();
    }
}
