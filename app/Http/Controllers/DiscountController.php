<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ResponseTrait;
use App\Models\Product;
use Illuminate\Support\Str;

class DiscountController extends Controller
{
    use ResponseTrait;

    public function products(Request $request)
    {
        try {
            //select2


            $product = Product::query()->select([
                'id',
                'name',
            ]);

            if ($request->has('q')) {

                $product->where('name', 'like', '%' . $request->get('q') . '%');
            }

            $data = $product->get();

            return $this->successResponse($data);
        } catch (\Throwable $th) {

            return $this->errorResponse();
        }
    }
}
