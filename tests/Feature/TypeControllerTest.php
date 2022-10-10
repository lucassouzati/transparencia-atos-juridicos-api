<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeControllerTest extends TestCase
{
    public function test_storing_a_legal_act()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/types', Type::factory()->create()->toArray());

        $response->assertStatus(201);
    }

    public function test_updating_a_legal_act()
    {
        $user = User::factory()->create();

        $type = Type::factory()
                        ->create();

        $type->title = "teste 2";

        $response = $this->actingAs($user)
            ->patchJson('/api/types/'. $type->id, $type->toArray());

        $response->assertStatus(200);
    }

}
