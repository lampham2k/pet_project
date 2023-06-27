<?php

use App\Enums\CustomerRoleEnum;
use App\Enums\SystemCacheKeyEnum;
use App\Enums\UserRoleEnum;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Support\Str;
use App\Models\Type;
use Illuminate\Support\Arr;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use Carbon\Carbon;

if (!function_exists('user')) {
    function user(): ?object
    {
        return auth()->user();
    }
}

if (!function_exists('getRoleByValue')) {
    function getRoleByValue($value): ?string
    {
        return strtolower(UserRoleEnum::getKey($value));
    }
}
if (!function_exists('getArrWithUppercaseEnum')) {
    function getArrWithUppercaseEnum($arrEnum): ?array
    {
        $arr = [];
        $data = $arrEnum;

        foreach ($data as $key => $val) {
            $index = str::title(str_replace('_', ' ', $key));
            $arr[$index] = $val;

            $arr[$index] = $val;
        }

        return $arr;
    }
}

if (!function_exists('isSuperAdmin')) {
    function isSuperAdmin(): ?bool
    {
        return user() && user()->user_role === UserRoleEnum::SUPER_ADMIN;
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin(): ?bool
    {
        return user() && user()->user_role === UserRoleEnum::ADMIN;
    }
}

if (!function_exists('dateFormatAttributeYmd')) {
    function dateFormatAttributeYmd($date): ?string
    {
        if (is_null($date)) {
            return "";
        }
        return Carbon::parse($date)->format('Y-m-d');
    }
}

if (!function_exists('getAndCacheTypesExistInProducts')) {
    function getAndCacheTypesExistInProducts(): array
    {
        return cache()->remember(
            SystemCacheKeyEnum::TYPE,
            86400 * 30,
            function () {
                $types = Product::query()
                    ->with(['type'])->get();

                $arrTypes = [];
                foreach ($types as $type) {
                    $arrTypes[] = $type->type->name;
                }

                return $arrTypes;
            }
        );
    }
}

if (!function_exists('getAndCacheTypes')) {
    function getAndCacheTypes(): array
    {
        return cache()->remember(
            SystemCacheKeyEnum::TYPE,
            86400 * 30,
            function () {
                $types = Type::query()->get();

                $arrTypes = [];

                foreach ($types as $each) {
                    $arrTypes[$each->id] = $each->name;
                }

                return $arrTypes;
            }
        );
    }
}


if (!function_exists('getAndCacheSizes')) {
    function getAndCacheSizes(): array
    {
        return cache()->remember(
            SystemCacheKeyEnum::SIZE,
            86400 * 30,
            function () {
                $sizes = Size::query()->get();

                $arrSizes = [];

                foreach ($sizes as $each) {
                    $arrSizes[$each->id] = $each->size;
                }

                return $arrSizes;
            }
        );
    }
}


if (!function_exists('dataProductWithDiscount')) {
    function dataProductWithDiscount($id): object
    {
        $discountProductTable = Discount::query()
            ->addSelect('product_id')
            ->selectRaw('MAX(percent_reduction) as max_discount_percent')
            ->selectRaw('MAX(money_reduced) as max_discount_money')
            ->join('discount_product', 'discount_product.discount_id', 'discounts.id')
            ->groupBy('product_id');


        $data = Product::query()
            ->addSelect('products.*')
            ->addSelect('maxDiscountProductTable.max_discount_percent')
            ->addSelect('maxDiscountProductTable.max_discount_money')
            ->leftJoinSub($discountProductTable, 'maxDiscountProductTable', function ($join) {
                $join->on('maxDiscountProductTable.product_id', 'products.id');
            })
            ->find($id);

        return $data;
    }

    if (!function_exists('checkIdUserExistAndReturnRedirectBack')) {
        function checkIdUserExistAndReturnRedirectBack($idUser)
        {
            if (!isset($idUser)) {
                return redirect()->back();
            }
        }
    }

    if (!function_exists('getMyCart')) {
        function getMyCart($carts, $idUser)
        {
            $myCart = [];

            foreach ($carts as $index => $values) {
                foreach ($values as $keyIdUsers => $eachProducts) {
                    if ($idUser == $keyIdUsers) {
                        $myCart = $eachProducts;
                    }
                }
            }

            return $myCart;
        }
    }

    if (!function_exists('getMyArrAddress')) {
        function getMyArrAddress($arrAddress, $idUser)
        {
            $myArrAddress = [];

            foreach ($arrAddress as $index => $value) {
                foreach ($value as $id => $eachAddress) {
                    if ($id == $idUser) {
                        $myArrAddress = $eachAddress;
                    }
                }
            }

            return $myArrAddress;
        }
    }

    if (!function_exists('updateSessionAddress')) {
        function updateSessionAddress($arrAddress, $idUser, $myArrAddress, $request)
        {
            foreach ($arrAddress as $index => $value) {
                foreach ($value as $id => $eachValueAddress) {
                    if ($id == $idUser) {
                        $arrAddress[$index][$idUser]    = $myArrAddress;
                    } else {
                        $arrAddress[][$idUser]          = $myArrAddress;
                    }
                }
            }

            $request->session()->put('address', $arrAddress);
        }
    }

    if (!function_exists('getMyArrProductToPayFromSession')) {
        function getMyArrProductToPayFromSession($request, $idUser)
        {
            $arrProductToPay  = [];

            if (!is_null($request->session()->get('productToPay'))) {
                foreach ($request->session()->get('productToPay') as $index => $values) {
                    foreach ($values as $id => $each) {
                        if ($id == $idUser) {
                            $arrProductToPay = $request->session()->get('productToPay')[$index][$id];
                        }
                    }
                }
            }

            return $arrProductToPay;
        }
    }

    if (!function_exists('isOwner')) {
        function isOwner(): ?bool
        {
            return user() && user()->customer_role === CustomerRoleEnum::OWNER;
        }
    }

    if (!function_exists('getTimeComment')) {
        function getTimeComment($time): ?string
        {
            date_default_timezone_set('Asia/Ho_Chi_Minh');

            $created_at     = $time;

            $string = '';

            if ((int)date_format(new DateTime(), "Y") > (int)date('Y', strtotime($created_at))) {

                $string = (int)date_format(new DateTime(), "Y") - (int)date('Y', strtotime($created_at)) . ' years ago';
            } else {

                if ((int)date_format(new DateTime(), "m") > (int)date('m', strtotime($created_at))) {

                    $string = (int)date_format(new DateTime(), "m") - (int)date('m', strtotime($created_at)) . ' month ago';
                } else {

                    if ((int)date_format(new DateTime(), "d") > (int)date('d', strtotime($created_at))) {

                        $string = (int)date_format(new DateTime(), "d") - (int)date('d', strtotime($created_at)) . ' days ago';
                    } else {

                        if ((int)date_format(new DateTime(), "H") > (int)date('H', strtotime($created_at))) {

                            $string = (int)date_format(new DateTime(), "H") - (int)date('H', strtotime($created_at)) . ' hours ago';
                        } else {

                            if ((int)date_format(new DateTime(), "i") > (int)date('i', strtotime($created_at))) {

                                $string = (int)date_format(new DateTime(), "i") - (int)date('i', strtotime($created_at)) . ' minutes ago';
                            } else {

                                if ((int)date_format(new DateTime(), "s") > (int)date('s', strtotime($created_at))) {

                                    $string = (int)date_format(new DateTime(), "s") - (int)date('s', strtotime($created_at)) . ' seconds ago';
                                } else {

                                    $string = 'recently';
                                }
                            }
                        }
                    }
                }
            }

            return $string;
        }
    }
}
