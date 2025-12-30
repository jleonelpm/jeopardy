<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que la pantalla de registro es accesible.
     */
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * Test que un nuevo usuario puede registrarse.
     */
    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Moderator',
            'email' => 'test@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));
        
        $user = User::where('email', 'test@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('moderador', $user->role);
    }

    /**
     * Test que el registro falla sin contraseña confirmada.
     */
    public function test_password_confirmation_must_match(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Moderator',
            'email' => 'test@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'DifferentPassword',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test que no puede haber duplicados de email.
     */
    public function test_email_must_be_unique(): void
    {
        $user = User::factory()->moderator()->create();

        $response = $this->post('/register', [
            'name' => 'Another Moderator',
            'email' => $user->email,
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test que la contraseña debe cumplir requisitos de seguridad.
     */
    public function test_password_must_be_secure(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Moderator',
            'email' => 'test@example.com',
            'password' => '123',
            'password_confirmation' => '123',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
