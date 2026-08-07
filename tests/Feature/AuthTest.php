<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'Kaif',
            'email' => 'kaif@test.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201);

        $response->assertJson([
            'success' => true,
        ]);
    }
}
