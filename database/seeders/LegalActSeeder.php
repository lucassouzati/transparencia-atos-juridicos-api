<?php

namespace Database\Seeders;

use App\Models\LegalAct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LegalActSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LegalAct::factory()
            ->count(100)
            ->create();
    }
}
