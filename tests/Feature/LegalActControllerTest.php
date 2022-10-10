<?php

namespace Tests\Feature;

use App\Models\LegalAct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LegalActControllerTest extends TestCase
{
    public function test_storing_a_legal_act()
    {
        $response = $this->postJson('/api/legalacts',
            LegalAct::factory()->create()->toArray());

        $response->assertStatus(201);
    }

    public function test_updating_a_legal_act()
    {
        $legalact = LegalAct::first();
        $legalact->title = "teste 2";

        $response = $this->patchJson('/api/legalacts/'. $legalact->id,
            $legalact->toArray());

        $response->assertStatus(200);
    }

    public function test_deleting_a_legal_act()
    {
        $legalact = LegalAct::first();

        $response = $this->deleteJson('/api/legalacts/'. $legalact->id,
            $legalact->toArray());

        $response->assertStatus(204);
    }


}