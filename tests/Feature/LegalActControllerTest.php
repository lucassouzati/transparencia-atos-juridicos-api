<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\LegalAct;
use App\Models\Subscription;
use Illuminate\Http\UploadedFile;
use App\Http\Resources\LegalActResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LegalActControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_storing_a_legal_act()
    {
        $user = User::factory()->create();
        // dd(new LegalActResource(LegalAct::factory()->create()));
        $legalact = LegalAct::factory()->make();
        $response = $this->actingAs($user)
            ->postJson(route('legalacts.store'),
            [
                'act_date' => $legalact->act_date,
                'title' => $legalact->title,
                'description' => $legalact->description,
                'type_id' => $legalact->type_id,
                'published' => $legalact->published,
                'file' => UploadedFile::fake()->create('test.pdf'),
            ]);

        $response->assertStatus(201);
    }

    public function test_updating_a_legal_act()
    {
        $user = User::factory()->create();

        $legalact = LegalAct::factory()->create();

        $legalact->title = "teste 2";

        $response = $this->actingAs($user)
            ->patchJson(route('legalacts.update',  [$legalact->id]), [
                'act_date' => $legalact->act_date,
                'title' => $legalact->title,
                'description' => $legalact->description,
                'type_id' => $legalact->type_id,
                'published' => $legalact->published,
                ]
            );

        $response->assertStatus(200);
    }

    public function test_deleting_a_legal_act()
    {
        $user = User::factory()->create();
        $legalact = LegalAct::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('legalacts.destroy', [$legalact->id]),
            $legalact->toArray());

        $response->assertStatus(204);
    }

    public function test_showing_a_legal_act()
    {
        $user = User::factory()->create();
        $legalact = LegalAct::factory()->create();

        $response = $this->actingAs($user)
            ->getJson(route('legalacts.show', [$legalact->id]),
            $legalact->toArray());

        $response->assertStatus(200);
    }

    /**
     * @test
     * @dataProvider legalActInvalidFields
     */
    public function a_user_cant_create_a_legal_act_with_invalid_fields($invalidData, $invalidFields)
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->postJson(route('legalacts.store'),
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

    /**
     * @test
     * @dataProvider filtersLegalActIndex
     */
    public function can_use_filters_in_legal_act_index($filterExamples, $expectedResults)
    {
        $response = $this->getJson(route('legalacts.index', $filterExamples));
        $response->assertStatus($expectedResults);
    }

    public function filtersLegalActIndex()
    {
        return [
            'withAllParameters' =>
            [
                [
                    'title' => "teste",
                    'description' => "teste teste",
                    'type_id' => 1,
                    'start_act_date' => '2022-01-01',
                    'end_act_date' => '2022-01-01',
                    'paginate' => 100,
                    'order_by' => 'created_at',
                ],
                200
            ],
            'withoutEndActDate' =>
            [
                [
                    'title' => "teste",
                    'description' => 'teste teste',
                    'type_id' => 1,
                    'start_act_date' => '2022-01-01',
                    'paginate' => 100,
                    'order_by' => 'created_at',
                ],
                200
            ],
            'withoutStartActDate' =>
            [
                [
                    'title' => "teste",
                    'description' => 'teste teste',
                    'type_id' => 1,
                    'end_act_date' => '2022-01-01',
                    'paginate' => 100,
                    'order_by' => 'created_at',
                ],
                200
            ],
            'withoutPaginate' =>
            [
                [
                    'title' => "teste",
                    'description' => 'teste teste',
                    'type_id' => 1,
                    'start_act_date' => '2022-01-01',
                    'end_act_date' => '2022-01-01',
                    'order_by' => 'created_at',
                ],
                200
            ],
            'withoutOrderBy' =>
            [
                [
                    'title' => "teste",
                    'description' => 'teste teste',
                    'type_id' => 1,
                    'start_act_date' => '2022-01-01',
                    'end_act_date' => '2022-01-01',
                    'paginate' => 100,
                ],
                200
            ],
        ];
    }

    public function test_if_a_user_not_authorized_cannot_see_a_published_legal_act()
    {
        $legalact = LegalAct::factory()->create(['published' => 0]);
        $user = User::create([ 'name' => "Sr. teste",
        'email' => "teste@teste.com",
        'profile' => "citizen",
        'password' =>  'teste1234']);
        $response = $this->actingAs($user)->getJson(route('legalacts.show', [$legalact->id]));
        $response->assertStatus(404);
    }

    public function test_if_a_user_not_authenticated_cannot_see_a_published_legal_act()
    {
        $legalact = LegalAct::factory()->create(['published' => 0]);
        $response = $this->getJson(route('legalacts.show', [$legalact->id]));
        $response->assertStatus(404);
    }

    public function test_storing_a_legal_act_published_with_users_subscripted()
    {
        $user = User::factory()->create();
        $legalact = LegalAct::factory()->make();
        $subscription = Subscription::create(['user_id'=> $user->id, 'type_id'=>$legalact->type->id]);

        $response = $this->actingAs($user)
            ->postJson(route('legalacts.store'),
            [
                'act_date' => $legalact->act_date,
                'title' => $legalact->title,
                'description' => $legalact->description,
                'type_id' => $legalact->type_id,
                'published' => 1,
                'file' => UploadedFile::fake()->create('test.pdf'),
            ]);

        $response->assertStatus(201);
    }
}
