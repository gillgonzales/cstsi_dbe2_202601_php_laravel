<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Sleep;

class LoginController extends Controller
{
    public function authenticate(array $credentials): User | null
    {
        if (Auth::attempt($credentials))
            return User::where('email', $credentials['email'])->first();
        return null;
    }


    public function login(LoginRequest $request): UserResource | JsonResponse
    {
        try {
            $credentials = $request->validated();
            $user = $this->authenticate($credentials);
            if (!$user)
                throw new Exception("Dados inválidos!!");
            return new UserResource($user)
                ->additional(["message" => "Usuário logado via cookies!!!"]);
        } catch (Exception $error) {
            return $this->errorHandler('Erro ao realizar login!!', $error);
        }
    }

    public function user(Request $request)
    {
        // Sleep::for(10)->seconds();
        return $request->user();
    }

    public function logout(Request $request)
    {
        $user =  Auth::guard('web')->user();
        if (!$user)
            return response()->json(["message" => "Não autenticado!"], 401);
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(["message" => "Sessão encerrada!!!"]);
    }
}
