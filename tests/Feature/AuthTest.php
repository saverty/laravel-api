<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function register(){
        $this->json('POST', 'auth/register', ['name' => 'Sally'])
            ->assertJson(200)
            ->assertJsonStructure(
                "user", "token"
            );
    }
}
