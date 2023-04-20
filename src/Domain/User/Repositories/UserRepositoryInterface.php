<?php 

namespace Src\Domain\User\Repositories;

use Src\Domain\User\Models\User;

interface UserRepositoryInterface 
{
    public function findAll(): array;

    public static function findById(string $userId): User | Null;

    public function findByEmail(string $email): User;

    public function store(User $user): User;

    public static function updatePassword(User $user): void;

    public static function deleteById(User $user): void;
}