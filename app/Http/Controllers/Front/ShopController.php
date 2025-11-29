<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Services\Brand\BrandServiceInterface;
use App\Services\Product\ProductService;
use App\Services\Product\ProductServiceInterface;
use App\Services\ProductCategory\ProductCategoryService;
use App\Services\ProductCategory\ProductCategoryServiceInterface;
use App\Services\ProductComment\ProductCommentServiceInterface;
use Illuminate\Http\Request;

class ShopController extends Controller
{   
    private $productService;
    private $productCommentService;
    private $productCategoryService;
    private $brandService;

    public function __construct(ProductServiceInterface $productService, 
                                ProductCommentServiceInterface $productCommentService,
                                ProductCategoryServiceInterface $productCategoryService,
                                BrandServiceInterface $brandService) {
        $this->productService = $productService;
        $this->productCommentService = $productCommentService;
        $this->productCategoryService = $productCategoryService;
        $this->brandService = $brandService;
    }

    public function show($id)
    {
        $categories = $this->productCategoryService->all();
        $brands = $this->brandService->all();

        $product = $this->productService->find($id);

        $relatedProducts = $this->productService->getRelatedProducts($product);

        return view('front.shop.show', compact('product', 'relatedProducts','categories','brands'));

    }


    public function postComment(Request $request, $id)
    {
        // Lấy dữ liệu hợp lệ, bỏ _token
        $data = $request->except('_token');

        // Gắn product_id từ URL
        $data['product_id'] = $id;

        // Nếu user đã login
        $data['user_id'] = Auth::check() ? Auth::id() : null;

        // Validate form
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email',
            'messages' => 'required',
            'rating' => 'required|integer|min:1|max:5',

        ]);

        // Lưu comment
        $this->productCommentService->create($data);

        return redirect()->back()->with('success', 'Comment added!');
    }
    

    public function index(Request $request)
    {
        $categories = $this->productCategoryService->all();
        $brands = $this->brandService->all();

        $products = $this->productService->getProductOnIndex($request);

        return view('front.shop.index', compact('products', 'categories','brands'));
    }

    public function category($categoryName, Request $request)
    {
        $categories = $this->productCategoryService->all();
        $brands = $this->brandService->all();

        $products = $this->productService->getProductsByCategory($categoryName, $request);

        return view('front.shop.index', compact('products', 'categories', 'brands'));
    }

    
}
