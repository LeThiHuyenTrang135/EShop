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

    // public function getFeaturedProductsByCategory(int $categoryId)
    // {
    //     return $this->model->where('featured', true)
    //         ->where('product_category_id', $categoryId)
    //         ->get();
    // }

    public function getFeaturedProductsByCategory(int $categoryId)
    {
        return $this->model
            ->with(['productImages', 'productCategory']) // <<< thêm dòng này
            ->where('featured', true)
            ->where('product_category_id', $categoryId)
            ->get();
    }

    public function getProductOnIndex($request)
    {
        $perPage = $request->show ?? 3;
        $sortBy = $request->sort_by ?? 'latest';



        switch ($sortBy){
            case 'latest':
                $products = $this->model->orderBy('id');
                break;
            case 'oldest':
                $products = $this->model->orderByDesc('id');
                break;
            case 'name-ascending':
                $products = $this->model->orderBy('name');
                break;
            case 'name-descending':
                $products = $this->model->orderByDesc('name');
                break;
            case 'price-ascending':
                $products = $this->model->orderBy('price');
                break;
            case 'price-descending':
                $products = $this->model->orderByDesc('price');
                break;
            default:
                $products = $this->model->orderBy('id');

        }


        $products = $products->paginate($perPage);

        $products->appends(['sort_by' => $sortBy, 'show' => $perPage]);

        return $products;
    }

        
    

}


