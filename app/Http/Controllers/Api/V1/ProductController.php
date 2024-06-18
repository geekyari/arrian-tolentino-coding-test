<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\V1\ProductResource;
use App\Http\Resources\V1\ProductCollection;
use App\Http\Requests\V1\StoreProductRequest;
use App\Http\Requests\V1\UpdateProductRequest;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the product.
     *
     *
     */
    public function index()
    {
        return new ProductCollection(Product::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\StoreProductRequest  $request
     *
     */
    public function store(StoreProductRequest $request)
    {
        return new ProductResource(Product::create($request->all()));
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     *
     */
    public function show(Product $product)
    {
        $cache_key = 'product_' . $product->id;

        $cached_product = Cache::remember($cache_key, now()->addMinutes(10), function () use ($product) {
            return $product;
        });
        
        return new ProductResource($cached_product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\V1\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     *
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());

        Cache::forget('product_' . $product->id);

        return new ProductResource($product);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     *
     */
    public function destroy(Product $product)
    {
        Cache::forget('product_' . $product->id);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], Response::HTTP_OK);
    }

}
