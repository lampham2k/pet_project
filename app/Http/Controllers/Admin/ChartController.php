<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function index(Request $request)
    {

        return view('admin.chart.index');
    }

    public function statistical(Request $request)
    {

        $max_date       = 30;

        $arr = [];

        $this_month     = date('m');

        $this_year      = date('Y');

        $today          = date('d');

        $order = Order::query()
            ->selectRaw('products.id  as product_id')
            ->selectRaw('products.name  as product_name')
            ->selectRaw('sizes.size  as product_size')
            ->selectRaw("date_format(orders.created_at, '%d-%m-%Y') as 'day'")
            ->selectRaw("sum(order_product.quantity) as 'number_of_products_sold'")
            ->join('order_product', 'orders.id', 'order_product.order_id')
            ->join('products', 'products.id', 'order_product.product_id')
            ->join('sizes', 'sizes.id', 'products.size_id')
            ->whereRaw("DATE(orders.created_at) >= CURDATE() - INTERVAL $max_date DAY and DATE(orders.created_at) <= CURDATE()")
            ->whereRaw("orders.status = 5")
            ->groupBy('products.id')
            ->groupBy('orders.created_at')
            ->get();

        // today = 16 , max date = 30

        if ($today < $max_date) {

            $day_last_month             = $max_date - $today; // 14

            $last_month                 = date("m", strtotime("-1 month"));

            $last_day_of_previous_month = date('d', strtotime('last day of previous month')); // 31

            $start_day_last_month       = $last_day_of_previous_month - $day_last_month + 1; // 31 - 14 + 1 = 16

            $start_day_this_month       = 1;
        } else {

            $start_day_this_month       = $today - $max_date + 1;
        }

        foreach ($order as $each) {

            $product_id = $each['product_id'];

            if (empty($arr[$product_id])) {

                $arr[$product_id] = [
                    'name'      => $each['product_name'] . ' size: ' . $each['product_size'],
                    'y'         => (int)$each['number_of_products_sold'],
                    'drilldown' => (int)$each['product_id'],
                ];
            } else {

                $arr[$product_id]['y'] += $each['number_of_products_sold'];
            }
        }

        $arrDrillDown = [];

        foreach ($arr as $product_id => $each) {

            $arrDrillDown[$product_id] = [
                'name'  => $each['name'],
                'id'    => $product_id,
            ];

            $arrDrillDown[$product_id]['data'] = [];

            if ($today < $max_date) { // today 16. max date 30

                for ($i = $start_day_last_month; $i <= $last_day_of_previous_month; $i++) {

                    $key = $i . '-' . $last_month . '-' . $this_year;

                    $arrDrillDown[$product_id]['data'][$key] = [
                        $key,
                        0
                    ];
                }

                for ($i = $start_day_this_month; $i <= $today; $i++) {

                    $key = $i . '-' . $this_month . '-' . $this_year;

                    $arrDrillDown[$product_id]['data'][$key] = [
                        $key,
                        0
                    ];
                }
            } else {
                for ($i = $start_day_this_month; $i <= $today; $i++) {

                    $key = $i . '-' . $this_month . '-' . $this_year;

                    $arrDrillDown[$product_id]['data'][$key] = [
                        $key,
                        0
                    ];
                }
            };
        }
        foreach ($order as $each) {

            $product_id     = $each['product_id'];

            $key            = $each['day'];

            $arrDrillDown[$product_id]['data'][$key] = [
                $key,
                (int)$each['number_of_products_sold']
            ];
        }

        $array = [$arr, $arrDrillDown];

        return $array;
    }
}
