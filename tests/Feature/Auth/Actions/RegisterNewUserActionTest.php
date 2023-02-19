<?php

namespace Tests\Feature\Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterNewUserActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_success_user_created(): void
    {
        $this->assertDatabaseMissing('users', [
            'email' => 'testing@cutcode.ru',
        ]);

        $action = app(RegisterNewUserContract::class);

        $action(NewUserDTO::make('Test', 'testing@cutcode.ru', '1234567890'));

        $this->assertDatabaseHas('users', [
            'email' => 'testing@cutcode.ru',
        ]);
    }
}
