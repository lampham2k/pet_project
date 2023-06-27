<?php

namespace App\Http\Requests\Discount;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
            ],
            'money_reduced' => [
                'numeric',
                'nullable',
            ],
            'percent_reduction' => [
                'numeric',
                'nullable',
            ],
            'start_date' => [
                'nullable',
                'date',
                'min:1',
                'before:end_date',
            ],
            'end_date' => [
                'nullable',
                'date',
                'min:1',
                'after:start_date',
            ],
        ];
    }
}
