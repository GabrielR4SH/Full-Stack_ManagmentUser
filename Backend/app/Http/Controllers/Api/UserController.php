<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Import da trait
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Lista todos os usuários (apenas para administradores).
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', User::class);

        $users = User::all();
        return response()->json($users);
    }

    /**
     * Retorna o perfil do usuário autenticado.
     */
    public function show(): JsonResponse
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json($user);
    }

    /**
     * Atualiza o perfil do usuário autenticado.
     */
    public function update(Request $request): JsonResponse
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8|confirmed',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json(['message' => 'Perfil atualizado com sucesso', 'user' => $user]);
    }

    /**
     * Exclui o usuário autenticado.
     */
    public function destroy(): JsonResponse
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        $user->delete();

        return response()->json(['message' => 'Conta excluída com sucesso'], Response::HTTP_NO_CONTENT);
    }

    /**
     * Admin: Cria um novo usuário.
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', User::class);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        return response()->json(['message' => 'Usuário criado com sucesso', 'user' => $user], Response::HTTP_CREATED);
    }
}
