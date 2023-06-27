<?php

namespace App\Http\Controllers\Customer;

use App\Enums\CustomerRoleEnum;
use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Customer\addNewAddressRequest;
use App\Http\Requests\Customer\CardsRequest;
use App\Http\Requests\Customer\CheckoutRequest;
use App\Http\Requests\Customer\editAddressRequest;
use App\Http\Requests\Customer\PlaceOrderRequest;
use App\Http\Requests\Customer\PostCommentRequest;
use App\Http\Requests\Customer\ReplyCommentRequest;
use App\Http\Requests\Customer\UpdateQuantityRequest;
use App\Models\Config;
use App\Models\Discount;
use App\Models\Manufacturer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\UserCommentProduct;
use App\Models\UserReplyComment;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use SebastianBergmann\CodeUnit\FunctionUnit;
use Illuminate\Support\Facades\View;
use PhpParser\Builder\Use_;

class HomepageController extends Controller
{
    use ResponseTrait;

    private int $idUser;
    private array $sessionCarts;
    private array $sessionAddress;

    public function __construct(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $this->idUser       = user()->id ?? null;

        $this->sessionCarts = $request->session()->get('carts') ?? [];

        $this->sessionAddress = $request->session()->get('address') ?? [];

        View::share('idUser', $this->idUser);
    }

    public function index()
    {
        return view('layout_frontpage.section');
    }

    public function products(Request $request)
    {
        $configs                = Config::getAndCache(0);
        $minPrice               = $request->get('min_price', $configs['min_price']);
        $maxPrice               = $request->get('max_price', $configs['max_price']);
        $types                  = getAndCacheTypes();
        $arrTypeIdFilters       = $request->get('types') ?? [];
        $arrManufacturerFilters = $request->get('manufacturers') ?? [];
        $manufacturers          = Manufacturer::query()->select([
            'id',
            'name',
        ])->get();

        $discount = $request->get('discount') ?? null;

        $filters = [];

        if ($request->has('min_price')) {
            $filters['min_price'] = $minPrice;
        }

        if ($request->has('max_price')) {
            $filters['max_price'] = $maxPrice;
        }

        if ($request->has('types')) {
            $filters['types'] = $arrTypeIdFilters;
        }

        if ($request->has('manufacturers')) {
            $filters['manufacturers'] = $arrManufacturerFilters;
        }

        if ($request->has('discount')) {
            $filters['discount'] = $discount;
        }

        if ($request->products == 'discounts') {
            $discount = $request->products;
            $filters['discount'] = $discount;
        }

        if ($request->products != "discounts" and $request->products != "all") {

            $filter_product_name = $request->products;

            if (!empty($filter_product_name)) {
                $filters['product_name'] = $filter_product_name;
            }
        }

        $data = Product::query()->indexProducts($filters)->paginate(6);

        $arrDataAllNameDistinct = [];

        $arrDataAllIdDistinct   = [];

        foreach ($data as $each) {

            if (!in_array($each->name, $arrDataAllNameDistinct)) {

                $arrDataAllNameDistinct[]   = $each->name;

                $arrDataAllIdDistinct[]     = $each->id;
            }
        }

        return view('layout_frontpage.products', [
            'data'                          =>  $data,
            'minPrice'                      =>  $minPrice,
            'maxPrice'                      =>  $maxPrice,
            'configs'                       =>  $configs,
            'types'                         =>  $types,
            'arrTypeIdFilters'              =>  $arrTypeIdFilters,
            'manufacturers'                 =>  $manufacturers,
            'arrManufacturerFilters'        =>  $arrManufacturerFilters,
            'discount'                      =>  $discount,
            'arrDataAllIdDistinct'          =>  $arrDataAllIdDistinct,
        ]);
    }

