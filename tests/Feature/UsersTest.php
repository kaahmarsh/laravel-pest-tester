<?php

// uses(Tests\TestCase::class, RefreshDatabase::class);

use Src\Domain\User\Models\User;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\patchJson;
use function Pest\Laravel\postJson;

it('show all users', function () {
    $response = $this->get('/users');
    expect($response)->assertStatus(200);
});

it('create a user', function () {
    $response = postJson('/users',[
        "name" => "Pest".random_int(1,1000),
        "email" => random_int(1,1000)."teste@gmail.com",
        "password" => bcrypt(random_int(1,8)),
        "access" => 2
    ]);
    
    $response->assertStatus(201);
});

it('update a user', function () {
    $user = User::create([
        "name" => "Pest".random_int(1,1000),
        "email" => random_int(1,1000).random_int(1,10)."@gmail.com",
        "password" => bcrypt(random_int(1,8)),
        "access" => 2
    ]);
    $editedName = 'Name Edited';
    $updateInfo = ['name' => $editedName];
    $response = patchJson("/users/{$user->id}", $updateInfo);
    
    expect($response['message'])->toEqual('Atualizado com sucesso')
        ->and($response->assertStatus(200));
});

it('delete a user', function () {
    $user = User::create([
        "name" => "Pest".random_int(1,1000),
        "email" => random_int(1,1000).random_int(1,10)."@gmail.com",
        "password" => bcrypt(random_int(1,8)),
        "access" => 2
    ]);
    $response = deleteJson("/users/{$user->id}");
    $find = getJson("/users/{$user->id}");
    expect($response['message'])->toEqual('Deletado com sucesso')
        ->and($find)->assertContent("");
});
