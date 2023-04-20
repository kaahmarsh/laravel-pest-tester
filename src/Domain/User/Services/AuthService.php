<?php

namespace Src\Domain\User\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthService
{
    public function login($request)
    {
        if ($this->validator($request)->fails()) {
             
            return $this->validator($request)->validate();
        }
        
        $credentials = $request->only(['email', 'password']);

        $token = auth('api')->attempt($credentials);

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = auth('api')->user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ],200
        ]);
    }

    public function validator($request) //Função responsável por validar os campos email e password
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                Rule::exists('users')->where(function ($query) use ($request) {
                    $query->where('email', $request->email);
                }),
            ],
            'password' => 'required|min:8',
        ]);

        return $validator;
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Desconectado com sucesso'],200);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => auth('api')->user(),
            'authorisation' => [
                'token' => auth('api')->refresh(),
                'type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ],200
        ]);
    }
}