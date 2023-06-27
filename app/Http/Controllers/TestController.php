<?php

namespace App\Http\Controllers;

use App\Enums\CollaboratorRoleEnum;
use App\Enums\CustomerRoleEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\UserRoleEnum;
use App\Models\Collaborator;
use App\Models\Config;
use App\Models\Discount;
use App\Models\Manufacturer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stringable;
use StringBackedEnum;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function test(Request $request)
    {

        // dd(
        //     $order = Order::query()
        //         ->selectRaw('products.id  as product_id')
        //         ->selectRaw('products.name  as product_name')
        //         ->selectRaw('sizes.size  as product_size')
        //         ->selectRaw("date_format(orders.created_at, '%d-%m-%Y') as 'day'")
        //         ->selectRaw("sum(order_product.quantity) as 'number_of_products_sold'")
        //         ->join('order_product', 'orders.id', 'order_product.order_id')
        //         ->join('products', 'products.id', 'order_product.product_id')
        //         ->join('sizes', 'sizes.id', 'products.size_id')
        //         ->whereRaw("DATE(orders.created_at) >= CURDATE() - INTERVAL 30 DAY and DATE(orders.created_at) <= CURDATE()")
        //         ->whereRaw("orders.status = 5")
        //         ->groupBy('products.id')
        //         ->groupBy('orders.created_at')
        //         ->toSql()
        // );
        // date_default_timezone_set('Asia/Ho_Chi_Minh');
        // date_format(new DateTime(), "Y-m-d H:i:s");

        // $response = new HttpResponse('adsfdsafasdfsdf');

        // $response->withCookie(cookie('lamPham797sdfsdf9', 'vi', 60000));

        // $str = Crypt::decryptString($request->cookie('locale'));

        // $arr = explode("|", $str);
        // dd($arr);

        // return $response;

        // return $response;

        // dd($request->cookie('locale'));

        // dd(Crypt::decryptString($request->cookie('locale')));
        // Cookie::queue(Cookie::forget('lamPham999'));
        // $discount = Discount::query()->with('product')->find(2);

        // dd($discount);

        // return $discount;
        // return $discount->pivot->product_id;
        // foreach ($discount->product as $each) {
        //     dd($each->pivot->id);
        // }

        // add value to pivot table;
        // $discount = Discount::find(2);
        // $discount->Product()->attach(17);

        // $discountProductTable = Discount::query()
        //     ->addSelect('product_id')
        //     ->selectRaw('MAX(percent_reduction) as max_discount_percent')
        //     ->selectRaw('MAX(money_reduced) as max_discount_money')
        //     ->join('discount_product', 'discount_product.discount_id', 'discounts.id')
        //     ->groupBy('product_id');

        // $data = Product::query()
        //     ->addSelect('products.*')
        //     ->addSelect('maxDiscountProductTable.max_discount_percent')
        //     ->addSelect('maxDiscountProductTable.max_discount_money')
        //     ->joinSub($discountProductTProductTable.product_id', 'products.id');
        //     })able, 'maxDiscountProductTable', function ($join) {
        //         $join->on('maxDiscount
        //     ->get();

        // return $data;

        // $productToPayOfIdUser   = getMyArrProductToPayFromSession($request, 18);
        // $arrOrderStatusEnum = OrderStatusEnum::getArrWithStringToLower();
        // dd($arrOrderStatusEnum);

        // $last_month = date('m', strtotime(" -1 month"));
        // dd($last_month);

        // dd($productToPayOfIdUser);
        // $request->session()->put('user', ['first_name' => 'lam', 'last_name' => 'pham']);
        // dd(session()->all());
        // dd($request->session()->get('carts'));
        // $request->session()->forget('cards')[0][14]['quantity'];
        $request->session()->flush();
        // dd(CollaboratorRoleEnum::getValues());
        // $request->session()->put('test', ['id2' => ['name' => 'lam']]);
        // $carts = $request->session()->get('cards');
        // dd($carts[0]);
        // $carts[2][16]['quantity']++;
        // $request->session()->put('cards', $carts);
        // $carts = $request->session()->get('cards');
        // array_splice($carts, 0, 1);

        // $request->session()->put('cards', $carts);


        // dd($request->session()->get('cards'));
        // // dd($carts[0]);
        // foreach ($carts as $key => $value) {
        //     foreach ($carts[$key] as $id => $value) {
        //         if ($id == 16) {
        //             $carts[$key][$id]['quantity']++;
        //             $request->session()->put('cards', $carts);
        //         }
        //     }
        // }
        // $input = array("red", "green", "blue", "yellow");
        // array_splice($input, 0, 1);
        // dd($input);
        // $value = '14';
        // $product = Product::find((int)($value));
        // dd($product->id);
        // $request->session()->push('address', [
        //     'full_name'     => 'Pham Quoc Lam',
        //     'phone_number'  => '0981313944',
        //     'city'          => 'Tp-Hcm',
        //     'district'      => 'Go Vap',
        //     'ward'          => 'Phuong 15',
        //     'street_name'   => 'Le Duc Tho',
        //     'default'       => 1,
        // ]);
        // $arrAddress = $request->session()->get('address');
        // foreach ($arrAddress as $index => $each) {
        //     dd($each['full_name']);
        // }
        // $arrAddress = $request->session()->get('address');
        // foreach ($arrAddress as $index => $each) {
        //     dd($each['default']);
        // }
        // dd($arrAddress[0]['default']);
        // $order = Order::find(1);
        // $order->Product()->attach(14, ['quantity' => 14, 'price' => 15]);
        // Auth::logout();

        // $a = [];

        // if (empty($a)) {
        //     dd(1);
        // }

        // dd(2);

        // dd(UserRoleEnum::getArrWithStringToLower());
    }
}
