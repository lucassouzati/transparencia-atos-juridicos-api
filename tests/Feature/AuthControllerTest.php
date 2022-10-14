<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson(route('users.register'),
            ['name' => fake()->name(),
            'email' => fake()->unique()->email(),
            'password' => fake()->password()]);

        $response->assertStatus(201);
    }

    public function test_user_can_login()
    {
        $user = User::create(['name' => "Sr. teste",
        'email' => "teste@teste.com",
        'password' =>  'teste1234']);

        $response = $this->postJson(route('users.login'),
            ['email' => $user->email,
            'password' => "teste1234"]);

        $response->assertStatus(200);
    }

    public function test_user_cant_login_with_invalid_credentials()
    {

        $response = $this->postJson(route('users.login'),
            ['email' => fake()->email(),
            'password' => fake()->password()
        ]);

        $response->assertStatus(401);
    }

    /**
     * @test
     * @dataProvider registerInvalidFields
     */
    public function a_user_cant_register_with_invalid_fields($invalidData, $invalidFields)
    {
        $response = $this->postJson(route('users.register'),
            $invalidData);

        $response->assertInvalid($invalidFields)
            ->assertStatus(422);
    }

    public function registerInvalidFields()
    {
        return [
            'withoutEmail' => [
                ['name' => 'teste', 'password' => 'teste1234'],
                ['email']
            ],
            'withInvalidEmail' => [
                ['email' => 'teste', 'name' => 'teste', 'password' => 'teste1234'],
                ['email']
            ],
            'withoutName' => [
                ['email' => 'teste@teste.com', 'password' => 'teste1234'],
                ['name']
            ],
            'withoutPassword' => [
                ['email' => 'teste@teste.com', 'name' => 'teste'],
                ['password']
            ],
        ];
    }


        public function test_a_user_cant_register_with_email_already_in_use()
        {
            $user = User::create(['name' => "Sr. teste",
            'email' => "teste@teste.com",
            'password' =>  'teste1234']);

            $response = $this->postJson(route('users.register'), [
                'name' => "Sr. teste",
                'email' => "teste@teste.com",
                'password' =>  'teste1234'
            ]);

            $response->assertInvalid('email')
                ->assertStatus(422);
        }

}
