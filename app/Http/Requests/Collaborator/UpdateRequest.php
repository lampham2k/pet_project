<?php

namespace App\Http\Requests\Collaborator;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\CollaboratorRoleEnum;
use App\Enums\CustomerRoleEnum;
use App\Models\Collaborator;
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
                'nullable',
                'date',
                'before:' . $CURRENT_DAY,
            ],
            'description' => [
                'string',
                'nullable',
            ],
            'role' => [
                Rule::in(CollaboratorRoleEnum::getValues()),
            ],
            'photo' => [
                'file',
                'nullable',
            ],
        ];

        if ($this->f0_id === "0") {
            $rules['f0_id'] = [
                'nullable'
            ];
        } elseif ($this->f0_id === $this->id) {
            return false;
        } else {
            $rules['f0_id'] = [
                Rule::in(Collaborator::query()->pluck('id')),
            ];
        }

        return $rules;
    }
}
