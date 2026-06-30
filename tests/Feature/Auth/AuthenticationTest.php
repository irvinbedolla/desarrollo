<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        // CORRECCIÓN: La vista del login ahora está en la raíz '/'
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password') // Aseguramos que la contraseña esté encriptada para el test
        ]);

        // Mantenemos el POST a '/login' ya que en tus rutas quedó configurado así
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        
        // Verifica que apunte al HOME (en tu caso redirige a 'home' o 'agenda')
        $response->assertRedirect('/home'); 
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        // Intento fallido de inicio de sesión
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}