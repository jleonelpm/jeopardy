<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login con credenciales válidas
     */
    public function test_login_with_valid_credentials(): void
    {
        // Crear usuario
        $user = User::factory()->create([
            'email' => 'moderador@test.com',
            'password' => bcrypt('password123'),
            'role' => 'moderador',
        ]);

        // Intentar login
        $response = $this->post('/login', [
            'email' => 'moderador@test.com',
            'password' => 'password123',
        ]);

        // Verificar que el usuario está autenticado
        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /**
     * Test login con credenciales inválidas
     */
    public function test_login_with_invalid_credentials(): void
    {
        // Crear usuario
        User::factory()->create([
            'email' => 'moderador@test.com',
            'password' => bcrypt('password123'),
        ]);

        // Intentar login con contraseña incorrecta
        $response = $this->post('/login', [
            'email' => 'moderador@test.com',
            'password' => 'wrongpassword',
        ]);

        // Verificar que NO está autenticado
        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    /**
     * Test logout
     */
    public function test_logout(): void
    {
        // Crear y autenticar usuario
        $user = User::factory()->create();
        $this->actingAs($user);

        // Verificar que está autenticado
        $this->assertAuthenticated();

        // Logout
        $response = $this->post('/logout');

        // Verificar que está desautenticado
        $this->assertGuest();
        $response->assertRedirect('/');
    }

    /**
     * Test acceso a dashboard requiere autenticación
     */
    public function test_dashboard_requires_authentication(): void
    {
        // Intentar acceder a dashboard sin autenticarse
        $response = $this->get('/dashboard');

        // Debe redirigir a login
        $response->assertRedirect('/login');
    }

    /**
     * Test dashboard accesible cuando está autenticado
     */
    public function test_dashboard_accessible_when_authenticated(): void
    {
        // Crear y autenticar usuario
        $user = User::factory()->create(['role' => 'moderador']);
        $this->actingAs($user);

        // Acceder a dashboard
        $response = $this->get('/dashboard');

        // Debe devolver 200
        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }

    /**
     * Test registro de nuevo usuario
     */
    public function test_register_new_user(): void
    {
        $response = $this->post('/register', [
            'name' => 'Nuevo Moderador',
            'email' => 'nuevo@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Verificar que el usuario fue creado
        $this->assertDatabaseHas('users', [
            'email' => 'nuevo@test.com',
            'role' => 'moderador',
        ]);

        // Verificar que está autenticado
        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /**
     * Test validación en registro
     */
    public function test_register_validation(): void
    {
        // Intentar registro sin email
        $response = $this->post('/register', [
            'name' => 'Nuevo Moderador',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Debe redirigir con errores
        $response->assertSessionHasErrors('email');
    }
}
