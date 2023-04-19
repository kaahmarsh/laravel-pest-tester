<?php

namespace Src\Domain\Environment\Services;

use Exception;
use Illuminate\Http\Request;
use Src\Infrastructure\Environment\Repositories\EnvironmentRepository;

class EnvironmentService 
{
    /**
     * @var EnvironmentRepository
     */
    private $repository;
    
    public function __construct(EnvironmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $environments = $this->repository->findAll();

        return response()->json([
            'success' => true,
            'data' => $environments
        ],200);
    }

    public function store($id)
    {
        $infoEnvironment = [];
        try 
        {
            $this->repository->store($infoEnvironment);

            return response()->json([
                'data' => [
                    'success' => true,
                    'message' => 'Criado com sucesso'
                ]
            ],201);

        } 
        catch (\Throwable $th) 
        {
            return response()->json([
                'data' => [
                    'success' => false,
                    'message' => $th->getMessage()
                ]
            ],404);
        }
    }

    public function show(int $id)
    {
        $environment = $this->repository->findById($id);
        return response()->json([
            'data' => [
                'success' => true,
                'message' => 'Registro Encontrado',
                'data' => $environment
            ]
        ],200); 
    }

    public function update(int $id,Request $request)
    {
        try {
            $this->repository->update($id,$request);
            return response()->json([],204);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeCertificate($request)
    {
        $pfxContent = file_get_contents($request->file);
        $password = $request->password;

        if (!openssl_pkcs12_read($pfxContent, $x509certdata, $password)) {
            return response()->json([
                'success' => false,
                'data' => 'Senha incorreta'
            ],401);
        }

        $dados = array ();
        $dados = openssl_x509_parse( openssl_x509_read($x509certdata['cert']) );

        if (is_numeric(substr($dados['subject']['CN'],-14))) {

            $id = substr($dados['subject']['CN'],-14);
            
        } elseif (is_numeric(substr($dados['name'],-14))) {
    
            $id = substr($dados['name'],-14);

        } else {
            return response()->json([
                'success' => false,
                'data' => 'Não foi encontrado o id no certificado inserido'
            ],401);
        }

        return self::store($id);
    }

    public function delete(int $id)
    {
        $this->repository->delete($id);

        return response()->json([
            'data' => [
                'success' => true
            ]
        ],204);
    }
}