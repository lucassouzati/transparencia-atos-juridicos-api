<?php

namespace Database\Factories;

use App\Models\LegalAct;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LegalAct>
 */
class LegalActFactory extends Factory
{
    protected $model = LegalAct::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'act_date' => fake()->date(),
            'title' => fake()->word(),
            'type_id' => fake()->randomDigitNot(0),
            'description' => fake()->sentence(),
            'file' => UploadedFile::fake()->create('test.pdf'),
            'published' => 1,
        ];
    }
}
