<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::get();
        
        if($products->count() > 0){
            
            return ProductResource::collection($products);
        
        } else{
            return response()->json(['message' => 'No message available'], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // Os dados validados são automaticamente passados para o método
        $validatedData = $request->validated();

        // Crie o produto com os dados validados
        $product = Product::create($validatedData);

        // Retorne uma resposta adequada, por exemplo, redirecionando ou retornando o produto criado
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $prodcut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $prodcut)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $prodcut)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $prodcut)
    {
        //
    }
}
