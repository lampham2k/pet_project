<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\SearchRequest;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search(SearchRequest $request)
    {
        if ($request->ajax()) {

            $types         = Type::where('name', 'like', '%' . $request->search . '%')->get();

            $manufacturers = Manufacturer::where('name', 'like', '%' . $request->search . '%')->get();

            $search = Product::where('id', 'like', '%' . $request->search . '%')
                ->orwhere('name', 'like', '%' . $request->search . '%')
                ->orwhere('quantity', 'like', '%' . $request->search . '%')
                ->orwhere('price', 'like', '%' . $request->search . '%');

            foreach ($types as $each) {
                $search->orwhere('type_id', $each->id);
            }
            foreach ($manufacturers as $each) {
                $search->orwhere('manufacturer_id', $each->id);
            }

            $data = $search->with([
                'manufacturer' => function ($q) {
                    return $q->select([
                        'id',
                        'name',
                    ]);
                },
                'type',
            ])->get();

            $output = '';
            if (count($data) > 0) {

                $output = '
                <table class="table" id="tableManufacturer">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Type</th>
                    <th>Size</th>
                    <th>Manufacturer</th>
                    <th>Photo</th>
                    <th class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>';

                foreach ($data as $each) {
                    $output .= '
                        <tr class="trTable">
                            <td class="text-center">' . $each->id . '</td><td>' . $each->name . '</td>
                            <td>' . $each->price . '</td>
                            <td>' . $each->quantity . '</td>
                            <td>' . $each->type->name . '</td>
                            <td>' . $each->size->size . '</td>
                            <td>' . $each->manufacturer->name . '</td>
                            <td>
                            <div class="card card-testimonial">
                                <div class="card-avatar">
                                    <img src="http://127.0.0.1:8000/storage/product_photo/' . $each->photo . '" style="height:20 !important;">
                                </div>
                            </div>
                            </td>
                            <td class="td-actions text-right">
                                <a href="http://127.0.0.1:8000/admin/products/edit/' . $each->id . '" rel="tooltip" class="btn btn-success" data-original-title="" title="">
                                    <i class="material-icons">edit</i>
                                </a>
                                <form class="formDelete" action="http://127.0.0.1:8000/admin/products/delete/'  . $each->id . '" method="POST" style="display: inline !important;">
                                    <button rel="tooltip" class="btnDelete btn btn-danger" data-original-title="" title="">
                                        <i class="material-icons">close</i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        ';
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
