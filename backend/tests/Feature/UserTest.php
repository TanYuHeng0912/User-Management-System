<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->token = $this->user->createToken('test-token')->plainTextToken;
});

test('can list users with pagination', function () {
    User::factory()->count(20)->create();

    $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->getJson('/api/users');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data',
            'current_page',
            'per_page',
            'total',
        ]);
});

test('can search users by firstname', function () {
    User::factory()->create(['firstname' => 'John', 'lastname' => 'Doe']);
    User::factory()->create(['firstname' => 'Jane', 'lastname' => 'Smith']);

    $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->getJson('/api/users?search=John');

    $response->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.firstname', 'John');
});

test('can search users by lastname', function () {
    User::factory()->create(['firstname' => 'John', 'lastname' => 'Doe']);
    User::factory()->create(['firstname' => 'Jane', 'lastname' => 'Smith']);

    $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->getJson('/api/users?search=Smith');

    $response->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.lastname', 'Smith');
});

test('can search users by email', function () {
    User::factory()->create(['email' => 'john@example.com']);
    User::factory()->create(['email' => 'jane@example.com']);

    $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->getJson('/api/users?search=john@example.com');

    $response->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.email', 'john@example.com');
});

test('can search users by phone', function () {
    User::factory()->create(['phone' => '1234567890']);
    User::factory()->create(['phone' => '0987654321']);

    $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->getJson('/api/users?search=1234567890');

    $response->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.phone', '1234567890');
});

test('can create a new user', function () {
    $userData = [
        'firstname' => 'John',
        'lastname' => 'Doe',
        'email' => 'newuser@example.com',
        'phone' => '1234567890',
        'password' => 'password123',
        'status' => 'active',
    ];

    $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->postJson('/api/users', $userData);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'id',
            'firstname',
            'lastname',
            'email',
            'phone',
            'status',
        ])
        ->assertJson([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'newuser@example.com',
        ]);

    $this->assertDatabaseHas('users', [
        'email' => 'newuser@example.com',
        'firstname' => 'John',
        'lastname' => 'Doe',
    ]);
});

test('cannot create user with duplicate email', function () {
    User::factory()->create(['email' => 'existing@example.com']);

    $userData = [
        'firstname' => 'John',
        'lastname' => 'Doe',
        'email' => 'existing@example.com',
        'password' => 'password123',
        'status' => 'active',
    ];

    $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->postJson('/api/users', $userData);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

test('can show a specific user', function () {
    $user = User::factory()->create();

    $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->getJson("/api/users/{$user->id}");

    $response->assertStatus(200)
        ->assertJson([
            'id' => $user->id,
            'email' => $user->email,
        ]);
});

test('can update a user', function () {
    $user = User::factory()->create();

    $updateData = [
        'firstname' => 'Updated',
        'lastname' => 'Name',
    ];

    $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->putJson("/api/users/{$user->id}", $updateData);

    $response->assertStatus(200)
        ->assertJson([
            'firstname' => 'Updated',
            'lastname' => 'Name',
        ]);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'firstname' => 'Updated',
        'lastname' => 'Name',
    ]);
});

test('can update user password', function () {
    $user = User::factory()->create();

    $updateData = [
        'password' => 'newpassword123',
    ];

    $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->putJson("/api/users/{$user->id}", $updateData);

    $response->assertStatus(200);

    $user->refresh();
    expect(Hash::check('newpassword123', $user->password))->toBeTrue();
});

test('can delete a user', function () {
    $user = User::factory()->create();

    $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
        ->deleteJson("/api/users/{$user->id}");

    $response->assertStatus(200)
        ->assertJson(['message' => 'User deleted successfully']);

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

test('unauthenticated user cannot access users', function () {
    $response = $this->getJson('/api/users');

    $response->assertStatus(401);
});

test('unauthenticated user cannot create users', function () {
    $response = $this->postJson('/api/users', []);

    $response->assertStatus(401);
});

