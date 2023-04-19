<?php

namespace Src\Infrastructure\Users\Repositories;

use Src\Domain\User\Models\User;
use Src\Domain\User\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function findAll(): array
    {
        return User::all()->toArray();
    }
    public static function findById(string $userId): User
    {
        return User::find($userId);
    }
    public function findByEmail(string $email): User
    {
        return User::where('email',$email)->first()->toJson(JSON_PRETTY_PRINT);
    }
    public function store($user): User
    {
        $user = User::create(
            [
                'name' => strtoupper($user->name),
                'email' => $user->email,
                'access' => $user->access,
                'password' => bcrypt($user->password),
            ]
        );
        
        return $user;
    }

    public static function deleteById(User $user): void
    {
        $user->delete();
        return;
    }

    public static function updatePassword(User $user): void
    {
        $user->password = bcrypt($user->password);
        $user->save();
        
        return;
    }
}