    public function product($id)
    {
        checkIdUserExistAndReturnRedirectBack($this->idUser);

        $data = dataProductWithDiscount($id);

        $datas = Product::query()->with([
            'size' => function ($q) {
                return $q->select([
                    'id',
                    'size',
                ]);
            },
        ])->where('name', $data->name)->get();

        // $comments = UserReplyComment::query()->with([
        //     'user' => function ($q) {
        //         return $q->select([
        //             'id',
        //             'name',
        //             'photo',
        //         ]);
        //     },
        //     'userCommentProducts' => function ($q) {
        //         return $q->select([
        //             'id',
        //             'product_name',
        //             'comment',
        //         ]);
        //     },
        // ]);

        $comments = UserCommentProduct::query()
            ->selectRaw('user_comment_products.*')
            ->selectRaw('user_reply_comments.comment  as user_reply_comment')
            ->selectRaw('user_reply_comments.created_at  as user_reply_comment_created_at')
            ->selectRaw('user_reply_comments.user_name_reply  as user_name_reply')
            ->selectRaw('user_reply_comments.user_photo_reply  as user_photo_reply')
            ->selectRaw('users.name  as user_name')
            ->selectRaw('users.photo  as user_photo')
            ->leftJoin('user_reply_comments', function ($join) {
                $join->on('user_comment_products.id', '=', 'user_reply_comments.users_comment_product_id');
            })
            ->join('users', 'user_comment_products.user_id', 'users.id');

        $user = User::query()->find($this->idUser);

        $userCommentProduct = UserCommentProduct::query()
            ->where('user_id', $this->idUser)
            ->where('product_name', $data->name)->get();

        $allow = false;

        if (user()->customer_role == CustomerRoleEnum::OWNER or !count($userCommentProduct)) {
            $allow = true;
        }

        return view('layout_frontpage.product', [
            'data'      => $data,
            'datas'     => $datas,
            'comments'  => $comments->where('product_name', $data->name)->paginate(5),
            'avatar'    => $user->photo,
            'allow'     => $allow,
            'totalComment'     => $comments->get()->count(),
        ]);
    }

