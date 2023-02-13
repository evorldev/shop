<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Listeners\SendEmailNewUserListener;
use Domain\Auth\Models\User;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_login_page_success()
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');

        // $user = UserFactory::new()->create([
        //     'email' => 'testing@cutcode.ru',
        // ]);

        // $this->actingAs($user)
        //     ->get('/login')
        //     ->assertRe
        //     ->assertSee('Вход в аккаунт')
        //     ->assertViewIs('auth.page');
    }

    /**
     * @test
     * @return void
     */
    public function it_register_page_success()
    {
        $this->get('/register')
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.register');
    }

    /**
     * @test
     * @return void
     */
    public function it_forgot_page_success()
    {
        $this->get('/forgot-password')
            ->assertOk()
            ->assertSee('Забыли пароль')
            ->assertViewIs('auth.forgot-password');
    }

    /**
     * @test
     * @return void
     */
    public function it_sign_in_success()
    {
        $password = 'password';

        $user = UserFactory::new()->create([
            'email' => 'testing@cutcode.ru',
            'password' => bcrypt($password),
        ]);

        $request = [
            'email' => $user->email,
            'password' => $password,
        ];

        $response = $this->post('/login', $request);

        $response->assertValid()
            ->assertRedirect('/');

        $this->assertAuthenticatedAs($user);

    }

    /**
     * @test
     * @return void
     */
    public function it_register_success()
    {
        Notification::fake();
        Event::fake();

        $request = [
            'name' => 'User',
            'email' => 'user@orlyanskiy.ru',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $this->assertDatabaseMissing('users', [
            'email' => $request['email'],
        ]);

        $response = $this->post('/register', $request);

        $response->assertValid();

        $this->assertDatabaseHas('users', [
            'email' => $request['email'],
        ]);

        $user = User::firstWhere('email', 'LIKE', $request['email']);

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        // Notification::assertSentTo($user, NewUserNotification::class);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect('/');
    }

    /**
     * @test
     * @return void
     */
    public function it_logout_success()
    {
        $user = UserFactory::new()->create([
            'email' => 'testing@cutcode.ru',
        ]);

        $this->actingAs($user)
            ->delete('/logout');

        $this->assertGuest();
    }

    /**
     * @test
     * @return void
     */
    public function it_reset_password_success()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     * @return void
     */
    public function it_github_success()
    {
        $this->assertTrue(true);
    }
}
