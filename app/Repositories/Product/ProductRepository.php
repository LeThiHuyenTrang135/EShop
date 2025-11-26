<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepositories;
use Faker\Provider\Base;

class ProductRepository extends BaseRepositories implements ProductRepositoryInterface
{   

    public function getModel()
    {
        return Product::class;
    }

}


