<?php

namespace Tests\Unit;

use App\Http\Requests\FilterLegalActsRequest;
use App\Models\LegalAct;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class FilterLegalActsRequestTest extends TestCase
{
   /**
     * @dataProvider provideValidData
     */
    public function testValidData(array $data)
    {
        $request = new FilterLegalActsRequest();
        $validator = Validator::make($data, $request->rules());
        $this->assertTrue($validator->passes());
    }

    public function provideValidData()
    {
        $legal_act = new LegalAct();
        return [
            [
                ['order_by' => Arr::random($legal_act->getFillable())]
            ],
        ];
    }

    /**
     * @dataProvider provideInvalidData
     */
    public function testInvalidData(array $data)
    {
        $request = new FilterLegalActsRequest();
        $validator = Validator::make($data, $request->rules());
        $this->assertFalse($validator->passes());
    }

    public function provideInvalidData()
    {
        $faker = \Faker\Factory::create();
        return [
            [
                ['order_by' => $faker->word]
            ],
        ];
    }
}
