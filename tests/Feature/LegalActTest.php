<?php

namespace Tests\Feature;

use Database\Seeders\LegalActSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LegalActTest extends TestCase
{
    use RefreshDatabase;

    public function test_legal_act_can_be_created()
    {
        $this->seed(LegalActSeeder::class);
        $this->assertDatabaseCount('legal_acts', 100);
    }
}
