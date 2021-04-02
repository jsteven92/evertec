<?php

namespace App\Repositories\Eloquent;

use App\Model\Order;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends BaseRepository
{
    public function getModel():Model
    {
        return new Order();
    }

}