<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\LegalAct;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LegalActControllerTest extends TestCase
{
    use RefreshDatabase;

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

        $legalact = LegalAct::factory()->create();

        $legalact->title = "teste 2";

        $response = $this->actingAs($user)
            ->patchJson('/api/legalacts/'. $legalact->id,
            $legalact->toArray());

        $response->assertStatus(200);
    }

    public function test_deleting_a_legal_act()
    {
        $user = User::factory()->create();
        $legalact = LegalAct::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson('/api/legalacts/'. $legalact->id,
            $legalact->toArray());

        $response->assertStatus(204);
    }

    /**
     * @test
     * @dataProvider legalActInvalidFields
     */
    public function a_user_cant_create_a_legal_act_with_invalid_fields($invalidData, $invalidFields)
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->postJson('/api/legalacts',
            $invalidData);

        $response->assertInvalid($invalidFields)
            ->assertStatus(422);
    }

    public function legalActInvalidFields()
    {
        return [
            'withoutActDate'=> [
                ['title' => 'teste', 'type_id'=>1, 'description' =>'teste', 'published' => 1],
                ['act_date']
            ],
            'withInvalidActDate'=>
            [
                ['act_date' => 'invalid data', 'title' => 'teste', 'type_id'=>1, 'description' =>'teste', 'published' => 1],
                ['act_date']
            ],
            'withoutTitle'=>
            [
                ['act_date' => '2022-01-01', 'type_id'=>'teste', 'description' =>'teste', 'published' => 1],
                ['title']
            ],
            'withoutTypeId'=>
            [
                ['act_date' => '2022-01-01', 'title' => 'teste', 'description' =>'teste', 'published' => 1],
                ['type_id']
            ],
            'withInvalidTypeId'=>
            [
                ['act_date' => '2022-01-01', 'title' => 'teste', 'type_id'=>'teste', 'description' =>'teste', 'published' => 1],
                ['type_id']
            ],
            'withoutDescription'=>
            [
                ['act_date' => '2022-01-01', 'title' => 'teste', 'published' => 1],
                ['description']
            ],
            'withoutPublished'=>
            [
                ['act_date' => '2022-01-01', 'title' => 'teste', 'type_id'=>1, 'description' =>'teste'],
                ['published']
            ],
            'withInvalidPublished'=>
            [
                ['act_date' => '2022-01-01', 'title' => 'teste', 'type_id'=>1, 'description' =>'teste', 'published' => 'verdadeiro'],
                ['published']
            ],
        ];
    }


}
