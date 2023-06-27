<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CardsRequest extends FormRequest
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
        $rules =  [
            'name' => [
                'required',
            ],
            'size_id' => [
                'required',
                'numeric',
            ],
        ];

        if ((int)$this->quantity > 0) {
            $rules['quantity'] = [
                'required',
                'numeric',
            ];
        } else {
            return redirect()->back();
        }

        return $rules;
    }
}
