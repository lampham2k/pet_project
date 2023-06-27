<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Http\Requests\Manufacturer\SearchRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    use ResponseTrait;

    public function orders(SearchRequest $request)
    {
        if ($request->ajax()) {

            $user = User::where('name', 'like', '%' . $request->search . '%')->get();

            $arrOrderStatusEnum = OrderStatusEnum::getArrWithStringToLower();

            $search = Order::where('id', 'like', '%' . $request->search . '%')
                ->orwhere('name_receiver', 'like', '%' . $request->search . '%')
                ->orwhere('address_receiver', 'like', '%' . $request->search . '%')
                ->orwhere('phone_receiver', 'like', '%' . $request->search . '%');

            foreach ($arrOrderStatusEnum as $key => $value) {
                if ($key == $request->search) {
                    $search->orwhere('status', $value);
                }
            }

            if (count($user) > 0) {
                foreach ($user as $each) {
                    $search->orwhere('user_id', $each->id);
                }
            }

            $data = $search->with([
                'user' => function ($q) {
                    return $q->select([
                        'id',
                        'name',
                    ]);
                },
            ])->get();

            $output = '';

            if (count($data) > 0) {

                $output = '
                <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>User Name</th>
                        <th>Name Receiver</th>
                        <th>Phone Receiver</th>
                        <th>Address Receiver</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($data as $each) {

                    $output .= '
                        <tr class="trTable">
                            <td class="text-center"> <a href="http://127.0.0.1:8000/admin/orders/product/' . $each->id . '">' . $each->id . '</a></td>
                            <td>' . $each->user->name . '</td>
                            <td>' . $each->name_receiver . '</td>
                            <td>' . $each->phone_receiver . '</td>
                            <td>' . $each->address_receiver . '</td>
                            <td>';

                    if ($each->status_name == 'CANCELED') {

                        $output .= '<div class="text-danger">' . $each->status_name . '</div>';
                    } elseif ($each->status_name == 'COMPLETED') {

                        $output .= '<div class="text-primary">' . $each->status_name . '</div>';
                    } else {

                        $output .= '<div class="text-success">' . $each->status_name . '</div> </td>';
                    }

                    $output .= ' <td>' . $each->total . 'vnd </td> <td class="td-actions text-right">';

                    if ($each->status == 0) {

                        $output .= '<a href="http://127.0.0.1:8000/admin/orders/accept/' . $each->id . '" rel="tooltip" class="btn btn-success a-accept-order" data-original-title="" title="">
                                        <i class="material-icons">check</i>
                                    </a>
                                    <a href="http://127.0.0.1:8000/admin/orders/cancel/' . $each->id . '" rel="tooltip" class="btn btn-danger a-cancel-order" data-original-title="" title="">
                                        <i class="material-icons">cancel</i>
                                    </a>';
                    } elseif ($each->status == 3) {

                        $output .= '<a href="http://127.0.0.1:8000/admin/orders/accept/' . $each->id . '" rel="tooltip" class="btn btn-success a-accept-order" data-original-title="" title="">
                                        <i class="material-icons">check</i>
                                    </a>';
                    } elseif ($each->status == 5) {

                        $output .= '<a href="" rel="tooltip" class="btn btn-primary" data-original-title="" title="">
                                        <i class="material-icons">done_all</i>
                                    </a>';
                    } else {

                        $output .= '<a href="http://127.0.0.1:8000/admin/orders/cancel/' . $each->id . '" rel="tooltip" class="btn btn-danger a-cancel-order" data-original-title="" title="">
                                        <i class="material-icons">cancel</i>
                                    </a>';
                    }

                    $output .= '</td> </tr>';
                }

                $output .= '
                 </tbody>
                </table>';
            } else {

                $output .= 'No results';
            }

            return $output;
        }
    }
}