    public function addToCards(CardsRequest $request)
    {
        try {

            checkIdUserExistAndReturnRedirectBack($this->idUser);

            $arr = $request->validated();

            $carts = $this->sessionCarts;

            $product = Product::query()->with([
                'size' => function ($q) {
                    return $q->select([
                        'id',
                        'size',
                    ]);
                },
            ])->where('name', $arr['name'])->where('size_id', (int)($arr['size_id']))->get();

            if (!isset($product)) {
                return redirect()->back();
            }

            $idUserInCarts = [];

            foreach ($product as $each) {

                $productWithDiscount = dataProductWithDiscount($each->id);

                if (isset($productWithDiscount->max_discount_percent)) {

                    $price = $productWithDiscount->price_new;
                } else {

                    $price = $each->price;
                }

                $amount = (int)$arr['quantity'] * $price;

                if (empty($carts)) {
                    $request->session()->push('carts', [$this->idUser => [$each->id => [
                        'name_product'      => $each->name,
                        'size'              => $each->size->size,
                        'amount'            => $amount,
                        'photo_product'     => $each->photo,
                        'price'             => $price,
                        'quantity'          => (int)$arr['quantity']
                    ]]]);
                } else {

                    foreach ($carts as $index => $eachValue) {
                        foreach ($eachValue as $idUser => $eachProduct) {
                            $idUserInCarts[] = $idUser;
                        }
                    }

                    foreach ($carts as $index => $eachValue) {
                        if (!in_array($this->idUser, $idUserInCarts)) {
                            $carts[][$this->idUser][$each->id] = [
                                'name_product'      => $each->name,
                                'size'              => $each->size->size,
                                'amount'            => $amount,
                                'photo_product'     => $each->photo,
                                'price'             => $price,
                                'quantity'          => (int)$arr['quantity']
                            ];
                        } else {
                            foreach ($carts[$index] as $idUser => $eachProduct) {
                                if ($idUser == $this->idUser) {
                                    if (empty($carts[$index][$idUser][$each->id])) {
                                        $carts[$index][$idUser][$each->id] = [
                                            'name_product'      => $each->name,
                                            'size'              => $each->size->size,
                                            'amount'            => $amount,
                                            'photo_product'     => $each->photo,
                                            'price'             => $price,
                                            'quantity'          => (int)$arr['quantity']
                                        ];
                                    } else {
                                        foreach ($carts[$index][$idUser] as $idProduct => $eachValueProduct) {
                                            if ($each->id == $idProduct) {
                                                $carts[$index][$idUser][$idProduct]['quantity'] += (int)$arr['quantity'];
                                                $carts[$index][$idUser][$idProduct]['amount'] += $amount;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $request->session()->put('carts', $carts);
                }
            }

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }

    public function carts(Request $request)
    {
        $carts = $this->sessionCarts;

        $total = 0;

        $myCart = getMyCart($this->sessionCarts, $this->idUser);

        foreach ($myCart as $idProduct => $eachValueProduct) {
            $total += $eachValueProduct['amount'];
        }

        return view('layout_frontpage.carts', [
            'myCart'    =>  $myCart,
            'total'     =>  $total,
        ]);
    }

    public function updateQuantity(UpdateQuantityRequest $request)
    {
        $idProductRequest = (int)$request->get('id');

        $product = Product::find($idProductRequest);

        if (!isset($product)) {
            return redirect()->back();
        }

        $carts = $this->sessionCarts;

        $myCart = getMyCart($this->sessionCarts, $this->idUser);

        foreach ($myCart as $idProduct => $eachValueProduct) {
            if ($idProductRequest == $idProduct) {
                if ($request->get('type') == 0) {

                    $myCart[$idProduct]['quantity']--;

                    $myCart[$idProduct]['amount'] -= $myCart[$idProduct]['price'];

                    if ($myCart[$idProduct]['quantity'] == 0) {

                        unset($myCart[$idProduct]);
                    }
                } else {
                    $myCart[$idProduct]['quantity']++;

                    $myCart[$idProduct]['amount'] += $myCart[$idProduct]['price'];
                }
            }
        }

        foreach ($carts as $index => $values) {
            foreach ($values as $idUser => $products) {
                if ($idUser == $this->idUser) {

                    $carts[$index][$idUser] = $myCart;
                }
            }
        }

        $request->session()->put('carts', $carts);

        return $myCart;
    }

    public function checkout(CheckoutRequest $request)
    {
        $arrIdProductCheckout   = [];
        $arrAddress             = $this->sessionAddress;
        $arrIdRequest           = $request->get('arrId');
        $total                  = 0;
        $addressDefault         = [];
        $myCart                 = getMyCart($this->sessionCarts, $this->idUser);

        foreach ($arrIdRequest as $index => $value) {

            $product = Product::find((int)($value));

            if (isset($product)) {

                $arrIdProductCheckout[] = $product->id;
            }
        }

        foreach ($myCart as $idProduct => $products) {
            if (in_array($idProduct, $arrIdProductCheckout)) {
                $total += $products['amount'];
            }
        }

        if (!empty($arrAddress)) {

            $myArrAddress = getMyArrAddress($arrAddress, $this->idUser);

            if (isset($myArrAddress)) {
                foreach ($myArrAddress as $idAddress => $value) {
                    if ($value['default'] == 1) {
                        $addressDefault['id']               = (int)$idAddress;
                        $addressDefault['full_name']        = $value['full_name'];
                        $addressDefault['phone_number']     = $value['phone_number'];
                        $addressDefault['city']             = $value['city'];
                        $addressDefault['district']         = $value['district'];
                        $addressDefault['street']           = $value['street'];
                        $addressDefault['default']          = $value['default'];
                    }
                }
            }
        }

        return view('layout_frontpage.checkout', [
            'arrIdProductCheckout'      =>  $arrIdProductCheckout,
            'myCart'                    =>  $myCart,
            'total'                     =>  $total,
            'myArrAddress'              =>  $myArrAddress ?? [],
            'addressDefault'            =>  $addressDefault ?? [],
        ]);
    }

    public function addNewAddress(addNewAddressRequest $request)
    {
        try {

            $arrInfoAddressUser = $request->validated();

            $arrAddress = $this->sessionAddress;

            $arrIdAddress = [];

            function putNewAddressToSession($default, $idAddress, $arrAddress, $arrInfoAddressUser, $thisIdUser, $request, $myArrAddress)
            {
                $myArrAddress[$idAddress] = [
                    'full_name'     => $arrInfoAddressUser['full-name'],
                    'phone_number'  => $arrInfoAddressUser['phone-number'],
                    'city'          => $arrInfoAddressUser['city'],
                    'district'      => $arrInfoAddressUser['district'],
                    'street'        => $arrInfoAddressUser['street'],
                    'default'       => $default,
                ];

                updateSessionAddress($arrAddress, $thisIdUser, $myArrAddress, $request);
            }

            if (!empty($arrAddress)) {

                $myArrAddress = getMyArrAddress($arrAddress, $this->idUser);

                // make id of address
                if (!empty($myArrAddress)) {
                    foreach ($myArrAddress as $id => $each) {

                        $arrIdAddress[] = $id;
                    }

                    $idAddress = max($arrIdAddress) + 1;
                } else {

                    $idAddress = 1;
                }
                //end

                if (isset($arrInfoAddressUser['default'])) {

                    // set all default of address = 0
                    if (!empty($myArrAddress)) {

                        foreach ($myArrAddress as $id => $each) {
                            if ($each['default'] == 1) {

                                $myArrAddress[$id]['default'] = 0;
                            }
                        }

                        foreach ($arrAddress as $index => $value) {
                            foreach ($value as $idUser => $eachAddress) {
                                if ($idUser == $this->idUser) {
                                    $arrAddress[$index][$idUser] = $myArrAddress;
                                }
                            }
                        }
                    }
                    // end

                    $default = 1;

                    putNewAddressToSession($default, $idAddress, $arrAddress, $arrInfoAddressUser, $this->idUser, $request, $myArrAddress);
                } else {

                    $default = 0;

                    putNewAddressToSession($default, $idAddress, $arrAddress, $arrInfoAddressUser, $this->idUser, $request, $myArrAddress);
                }
            } else {

                $idAddress = 1;

                $default = 0;

                if (isset($arrInfoAddressUser['default'])) {
                    $default = 1;
                }

                $request->session()->push('address', [$this->idUser => [$idAddress => [
                    'full_name'     => $arrInfoAddressUser['full-name'],
                    'phone_number'  => $arrInfoAddressUser['phone-number'],
                    'city'          => $arrInfoAddressUser['city'],
                    'district'      => $arrInfoAddressUser['district'],
                    'street'        => $arrInfoAddressUser['street'],
                    'default'       => $default,
                ]]]);
            }

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }

    public function editAddress(Request $request)
    {
        $addressEdit = [];

        $id = (int)$request->get('id');

        $myArrAddress = getMyCart($this->sessionAddress, $this->idUser);

        foreach ($myArrAddress as $idAddress => $each) {
            if ($idAddress == $id) {
                $addressEdit['id']              = $id;
                $addressEdit['full_name']       = $each['full_name'];
                $addressEdit['phone_number']    = $each['phone_number'];
                $addressEdit['city']            = $each['city'];
                $addressEdit['district']        = $each['district'];
                $addressEdit['street']          = $each['street'];
                $addressEdit['default']         = $each['default'];
            }
        }
        return $addressEdit;
    }

    public function storeEditAddress(editAddressRequest $request)
    {
        try {
            $arrAddressRequest  = $request->validated();

            $arrAddress         = $this->sessionAddress;

            $myArrAddress       = getMyArrAddress($arrAddress, $this->idUser);

            foreach ($myArrAddress as $id => $each) {
                if ($id == (int)$arrAddressRequest['id']) {
                    $myArrAddress[$id]['full_name']    = $arrAddressRequest['full-name'];
                    $myArrAddress[$id]['phone_number'] = $arrAddressRequest['phone-number'];
                    $myArrAddress[$id]['city']         = $arrAddressRequest['city'];
                    $myArrAddress[$id]['district']     = $arrAddressRequest['district'];
                    $myArrAddress[$id]['street']       = $arrAddressRequest['street'];

                    if (!isset($arrAddressRequest['default'])) {
                        $myArrAddress[$id]['default'] = 0;
                    } else {
                        $myArrAddress[$id]['default'] = 1;
                    }
                }
            }

            updateSessionAddress($arrAddress, $this->idUser, $myArrAddress, $request);

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }

    public function confirmDefaultAddress(Request $request)
    {
        try {
            $arrAddress = $this->sessionAddress;

            $idDefaultAddress = (int)$request->get('id');

            $myArrAddress = getMyArrAddress($arrAddress, $this->idUser);

            foreach ($myArrAddress as $id => $each) {

                $myArrAddress[$id]['default'] = 0;

                if ($id == $idDefaultAddress) {
                    $myArrAddress[$id]['default'] = 1;
                }
            }

            updateSessionAddress($arrAddress, $this->idUser, $myArrAddress, $request);

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }

    public function placeOrder(PlaceOrderRequest $request)
    {
        $current_day = date_format(new DateTime(), "Y-m-d");

        $arrRequest             = $request->validated();

        $total                  = $arrRequest['total'] ?? 0;

        $arrIdProductPlaceOrder = $arrRequest['id'] ?? [];

        $idUser                 = $this->idUser;

        $arrAddress             = $this->sessionAddress;

        $myArrAddress           = getMyArrAddress($arrAddress, $idUser);

        if (empty($myArrAddress)) {
            return redirect()->back();
        }

        $defaultAddress         = [];

        $stringAddress          = '';

        $carts                  = $this->sessionCarts;


        if (!empty($carts)) {
            $myCart = getMyCart($carts, $idUser);
        }

        // get delivery address
        foreach ($myArrAddress as $id => $eachValueAddress) {
            if ($eachValueAddress['default'] == 1) {
                $defaultAddress['full_name']    = $eachValueAddress['full_name'];
                $defaultAddress['phone_number'] = $eachValueAddress['phone_number'];
                $stringAddress = $eachValueAddress['street'] . ',' . ' ' . $eachValueAddress['district'] . ',' . ' ' . $eachValueAddress['city'];
            }
        }
        // -- end -- 

        if (!empty($myCart)) {
            foreach ($myCart as $id => $each) {

                foreach ($arrIdProductPlaceOrder as $eachIdProduct) {

                    if ($id == (int)$eachIdProduct) {

                        $product = Product::find($eachIdProduct);

                        if (isset($product)) {
                            if (!isset($orderId)) {
                                $orderId = Order::query()->create([
                                    'user_id'           => $idUser,
                                    'name_receiver'     => $defaultAddress['full_name'],
                                    'address_receiver'  => $stringAddress,
                                    'phone_receiver'    => $defaultAddress['phone_number'],
                                    'status'            => OrderStatusEnum::PENDING,
                                    'total'             => (int)$total,
                                    'created_at'        => $current_day,
                                ])->id;
                            }

                            $order = Order::find($orderId);

                            $product->quantity = $product['quantity'] - $each['quantity'];

                            $product->save();

                            $order->Product()->attach($product->id, ['quantity' => $each['quantity'], 'price' => $each['price']]);
                        }

                        if (!empty(getMyArrProductToPayFromSession($request, $idUser))) {

                            if (!isset($arrProductToPayUpdate)) {

                                $arrProductToPayUpdate = getMyArrProductToPayFromSession($request, $idUser);
                            }

                            $arrProductToPayUpdate[$orderId][$id] = [
                                'name_product'   => $each['name_product'],
                                'size'           => $each['size'],
                                'amount'         => $each['amount'],
                                'photo_product'  => $each['photo_product'],
                                'price'          => $each['price'],
                                'quantity'       => $each['quantity'],
                                'status'         => OrderStatusEnum::PENDING,
                            ];
                        } else {
                            $request->session()->push(
                                'productToPay',
                                [
                                    $idUser =>
                                    [
                                        $orderId =>
                                        [
                                            $id =>
                                            [
                                                'name_product'   => $each['name_product'],
                                                'size'           => $each['size'],
                                                'amount'         => $each['amount'],
                                                'photo_product'  => $each['photo_product'],
                                                'price'          => $each['price'],
                                                'quantity'       => $each['quantity'],
                                                'status'         => OrderStatusEnum::PENDING,
                                            ]
                                        ]
                                    ]
                                ]
                            );
                        }

                        unset($myCart[$id]);
                    }
                }
            }
        }

        $sessionProductToPay = $request->session()->get('productToPay');

        if (!empty($arrProductToPayUpdate)) {
            foreach ($sessionProductToPay as $index => $values) {
                foreach ($values as $id => $each) {
                    if ($id == $idUser) {
                        $sessionProductToPay[$index][$id] = $arrProductToPayUpdate;
                    }
                }
            }

            $request->session()->put('productToPay', $sessionProductToPay);
        }

        if (!empty($arrProductToPayUpdate)) {
            foreach ($carts as $index => $values) {
                foreach ($values as $id => $each) {
                    if ($id == $idUser) {
                        $carts[$index][$id] = $myCart;
                    }
                }

                $request->session()->put('carts', $carts);
            }
        }


        return view('layout_frontpage.to_pay', [
            'myArrProductToPay'  => getMyArrProductToPayFromSession($request, $idUser),
        ]);
    }

    public function cancelProduct(Request $request)
    {
        try {
            $productIdCancel    = (int)$request->get('productIdCancel');

            $orderIdCancel      = (int)$request->get('orderId');

            $product            = Product::find($productIdCancel);

            $order              = Order::find($orderIdCancel);

            if (!isset($product) and !isset($order)) {
                return redirect()->back();
            }

            $myArrProductToPay   = getMyArrProductToPayFromSession($request, $this->idUser);

            if (!empty($myArrProductToPay)) {
                foreach ($myArrProductToPay as $orderId => $products) {
                    foreach ($products as $id => $each) {
                        if ($orderId == $orderIdCancel and $id == $productIdCancel and $each['status'] == OrderStatusEnum::PENDING) {

                            $dataPivotTableOrderProduct = $order->Product()->where('product_id', $productIdCancel)->first();

                            if (isset($dataPivotTableOrderProduct)) {
                                $order->Product()->detach($productIdCancel);

                                $order->total -= $each['amount'];

                                $product->quantity += $each['quantity'];

                                $order->save();

                                $product->save();

                                $myArrProductToPay[$orderId][$id]['status'] = OrderStatusEnum::CANCELED;
                            } else {
                                return redirect()->back();
                            }
                        }
                    }
                }

                $sessionProductToPay = $request->session()->get('productToPay');

                foreach ($sessionProductToPay as $index => $values) {
                    foreach ($values as $idUser => $orders) {
                        if ($idUser == $this->idUser) {
                            $sessionProductToPay[$index][$idUser] = $myArrProductToPay;
                        }
                    }
                }

                $request->session()->put('productToPay', $sessionProductToPay);
            }

            $orderDelete    = Order::query()->find($orderIdCancel);

            $orderProduct   = $orderDelete->Product()->get();

            if (!count($orderProduct)) {
                $orderDelete->delete();
            }

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }

    public function postComment(PostCommentRequest $request)
    {
        try {

            $productName        = $request->get('product_name');

            $arr                = $request->validated();

            $arr['user_id']     = $this->idUser;


            $arr['created_at']  = date_format(new DateTime(), "Y-m-d H:i:s");

            if (user()->customer_role != CustomerRoleEnum::OWNER) {

                $data               = UserCommentProduct::query()
                    ->where('user_id', $arr['user_id'])
                    ->where('product_name', $arr['product_name'])
                    ->get();


                $order = Order::query()
                    ->selectRaw('products.id  as product_id')
                    ->selectRaw('products.name  as product_name')
                    ->join('order_product', 'orders.id', 'order_product.order_id')
                    ->join('products', 'products.id', 'order_product.product_id')
                    ->whereRaw("orders.user_id = $this->idUser and orders.status = 5 and products.name = '$productName'")
                    ->get();

                if (count($data)) {
                    return redirect()->back();
                }

                if (!count($order)) {
                    return redirect()->back();
                }
            }

            $userCommentProduct = UserCommentProduct::create($arr);

            $id                 = $userCommentProduct->id;

            $newComment = UserCommentProduct::query()
                ->selectRaw('users.name  as user_name')
                ->selectRaw('users.photo  as user_avatar')
                ->selectRaw('users.customer_role  as user_customer_role')
                ->selectRaw('user_comment_products.*')
                ->join('users', 'user_comment_products.user_id', 'users.id')
                ->whereRaw("user_comment_products.user_id = $this->idUser and user_comment_products.id = $id")
                ->get();

            return $this->successResponse($newComment);
        } catch (\Throwable $th) {

            return $this->errorResponse();
        }
    }

    public function replyComment(ReplyCommentRequest $request)
    {
        try {

            $arr                = $request->validated();

            $arr['user_id']     = $this->idUser;

            $arr['created_at']  = date_format(new DateTime(), "Y-m-d H:i:s");

            $userReplyComment   = UserReplyComment::create($arr);

            $id                 = $userReplyComment->id;

            $newComment = UserReplyComment::query()
                ->selectRaw('users.name  as user_name')
                ->selectRaw('users.photo  as user_avatar')
                ->selectRaw('user_reply_comments.*')
                ->join('users', 'user_reply_comments.user_id', 'users.id')
                ->whereRaw("user_reply_comments.user_id = $this->idUser and user_reply_comments.id = $id")
                ->get();

            return $this->successResponse($newComment);
        } catch (\Throwable $th) {

            return $this->errorResponse();
        }
    }
}
