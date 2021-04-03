<?php
namespace App\Services\Interfaces;

interface IStoreServices
{
    /**
     * lista de todos los productos
     * @return array
     */
    function getListProducts(): array;
    
    /**
     * Producto por Id
     * @param int $id
     * @return array
     */
    function getProduct(int $id): array;
}