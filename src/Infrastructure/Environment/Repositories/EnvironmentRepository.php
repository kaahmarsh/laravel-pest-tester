<?php

namespace Src\Infrastructure\Environment\Repositories;

use Illuminate\Http\Request;
use Src\Domain\Environment\Models\Environment;
use Src\Domain\Environment\Repositories\EnvironmentRepositoryInterface;

class EnvironmentRepository implements EnvironmentRepositoryInterface
{
    public static function findAll(): array
    {
        return Environment::all()->toArray();
    }
    public static function findById(int $id):Environment
    {
        return Environment::find($id);
    }

    public function store($request):Environment
    {
        return Environment::create(
            [
                'id' => str_replace(array('/','-','.'),'',$request->id),
                'razao_social' => strtoupper($request->nome),
                'fantasia' => strtoupper($request->fantasia),
                'cep' => str_replace(array('/','-','.'),'',$request->cep),
                'telefone' => substr(str_replace(array('/','-','(',')'),'',$request->telefone), 13),
                'email' => $request->email,
                'UF' => $request->uf,
                'IE' => '00',
                'CRT' => $request->crt
            ]
        );
    }

    public static function update(int $id,Request $request): Environment
    {
        $environment = self::findByid($id);
        
        $environment->razao_social = strtoupper($request->razao_social);
        $environment->IE = str_replace(array('-','/'),'',$request->IE);
        $environment->fantasia = strtoupper($request->fantasia);
        $environment->cep = str_replace(array('-','/'),'',$request->cep);
        $environment->telefone = str_replace(array('-','(',')'),'',$request->telefone);
        $environment->email = $request->email;
        $environment->CRT = $request->CRT;
        $environment->UF = $request->uf;

        $environment->save();

        return $environment;
    }

    public static function delete(int $id): void
    {
        Environment::where('id',$id)
            ->delete();
    }
}