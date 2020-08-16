<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreRequest;
use App\Models\Store;
use App\Repositories\Contracts\StoreRepositoryInterface;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    private $storeRepository;

    public function __construct(StoreRepositoryInterface $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stores = $this->storeRepository->list($request);

        return response()->json($stores, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $store = $this->storeRepository->create($request);

        return response()->json($store, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $store = $this->storeRepository->find($id);

        if ($store) {
            return response()->json($store, 200);
        }

        return response()->json(['errors' => 'Not Found'], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, $id)
    {
        $store = $this->storeRepository->update($id, $request);

        if ($store) {
            return response()->json($store, 200);
        }

        return response()->json(['errors' => 'Not Found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $store = $this->storeRepository->delete($id);

        if ($store) {
            return response()->json([], 204);
        }

        return response()->json(['errors' => 'Not Found'], 404);
    }
}
