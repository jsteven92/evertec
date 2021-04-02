<?php

namespace App\Repositories\Eloquent;

use App\Model\Product;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends BaseRepository
{
    public function getModel():Model
    {
        return new Product();
    }

}