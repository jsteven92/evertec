<?php

namespace Tests\Feature\http\controller;

use App\User;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStateListProducts()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')
            ->json('post', '/api/product/listProducts', [
                'email' => 'test@test.test',
                'name' => 'test',
                'password' => '123'
            ]);

        $response->assertStatus(200);
    }

    public function testGetProduct()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')
            ->json('get', '/api/product/product/1', [
                'email' => 'test@test.test',
                'name' => 'test',
                'password' => '123'
            ]);

        $response->assertStatus(200);
    }

    public function testGetProductResponseJson()
    {
        $user = User::find(1);
        $response = $this->actingAs($user, 'api')
            ->json('get', '/api/product/product/1', [
                'email' => 'test@test.test',
                'name' => 'test',
                'password' => '123'
            ]);

        $response->assertJsonStructure([
            "id", "price", "name"
        ]);
    }

}
