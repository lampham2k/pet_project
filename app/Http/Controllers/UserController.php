<?php

namespace App\Http\Controllers;

use App\Enums\CustomerRoleEnum;
use App\Enums\UserRoleEnum;
use App\Http\Requests\User\SearchRequest;
use App\Models\Collaborator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use ResponseTrait;

    public function inforUserDetail($id)
    {
        try {
            $data = User::query()->select([
                'birthday',
                'phone_number',
                'address',
                'description',
                'name',
            ])->find($id);
            return $this->successResponse($data);
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }

    public function search(SearchRequest $request)
    {
        if ($request->ajax()) {

            $collaborators      = Collaborator::where('name', 'like', '%' . $request->search . '%')->get();
            $arrCustomerRole    = CustomerRoleEnum::asArray();
            $arrUserRole        = UserRoleEnum::getArrWithStringToLower();

            $search = User::where('id', 'like', '%' . $request->search . '%')
                ->orwhere('name', 'like', '%' . $request->search . '%')
                ->orwhere('email', 'like', '%' . $request->search . '%')
                ->orwhere('address', 'like', '%' . $request->search . '%')
                ->orwhere('description', 'like', '%' . $request->search . '%')
                ->orwhere('birthday', 'like', '%' . $request->search . '%')
                ->orwhere('phone_number', 'like', '%' . $request->search . '%');

            foreach ($arrCustomerRole as $key => $value) {
                if ($key === Str::upper($request->search)) {
                    $search->orwhere('customer_role', $value);
                }
            }

            foreach ($arrUserRole as $key => $value) {
                if ($key === Str::lower($request->search)) {
                    $search->orwhere('user_role', $value);
                }
            }

            if (count($collaborators) > 0) {
                foreach ($collaborators as $each) {
                    $search->orwhere('collaborator_id', $each->id);
                }
            }

            switch (Str::lower($request->search)) {
                case 'female':
                    $search->orwhere('gender', 0);
                    break;
                case 'male':
                    $search->orwhere('gender', 1);
                    break;
            }

            $data = $search->with([
                'collaborator' => function ($q) {
                    return $q->select([
                        'id',
                        'name',
                    ]);
                },
            ])->get();

            $output = '';
            if (count($data) > 0) {

                $output = '
                <table class="table" id="tableManufacturer">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Photo</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Information</th>
                    <th>Customer Role</th>
                    <th>User Role</th>
                    <th>Collaborator</th>
                    <th class="text-right">Actions</th>
                </tr>
                </thead>
                <tbody>';

                foreach ($data as $each) {
                    $output .= '
                        <tr class="trTable">
                            <td class="text-center">' . $each->id . '</td>
                            <td>
                                <div class="card card-testimonial">
                                    <div class="card-avatar">
                                        <img src="http://127.0.0.1:8000/storage/user_avatar/' . $each->photo . '" style="height:20% !important;">
                                    </div>
                                </div>
                            </td>
                            <td>' . $each->name . '</td>
                            <td>' . $each->email . '</td>
                            <td>' . $each->gender_name . '</td>
                            <td class="detailInfor"> Tel: ' . $each->phone_number . '</td>
                            <td>' . $each->customer_role_name . '</td>
                            <td>' . $each->user_role_name . '</td>
                            <td>' . optional($each->collaborator)->name . '</td>
                            <td class="td-actions text-right">
                                <a href="http://127.0.0.1:8000/admin/users/edit/' . $each->id . '" rel="tooltip" class="btn btn-success" data-original-title="" title="">
                                    <i class="material-icons">edit</i>
                                </a>
                                <form class="formDelete" action="http://127.0.0.1:8000/admin/users/delete/'  . $each->id . '" method="POST" style="display: inline !important;">
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
