<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeControllerTest extends TestCase
{
    public function test_storing_a_type()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/types', Type::factory()->create()->toArray());

        $response->assertStatus(201);
    }

    public function test_updating_a_type()
    {
        $user = User::factory()->create();

        $type = Type::inRandomOrder()->first();

        $type->title = "teste 2";

        $response = $this->actingAs($user)
            ->patchJson('/api/types/'. $type->id, $type->toArray());

        $response->assertStatus(200);
    }

    public function test_deleting_a_type()
    {
        $user = User::factory()->create();
        $type = Type::inRandomOrder()->first();

        $response = $this->actingAs($user)
            ->deleteJson('/api/types/'. $type->id,
            $type->toArray());

        $response->assertStatus(204);
    }

     /**
     * @test
     * @dataProvider legalActInvalidFields
     */
    public function a_user_cant_create_a_type_with_invalid_fields($invalidData, $invalidFields)
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->postJson('/api/types',
            $invalidData);

        $response->assertInvalid($invalidFields)
            ->assertStatus(422);
    }

    public function legalActInvalidFields()
    {
        return [
            'withoutName'=> [
                ['description' =>'teste'],
                ['name']
            ],
            'withoutDescription'=> [
                ['name' =>'teste'],
                ['description']
            ],
        ];
    }
}
