<?php

namespace Tests\RequestFactories;

use Worksome\RequestFactories\RequestFactory;

class LoginFormRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'email' => $this->faker->email,
            'password' => $this->faker->password(8),
        ];
    }
}
