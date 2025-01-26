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
        // Recupera o usuário autenticado
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }

        return $user->purchases()->with('product')->get();
    }

    /**
     * Cria uma nova compra.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }

        $purchase = new Purchase($request->all());
        $purchase->user_id = $user->id; // Relaciona a compra ao usuário autenticado
        $purchase->save();

        return response()->json($purchase, 201);
    }

    /**
     * Exibe os detalhes de uma compra específica.
     */
    public function show(Purchase $purchase)
    {
        if (auth()->id() !== $purchase->user_id) {
            return response()->json(['error' => 'Você não tem permissão para visualizar esta compra'], 403);
        }

        return response()->json($purchase);
    }

    /**
     * Atualiza uma compra existente.
     */
    public function update(Request $request, Purchase $purchase)
    {
        if (auth()->id() !== $purchase->user_id) {
            return response()->json(['error' => 'Você não tem permissão para atualizar esta compra'], 403);
        }

        $purchase->update($request->all());
        return response()->json($purchase);
    }

    /**
     * Remove uma compra.
     */
    public function destroy(Purchase $purchase)
    {
        if (auth()->id() !== $purchase->user_id) {
            return response()->json(['error' => 'Você não tem permissão para excluir esta compra'], 403);
        }

        $purchase->delete();
        return response()->json(['message' => 'Compra excluída com sucesso']);
    }
}
