<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Http\Requests\StorePurchaseRequest;

class PurchaseController extends Controller
{
    /**
     * Exibe todas as compras do usuário autenticado.
     */
    public function index()
    {
        return auth()->user()->purchases()->with('product')->get();
    }

    /**
     * Cria uma nova compra.
     */
    public function store(StorePurchaseRequest $request)
    {
        $user = auth()->user();
        $product = Product::findOrFail($request->product_id);

        // Verifica se o produto tem estoque suficiente
        if ($product->quantity < $request->quantity) {
            return response()->json(['error' => 'Produto sem estoque suficiente'], 400);
        }

        // Verifica se o usuário tem saldo suficiente
        $totalPrice = $product->price * $request->quantity;
        if ($user->balance < $totalPrice) {
            return response()->json(['error' => 'Saldo insuficiente'], 400);
        }

        // Deduzir saldo do usuário e quantidade do produto
        $user->balance -= $totalPrice;
        $user->save();

        $product->quantity -= $request->quantity;
        $product->save();

        // Cria a compra
        $purchase = Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
        ]);

        return response()->json($purchase, 201);
    }
}
