<?php

namespace App\Http\Requests\Customer;

use App\Enums\CustomerRoleEnum;
use App\Models\UserCommentProduct;
use Illuminate\Foundation\Http\FormRequest;

class ReplyCommentRequest extends FormRequest
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
        $rules = [
            'users_comment_product_id' => [
                'required',
            ],
        ];

        $comment = UserCommentProduct::query()->find((int)$this->users_comment_product_id);

        if (isset($comment) and user()->customer_role == CustomerRoleEnum::OWNER) {
            $rules['comment'] = [
                'required'
            ];
        } else {
            return redirect()->back();
        }

        return $rules;
    }
}
