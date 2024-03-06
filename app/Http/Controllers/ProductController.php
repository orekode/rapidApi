<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Models\FileTrash;
use App\Models\ProductImage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return ProductResource::collection(
            Product::filter()->orderBy('score', 'desc')->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());

        foreach ($request->file('images') as $image) {
            if ($path = $image->store('product/images')) {
                $product->images()->create([
                    'image' => $path
                ]);
            }
        }

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());

        foreach ($request->file('images') as $image) {
            if ($path = $image->store('product/images')) {
                $product->images()->create([
                    'image' => $path
                ]);
            }
        }

        foreach ($request->images_removed as $id) {
            $image = ProductImage::find($id);

            if ($image) {
                FileTrash::create([
                    'path' => $image->image
                ]);

                $image->delete();
            }
        }

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
