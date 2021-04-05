<?php

namespace Tests\Feature\app\repository;

use App\Model\Order;
use App\Repositories\Eloquent\OrderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Faker\Generator as Faker;

class OrderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    function testCreateOrder()
    {

        $data = factory(Order::class)->make()->toArray();

        $orderRepository = new OrderRepository(new Order());
        $response = $orderRepository->create($data);

        $this->assertInstanceOf(Order::class, $response);
        $this->assertDatabaseHas('orders', $data);
    }

    function testFindOrder()
    {
        $data = factory(Order::class)->make()->toArray();

        $orderRepository = new OrderRepository(new Order());
        $response = $orderRepository->create($data);

        $data2 = $orderRepository->find($response->id)->toArray();

        $this->assertEquals($response->toArray(), $data2);
    }

    function testUpdateOrder()
    {
        $data = factory(Order::class)->make()->toArray();

        $orderRepository = new OrderRepository(new Order());
        $response = $orderRepository->create($data);

        $data['customer_name'] = 'name test';
        $this->assertTrue($orderRepository->update($data,$response->id));

    }
}
