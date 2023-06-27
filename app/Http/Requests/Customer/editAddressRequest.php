<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class editAddressRequest extends FormRequest
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
            'id' => [
                'required',
            ],
            'full-name' => [
                'required',
            ],
            'phone-number' => [
                'required',
                'numeric',
            ],
            'city' => [
                'required',
            ],
            'district' => [
                'required',
            ],
            'street' => [
                'required',
            ],
            'default' => [
                'nullable',
            ],
        ];
    }
}
