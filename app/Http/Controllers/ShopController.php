<?php

namespace App\Http\Controllers;

use App\Services\structureInformationApi;

class ShopController extends Controller
{

    function confirmOrder()
    {
        return view('order');
    }

    function informationOrder($orderId)
    {
        return view('information',compact('orderId'));
    }

    function listOrders()
    {
        return view('listOrder');
    }

    function detailOrder()
    {
        return view('order');
    }

    function getDataConectionApi()
    {
        $structureInformationApi = new structureInformationApi();
        $structureInformationApi->structureAuth();
        dd(json_encode($structureInformationApi->setArrayAuth()));
    }
}
