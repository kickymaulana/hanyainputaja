<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        auth()->logout();

        $this->get('/')->assertRedirect('/login');
    }

    public function test_user_can_login_and_logout(): void
    {
        auth()->logout();
        $user = User::factory()->create(['email' => 'login@example.com', 'password' => 'password', 'role' => 'viewer']);

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])->assertRedirect('/');
        $this->assertAuthenticatedAs($user);

        $this->post('/logout')->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        auth()->logout();
        User::factory()->create(['email' => 'login@example.com', 'password' => 'password']);

        $this->from('/login')->post('/login', ['email' => 'login@example.com', 'password' => 'wrong'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('email');
    }
}
