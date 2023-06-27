<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\ResponseTrait;

class OrderController extends Controller
{
    use ResponseTrait;

    private object $model;
    private string $table;

    public function __construct()
    {
        if (!isSuperAdmin()) {
            dd("System error");
        }
        $this->model = Order::query();
        $this->table = (new Order())->getTable();

        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }

    public function index()
    {
        $data = $this->model->with([
            'user' => function ($q) {
                return $q->select([
                    'id',
                    'name',
                ]);
            },
        ])->paginate(4);

        return view("admin.$this->table.index", [
            'data' => $data,
        ]);
    }

    public function product($id)
    {
        $order = $this->model->find($id);

        if (!isset($order)) {
            return redirect()->back();
        }

        $orderProduct = $order->Product()->get();

        $arrSize = [];

        foreach ($orderProduct as $each) {
            $size = Size::find($each->size_id);

            $arrSize[$each['id']] = (int)$size->size;
        }

        return view("admin.$this->table.product", [
            'orderProduct'  => $orderProduct,
            'arrSize'       => $arrSize,
        ]);
    }

    public function accept(Request $request, $id)
    {
        try {
            $order = $this->model->find($id);

            if (!isset($order)) {
                return redirect()->back();
            }

            $orderProduct = $order->Product()->get();

            $condition = null;

            foreach ($orderProduct as $each) {
                if ($each->quantity >= $each->pivot->quantity) {
                    $condition = true;
                } else {
                    $condition = false;
                }
            }

            if ($condition !== true) {
                return $this->errorResponse();
            }

            $order->status = OrderStatusEnum::COMPLETED;

            $order->save();

            $sessionProductToPay    = $request->session()->get('productToPay');

            $productToPayOfIdUser   = getMyArrProductToPayFromSession($request, $order->user_id);

            foreach ($productToPayOfIdUser as $orderId => $products) {
                if ($orderId == $order->id) {
                    foreach ($products as $id => $each) {
                        $productToPayOfIdUser[$orderId][$id]['status'] = OrderStatusEnum::COMPLETED;
                    }
                }
            }

            foreach ($sessionProductToPay as $index => $values) {
                foreach ($values as $idUser => $orders) {
                    if ($idUser == $order->user_id) {
                        $sessionProductToPay[$index][$idUser] = $productToPayOfIdUser;
                    }
                }
            }

            $request->session()->put('productToPay', $sessionProductToPay);

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }

    public function cancel(Request $request, $id)
    {
        try {
            $order = $this->model->find($id);

            if (!isset($order)) {
                return redirect()->back();
            }

            $order->status = OrderStatusEnum::CANCELED;

            $order->save();

            $sessionProductToPay    = $request->session()->get('productToPay');

            $productToPayOfIdUser   = getMyArrProductToPayFromSession($request, $order->user_id);

            foreach ($productToPayOfIdUser as $orderId => $products) {
                if ($orderId == $order->id) {
                    foreach ($products as $id => $each) {
                        $productToPayOfIdUser[$orderId][$id]['status'] = OrderStatusEnum::CANCELED;
                    }
                }
            }

            foreach ($sessionProductToPay as $index => $values) {
                foreach ($values as $idUser => $orders) {
                    if ($idUser == $order->user_id) {
                        $sessionProductToPay[$index][$idUser] = $productToPayOfIdUser;
                    }
                }
            }

            $request->session()->put('productToPay', $sessionProductToPay);

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }
}
