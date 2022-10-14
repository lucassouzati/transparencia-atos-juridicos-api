<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\LegalAct;

class LegalActControllerTest extends TestCase
{
    public function test_storing_a_legal_act()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->postJson('/api/legalacts',
            LegalAct::factory()->create()->toArray());

        $response->assertStatus(201);
    }

    public function test_updating_a_legal_act()
    {
        $user = User::factory()->create();

        $legalact = LegalAct::inRandomOrder()->first();

        $legalact->title = "teste 2";

        $response = $this->actingAs($user)
            ->patchJson('/api/legalacts/'. $legalact->id,
            $legalact->toArray());

        $response->assertStatus(200);
    }

    public function test_deleting_a_legal_act()
    {
        $user = User::factory()->create();
        $legalact = LegalAct::inRandomOrder()->first();

        $response = $this->actingAs($user)
            ->deleteJson('/api/legalacts/'. $legalact->id,
            $legalact->toArray());

        $response->assertStatus(204);
    }


}
