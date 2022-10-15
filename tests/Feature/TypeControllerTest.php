<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeControllerTest extends TestCase
{
    public function test_listing_types()
    {
        $response = $this->getJson(route('types.index'));
        $response->assertStatus(200);
    }

    public function test_showing_types()
    {
        $type = Type::factory()->create();
        $response = $this->getJson(route('types.show', [$type->id]));
        $response->assertStatus(200);
    }

    public function test_storing_a_type()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('types.store'), Type::factory()->create()->toArray());

        $response->assertStatus(201);
    }

    public function test_updating_a_type()
    {
        $user = User::factory()->create();

        $type = Type::inRandomOrder()->first();

        $type->title = "teste 2";

        $response = $this->actingAs($user)
            ->patchJson(route('types.update', [$type->id]), $type->toArray());

        $response->assertStatus(200);
    }

    public function test_deleting_a_type()
    {
        $user = User::factory()->create();
        $type = Type::inRandomOrder()->first();

        $response = $this->actingAs($user)
            ->deleteJson(route('types.destroy', [$type->id]));

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
            ->postJson(route('types.store'),
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
