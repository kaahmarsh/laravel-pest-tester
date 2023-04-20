<?php

namespace Src\Interface\Users\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Domain\User\Models\User;
use Src\Domain\User\Services\UserService;
use Src\Infrastructure\Users\Repositories\UserRepository;

class UserController
{
    /**
     * @var UserService
     */
    private $service;

    /**
     * @var UserRepository
     */
    private $repository;
    
    public function __construct(UserService $service,UserRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index() : JsonResponse
    {
        $users = $this->repository->findAll();
        
        return response()->json([
            'data' => $users
        ],200);
    }

    public function store(Request $request): JsonResponse
    {
        return $this->service->store($request);
    }

    public function update(User $id,Request $request)
    {
        return $this->service->update($id,$request);
    }

    public function show($id)
    {
        try {
            return $this->repository->findById($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete(User $id)
    {
        return $this->service->delete($id);
    }

    public function forgotPassword(Request $request)
    {
        return $this->service->forgotPassword($request);
    }

    public function resetPassword(Request $request)
    {
        return $this->service->resetPassword($request);
    }
}
