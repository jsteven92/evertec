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
        dd(rand(1000,2000));
        $structureInformationApi = new ServicesStructureInformationApi();
        dd(json_encode($structureInformationApi->structureCreateRequest()));
        dd($this->productRepository->findAll());

    }
}
