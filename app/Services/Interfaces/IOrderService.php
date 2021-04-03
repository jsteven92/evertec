<?php
namespace App\Services\Interfaces;

interface IOrderService
{
    /**
     * Realiza una nueva solicitid de orden al api
     * e inserta en BD
     * @param array $data
     * @return array
     */
    function newOrder(array $data): array;
    
    /**
     * Realiza una consulta a la api para traer el estado 
     * de la orden
     * @param string $requestId
     * @return array
     */
    function informationOrder(string $requestId): array;
   
    /**
     * Realiza una consulta a la api para traer el estado 
     * de la orden
     * @param string $requestId
     */
    function verifyStatusOrder(string $requestId): void;
    
    /**
     * anula un pago ya realizado
     * @param string $internationalReference
     * @return array
     */
    function reversePayment(string $internationalReference): array;
}