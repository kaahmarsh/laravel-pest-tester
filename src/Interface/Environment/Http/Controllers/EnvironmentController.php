<?php

namespace Src\Interface\Environment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Domain\Environment\Models\Environment;
use Src\Domain\Environment\Services\EnvironmentService;
use Src\Infrastructure\Environment\Repositories\EnvironmentRepository;

class EnvironmentController extends Controller
{
    /**
     * @var EnvironmentRepository
     */
    private $repository;
     /**
     * @var EnvironmentService
     */
    private $service;
    
    public function __construct(EnvironmentRepository $repository,EnvironmentService $service)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index() : JsonResponse
    {
        $users = $this->repository->findAll();
        
        return response()->json($users);
    }
    
    public function store(Request $request): JsonResponse
    {
        return $this->service->store($request->cnpj);
    }

    public function update(int $cnpj,Request $request): JsonResponse
    {
        return $this->service->update($cnpj,$request);
    }
    
    public function show(int $cnpj)
    {
        return $this->repository->findByCnpj($cnpj);
    }

    public function storeCertificate(Request $request)
    {
        return $this->service->storeCertificate($request);
    }

    public function delete(int $cnpj)
    {
        return $this->service->delete($cnpj);
    }
}