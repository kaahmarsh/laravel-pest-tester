<?php

//Teste function index
it('show all users', function () {
    $response = $this->get('/users');
    expect($response)->assertStatus(200);
});

// it('can create a to-do', function () {
//     $attributes = Todo::factory()->raw();
//     $response = $this->postJson('/api/todos', $attributes);
//     $response->assertStatus(201)->assertJson(['message' => 'Todo has been created']);
//     $this->assertDatabaseHas('todos', $attributes);
// });

//Teste function store
it('create a user', function () {
    $response = $this->post('/users',[
        "name" => "Pest".random_int(1,1000),
        "email" => random_int(1,1000)."teste@gmail.com",
        "access" => 2
    ]);
    
    $response->assertStatus(201);
});

// uses(Tests\TestCase::class, RefreshDatabase::class);

// it('does not create a to-do without a name field', function () {
//     $response = $this->postJson('/api/todos', []);
//     $response->assertStatus(422);
// });

// it('can create a to-do', function () {
//     $attributes = Todo::factory()->raw();
//     $response = $this->postJson('/api/todos', $attributes);
//     $response->assertStatus(201)->assertJson(['message' => 'Todo has been created']);
//     $this->assertDatabaseHas('todos', $attributes);
// });

// it('can fetch a to-do', function () {
//     $todo = Todo::factory()->create();

//     $response = $this->getJson("/api/todos/{$todo->id}");

//     $data = [
//         'message' => 'Retrieved To-do',
//         'todo' => [
//             'id' => $todo->id,
//             'name' => $todo->name,
//             'completed' => $todo->completed,
//         ]
//     ];

//     $response->assertStatus(200)->assertJson($data);
// });

// it('can update a to-do', function () {
//     $todo = Todo::factory()->create();
//     $updatedTodo = ['name' => 'Updated To-do'];
//     $response = $this->putJson("/api/todos/{$todo->id}", $updatedTodo);
//     $response->assertStatus(200)->assertJson(['message' => 'To-do has been updated']);
//     $this->assertDatabaseHas('todos', $updatedTodo);
// });

// it('can delete a to-do', function () {
//     $todo = Todo::factory()->create();
//     $response = $this->deleteJson("/api/todos/{$todo->id}");
//     $response->assertStatus(200)->assertJson(['message' => 'To-do has been deleted']);
//     $this->assertCount(0, Todo::all());
// });