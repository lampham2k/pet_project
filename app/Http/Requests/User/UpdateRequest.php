<?php

namespace App\Http\Requests\User;

use App\Enums\CustomerRoleEnum;
use App\Enums\UserRoleEnum;
use App\Models\Collaborator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
        $CURRENT_DAY = date('Y-m-d');

        $rules = [
            'name' => [
                'required',
                'string',
            ],
            'email' => [
                'required',
                'email',
            ],
            'gender' => [
                'boolean',
            ],
            'phone_number' => [
                'numeric',
                'nullable',
            ],
            'address' => [
                'string',
                'nullable',
            ],
            'birthday' => [
                'date',
                'before:' . $CURRENT_DAY,
            ],
            'description' => [
                'string',
                'nullable',
            ],
            'customer_role' => [
                Rule::in(CustomerRoleEnum::getValues()),
            ],
            'user_role' => [
                Rule::in(UserRoleEnum::getValues()),
            ],
            'photo' => [
                'file',
            ],
        ];

        if ($this->collaborator_id === "0") {
            $rules['collaborator_id'] = [
                'nullable'
            ];
        } else {
            $rules['collaborator_id'] = [
                Rule::in(Collaborator::query()->pluck('id')),
                'nullable',
            ];
        }

        return $rules;
    }
}
