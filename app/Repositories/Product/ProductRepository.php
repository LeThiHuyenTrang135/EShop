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

    public function getRelatedProducts ($product, $limit = 4)
    {
        return $this->model->where('product_category_id', $product->product_category_id)
            ->where('tag', $product->tag)
            ->limit($limit)
            ->get();
    }

}


