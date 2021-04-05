<?php

namespace Tests\Unit\app\Services;

use App\Services\structureInformationApi;
use Tests\TestCase;

class StructureInformationApiTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    function testStructureAuth(): void
    {

        $structure = new structureInformationApi();
        $structure->structureAuth();
        $auth = $structure->setArrayAuth();

        $this->assertSame(4, count($auth));
    }

    function testStructureBuyer(): void
    {

        $structure = new structureInformationApi();
        $structure->structureBuyer(
            "steven",
            "jimenez",
            "jstevenjimenez@gmail.com",
            "123456",
            "CC",
            "3128514141"
        );
        $buyer = $structure->setArrayBuyer();

        $this->assertSame(6, count($buyer));
    }

    function testStructurePayment(): void
    {

        $structure = new structureInformationApi();
        $structure->structurePayment(
            rand(1000, 2000),
            "Pago básico de prueba",
            'COP',
            rand(10000, 99999)
        );
        $payment = $structure->setArrayPayment();

        $this->assertSame(4, count($payment));
    }
}
