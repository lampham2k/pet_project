<?php

namespace App\Http\Requests\Customer;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class PostCommentRequest extends FormRequest
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
            'comment' => [
                'required',
            ],
        ];

        $product = Product::query()->where('name', $this->product_name)->get();

        if (count($product)) {
            $rules['product_name'] = [
                'required'
            ];
        } else {
            return redirect()->back();
        }

        return $rules;
    }
}
