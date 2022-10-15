<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class ValidFieldsFromModel implements InvokableRule
{
    public function __construct(
        protected Model $class,
    ) {}
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
        if (!in_array($value, $this->class->getTableColumns())) {
            $fail('The :attribute must be a attibute from ' . class_basename($this->class::class));
        }
    }
}
