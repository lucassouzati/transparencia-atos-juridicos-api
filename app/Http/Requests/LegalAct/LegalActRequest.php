<?php

namespace App\Http\Requests\LegalAct;

use Illuminate\Foundation\Http\FormRequest;

class LegalActRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'act_date' =>'required|date',
            'title' => 'required',
            'type_id'=>'required|integer',
            'description' =>'required',
            'published' => 'required|boolean'
        ];
    }

}
