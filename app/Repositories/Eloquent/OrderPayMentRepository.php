<?php

namespace App\Repositories\Eloquent;

use App\Model\OrderPayMent;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class OrderPayMentRepository extends BaseRepository
{
    public function getModel(): Model
    {
        return new OrderPayMent();
    }

    /**
     * consulta que traer las ordenes pendientes habilitadas para ser
     * consultadas por la sonda
     * @return lista de ordenes
     */
    public function getRequestIdOrderPending(): Collection
    {
        return $this->getModel()
            ->where('status', 'PENDING')
            ->whereRaw('TIMESTAMPDIFF(MINUTE,created_at,now()) >= ' . config('api.api_time_wait'))
            ->whereRaw('TIMESTAMPDIFF(MINUTE,called_api_at,now()) >= ' . config('api.api_time_schedule'))
            ->whereRaw('TIMESTAMPDIFF(MINUTE,created_at,now()) <= ' . config('api.api_time_minute_max_wait'))
            ->select('request_id', 'id')
            ->get();
    }

    /**
     * actualiza el estado de las ordenes segun resultado 
     * de consultar la api
     * @param array datos
     * @param string $requestId llave a buscar
     * @return true o false . estado del update
     */
    public function updateForRequestId(array $datos, string $requestId)
    {
        return $this->getModel()
            ->where('request_id', $requestId)
            ->update($datos);
    }

    /**
     * traer la id orden de un requestId
     * @param string $requestId llave a buscar
     * @return model
     */
    public function getOrderIdToRequestId(string $requestId)
    {
        return $this->getModel()
            ->where('request_id', $requestId)
            ->select('order_id')
            ->limit(1)
            ->get();
    }

    /**
     * traer todos los payment de una order
     * @param string $requestId llave a buscar
     * @return true o false . estado del update
     */
    public function getAllToOrderId(string $orderId)
    {
        return $this->getModel()
            ->where('order_id', $orderId)
            ->get();
    }
}
