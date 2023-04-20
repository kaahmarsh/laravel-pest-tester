<?php

namespace Src\Domain\Environment\Repositories;

use Illuminate\Http\Request;
use Src\Domain\Environment\Models\Environment;

interface EnvironmentRepositoryInterface
{
    public static function findAll(): array;
    public static function findByCnpj(int $id): Environment | Null;
    public static function update(int $id,Request $request): Environment;
    public static function delete(int $id): void;
}