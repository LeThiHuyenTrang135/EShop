<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepositories;
use App\Repositories\BaseRepository;
use Faker\Provider\Base;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{   

    public function getModel()
    {
        return Product::class;
    }

}


