<?php

namespace Tests\Feature\app\repository;

use App\Model\OrderPayMent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Eloquent\OrderPayMentRepository;
use Tests\TestCase;

class OrderPaymentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    function testCreateOrderPayment()
    {

        $data = factory(OrderPayMent::class)->make()->toArray();

        $orderPaymentRepository = new OrderPayMentRepository(new OrderPayMent());
        $response = $orderPaymentRepository->create($data);

        $this->assertInstanceOf(OrderPayMent::class, $response);
        $this->assertDatabaseHas('orders_payments', $data);
    }

    function testFindOrderPayment()
    {
        $data = factory(OrderPayMent::class)->make()->toArray();

        $orderPaymentRepository = new OrderPayMentRepository(new OrderPayMent());
        $response = $orderPaymentRepository->create($data);

        $data2 = $orderPaymentRepository->find($response->id)->toArray();

        $this->assertEquals($response->toArray(), $data2);
    }

    function testUpdateOrderPayments()
    {
        $data = factory(OrderPayMent::class)->make()->toArray();

        $orderPaymentRepository = new OrderPayMentRepository(new OrderPayMent());
        $response = $orderPaymentRepository->create($data);

        $data['status'] = 'REJECTED';
        $this->assertTrue($orderPaymentRepository->update($data,$response->id));

    }
}