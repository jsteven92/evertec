<?php

namespace App\Services;

use App\Repositories\Eloquent\OrderPayMentRepository;
use App\Repositories\Eloquent\OrderRepository;
use App\Services\Interfaces\IOrderService;
use DateTime;
use Illuminate\Support\Facades\Http;

class OrderService implements IOrderService
{
    protected $orderRepository;
    protected $orderPayMentRepository;

    function __construct(
        OrderRepository $orderRepository,
        OrderPayMentRepository $orderPayMentRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderPayMentRepository = $orderPayMentRepository;
    }

    /**
     * Realiza una nueva solicitid de orden al api
     * e inserta en BD
     * @param array $data
     * @return array
     */
    function newOrder(array $data): array
    {
        /**creamos la order en la BD */
        $order = $this->orderRepository->create($data['order']);

        $structure = new structureInformationApi();
        $structure->structureAuth();
        $structure->getReference($order->id);

        /*si el frontend envia los datos del buyer se enviaran en la solicitud*/
        if (isset($data['data']['buyer'])) {
            $buyer = $data['data']['buyer'];

            $structure->structureBuyer(
                $buyer['name'],
                $buyer['surname'],
                $buyer['email'],
                $buyer['document'],
                $buyer['document_type'],
                $buyer['mobile']
            );
        }

        /*si el frontend envia los datos del payment se enviaran en la solicitud*/
        if (isset($data['data']['payment'])) {
            $payment = $data['data']['payment'];

            $structure->getReference($order->id);

            $structure->structurePayment(
                __('order.description_payment'),
                $payment['currency'],
                $payment['total']
            );
        }

        $response = Http::post(
            config('api.api_base') . config('api.api_create_request'),
            $structure->structureCreateRequest()
        );

        $result = $response->json();

        if ($result['status']['status'] == config('api.api_create_request_success')) {
            $requestId = $result['requestId'];
            $processUrl = $result['processUrl'];

            $dataOrderPayMent = [
                'order_id' => $order->id,
                'request_id' => $requestId,
                'process_url' => $processUrl,
                'status' => 'PENDING',
            ];

            $this->orderPayMentRepository->create($dataOrderPayMent);

            return ['status' => true, 'message' => $dataOrderPayMent];
        } else {
            $order->delete();
            return ['status' => false, 'message' => __('order.createOrder_error')];
        }
    }

    /**
     * Realiza una consulta a la api para actualizar el estado de los pagos 
     * de la orden
     * @param string $requestId
     * 
     */
    function verifyStatusOrder(string $requestId): void
    {
        $structure = new structureInformationApi();
        $structure->structureAuth();

        $response = Http::post(
            config('api.api_base') . config('api.api_request_information') . $requestId,
            $structure->structureRequestInformation()
        );
        $result = $response->json();
        $orderStatus = '';
        $orderId = 0;

        if ($result['status']['status'] == 'APPROVED') {
            if (isset($result['payment'])) {
                if ($result['payment'][0]['status']['status'] == 'APPROVED') {
                    $orderStatus = 'PAYED';
                    $internalReference = $result['payment'][0]['internalReference'];

                    $dataUpdatePaymet = [
                        'called_api_at' => new DateTime(),
                        'internal_reference' => $internalReference,
                        'status' => 'PAYED'
                    ];

                    $resultOrder = $this->orderPayMentRepository->getOrderIdToRequestId($requestId);
                    $orderId = $resultOrder[0]->order_id;
                }
            }
        } else {
            $dataUpdatePaymet = [
                'called_api_at' => new DateTime()
            ];
        }

        $this->orderPayMentRepository->updateForRequestId(
            $dataUpdatePaymet,
            $requestId
        );
        /**si la variable orderStatus no es vacia es porque la orden principal cambio de estado */
        if ($orderStatus != '') {
            $this->orderRepository->update(
                [
                    'status' => $orderStatus
                ],
                $orderId
            );
        }
    }

    /**
     * Detalle de la order
     * si la tabla payment en campo called_api es null es porque es primera vez
     * que se llama a la verificacion del pago
     * @param string $requestId
     * @return array
     */
    function informationOrder(string $orderId): array
    {
        $resultOrder = $this->orderRepository->find($orderId);

        $detailOrder = [
            'name' => $resultOrder->customer_name,
            'email' => $resultOrder->customer_email,
            'mobile' => $resultOrder->customer_mobile,
            'status' => $resultOrder->status,
            'price' => $resultOrder->price,
            'product_id' => $resultOrder->product_id,
            'product_name' => "Nombre producto",
        ];

        $resultPayment = $this->orderPayMentRepository->getAllToOrderId($orderId);
        $verifyStatusOrder = false;

        foreach ($resultPayment as $payment) {
            $detailPayment[] = [
                'request_id' => $payment->request_id,
                'process_url' => $payment->process_url,
                'internal_reference' => $payment->internal_reference,
                'status' => $payment->status,
                'called_api_at' => $payment->called_api_at
            ];
            if ($payment->called_api_at == null) {
                $verifyStatusOrder = true;
            }
        }

        if ($verifyStatusOrder) {
            $this->verifyStatusOrder($payment->request_id);
        }

        $detail['order'] = $detailOrder;
        $detail['payment'] = $detailPayment;

        return ['status' => true, 'message' => $detail];
    }

    /**
     * anula un pago ya realizado
     * @param string $internationalReference
     * @return array
     */
    function reversePayment(string $internationalReference): array
    {
        $structure = new structureInformationApi();
        $structure->structureAuth();

        $response = Http::post(
            env('API_BASE') . env('API_REVERSE_PAYMENT'),
            [
                $structure->$structure->structureRevercePayMent($internationalReference)
            ]
        );
        return [];
    }
}
