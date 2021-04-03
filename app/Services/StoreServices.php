<?php

namespace App\Services;

use App\Repositories\Eloquent\ProductRepository;
use App\Services\Interfaces\IStoreServices;

class StoreServices implements IStoreServices
{
    protected $productRepository;
    function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @return array
     */
    function getListProducts(): array
    {
        $listProducs = $this->productRepository->findAll();

        return ['status' => true, 'message' => $listProducs];
    }

    /**
     * @param int $id
     */
    function getProduct($id): array
    {
        return ['status' => true, 'message' => $this->productRepository->find($id)];
    }
}
