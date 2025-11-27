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
        $search = $request->search ?? '';

        $products = $this->model->where('name', 'like', '%' . $search . '%');



        switch ($sortBy){
            case 'latest':
                $products = $products->orderBy('id');
                break;
            case 'oldest':
                $products = $products->orderByDesc('id');
                break;
            case 'name-ascending':
                $products = $products->orderBy('name');
                break;
            case 'name-descending':
                $products = $products->orderByDesc('name');
                break;
            case 'price-ascending':
                $products = $products->orderBy('price');
                break;
            case 'price-descending':
                $products = $products->orderByDesc('price');
                break;
            default:
                $products = $products->orderBy('id');

        }


        $products = $products->paginate($perPage);

        $products->appends(['sort_by' => $sortBy, 'show' => $perPage]);

        return $products;
    }

        
    

}


