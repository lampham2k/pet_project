<?php

namespace App\Http\Controllers;

use App\Http\Requests\Manufacturer\SearchRequest;
use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    public function search(SearchRequest $request)
    {
        if ($request->ajax()) {

            $data = Manufacturer::where('id', 'like', '%' . $request->search . '%')
                ->orwhere('name', 'like', '%' . $request->search . '%')
                ->orwhere('address', 'like', '%' . $request->search . '%')
                ->orwhere('phone_number', 'like', '%' . $request->search . '%')->get();

            $output = '';
            if (count($data) > 0) {

                $output = '
                <table class="table" id="tableManufacturer">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Photo</th>
                    <th class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>';

                foreach ($data as $each) {
                    $output .= '
                        <tr class="trTable">
                            <td class="text-center">' . $each->id . '</td><td>' . $each->name . '</td>
                            <td>' . $each->address . '</td>
                            <td>' . $each->phone_number . '</td>
                            <td>
                            <div class="card card-testimonial">
                                <div class="card-avatar">
                                    <img src="http://127.0.0.1:8000/storage/manufacturer_logo/' . $each->photo . '" style="height:20 !important;">
                                </div>
                            </div>
                            </td>
                            <td class="td-actions text-right">
                                <a href="http://127.0.0.1:8000/admin/manufacturers/edit/' . $each->id . '" rel="tooltip" class="btn btn-success" data-original-title="" title="">
                                    <i class="material-icons">edit</i>
                                </a>
                                <form class="formDelete" action="http://127.0.0.1:8000/admin/manufacturers/delete/'  . $each->id . '" method="POST" style="display: inline !important;">
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
