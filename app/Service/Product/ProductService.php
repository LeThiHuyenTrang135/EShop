<?php

namespace App\Service\Product;

use App\Repositories\Product\ProductRepositoryInterface;
use App\Service\BaseService;

class ProductService extends BaseService implements ProductServiceInterface
{
    public $repository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->repository = $productRepository;
    }

    // public function all()
    // {
    //     return $this->repository->all();
    // }

    // public function find($id)
    // {
    //     return $this->repository->find($id);
    // }

    // public function create(array $data)
    // {
    //     return $this->repository->create($data);
    // }

    // public function update(array $data, $id)
    // {
    //     return $this->repository->update($data, $id);
    // }

    // public function delete($id)
    // {
    //     return $this->repository->delete($id);
    // }
}