<?php

namespace App\Rules;

use App\Models\LegalAct;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Arr;

class ValidFieldsFromLegalAct implements InvokableRule
{
    private LegalAct $legalAct;

    public function __construct()
    {
        $this->legalAct = new LegalAct();
    }
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (!in_array($value, $this->legalAct->getFillable())) {
            $fail('The :attribute must be a attibute from LegalAct.');
        }
    }
}
