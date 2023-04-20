<?php

namespace Src\Interface\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Domain\User\Services\AuthService;

class AuthController extends Controller
{
    private $service;
    
    public function __construct(AuthService $service)
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
        $this->service = $service;
    }

    public function login(Request $request)
    {
        return $this->service->login($request);
    }

    public function logout()
    {
        return $this->service->logout();
    }

    public function refresh()
    {
        return $this->service->refresh();
    }
}
