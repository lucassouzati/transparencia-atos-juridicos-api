<?php

namespace Tests\Feature;

use App\Models\Subscription;
use App\Models\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriptionControllerTest extends TestCase
{
    public function test_store_subscription()
    {
        $user = User::factory()->create();
        $type = Type::inRandomOrder()->first();

        $response = $this->actingAs($user)
            ->postJson(route('subscription.store'), [
                'user_id' => $user->id,
                'type_id' => $type->id,
            ]);

        $response->assertStatus(201);
    }
    public function test_show_subscription()
    {
        $user = User::factory()
                    ->has(Subscription::factory()->count(3))
                    ->create();

        $subscription = $user->subscriptions()->inRandomOrder()->first();

        $response = $this->actingAs($user)
            ->getJson(route('subscription.show', [$subscription->id]));

        $response->assertStatus(200);
    }
    public function test_update_subscription()
    {
        $user = User::factory()
                    ->has(Subscription::factory()->count(3))
                    ->create();
        $type = Type::inRandomOrder()->first();
        $subscription = $user->subscriptions()->inRandomOrder()->first();

        $response = $this->actingAs($user)
            ->patchJson(route('subscription.update', [$subscription->id]), [
                'user_id' => $user->id,
                'type_id' => $type->id,
            ]);

        $response->assertStatus(200);
    }
    public function test_destroy_subscription()
    {
        $user = User::factory()
                    ->has(Subscription::factory()->count(3))
                    ->create();
        $subscription = $user->subscriptions()->inRandomOrder()->first();

        $response = $this->actingAs($user)
            ->deleteJson(route('subscription.destroy', [$subscription->id]));

        $response->assertStatus(204);
    }
    public function test_index_subscription()
    {
        $user = User::factory()
                    ->has(Subscription::factory()->count(3))
                    ->create();
        $type = Type::inRandomOrder()->first();

        $response = $this->actingAs($user)
            ->getJson(route('subscription.index'), [
                'user_id' => $user->id,
                'type_id' => $type->id,
            ]);

        $response->assertStatus(200);
    }
}
