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
            $products = Product::all();
            $data = $products->filter(function ($each) use ($request) {
                if ($request->has('q')) {
                    return Str::contains(strtolower($each->name), $request->get('q'));
                }
                return true;
            });
            return $this->successResponse($data);
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }
}
