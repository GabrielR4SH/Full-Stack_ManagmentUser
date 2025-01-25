<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Lista todos os produtos
    public function index(): JsonResponse
    {
        $products = Product::all();
        return response()->json($products);
    }

    // Retorna um único produto
    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    // Armazena um novo produto
    public function store(StoreProductRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $product = Product::create($validatedData);

        return response()->json($product, Response::HTTP_CREATED);
    }

    // Atualiza um produto existente
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $validatedData = $request->validated();
        $product->update($validatedData);

        return response()->json($product);
    }

    // Exclui um produto
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
