<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\ProductRepository;
use App\Services\structureInformationApi as ServicesStructureInformationApi;
use structureInformationApi;

class ExampleController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(){
        
        $structureInformationApi = new ServicesStructureInformationApi();
        $structureInformationApi->structureAuth();

        dd(json_encode($structureInformationApi->setArrayAuth()));

    }
}
