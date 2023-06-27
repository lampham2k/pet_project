<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CustomerRoleEnum;
use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Collaborator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ResponseTrait;

    private object $model;
    private string $table;

    public function __construct()
    {
        if (!isSuperAdmin()) {
            dd("System error");
        }
        $this->model = User::query();
        $this->table = (new User())->getTable();

        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }

    public function index(Request $request)
    {
        $customerRole = CustomerRoleEnum::getArrWithUppercase();
        $userRole = UserRoleEnum::getArrWithUppercase();
        $filterCustomerRole = $request->get('customer_role');
        $filterUserRole = $request->get('user_role');

        $filters = [];

        if ($request->has('customer_role')) {
            $filters['customer_role'] = $filterCustomerRole;
        }
        if ($request->has('user_role')) {
            $filters['user_role'] = $filterUserRole;
        }

        $data = $this->model->indexUsers($filters)->paginate(5);

        return view("admin.$this->table.index", [
            'data'                  => $data,
            'customerRole'          => $customerRole,
            'userRole'              => $userRole,
            'filterCustomerRole'    => $filterCustomerRole,
            'filterUserRole'        => $filterUserRole,
        ]);
    }

    public function create()
    {
        $customerRole = CustomerRoleEnum::getArrWithUppercase();
        $userRole = UserRoleEnum::getArrWithUppercase();

        return view("admin.$this->table.create", [
            'customerRole'  => $customerRole,
            'userRole'      => $userRole,
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {
            $arr = $request->validated();

            if ($request->has('photo')) {
                $arr['photo'] = $request->file('photo')->getClientOriginalName();
                $request->file('photo')->storeAs('public/user_avatar', $arr['photo']);
            }

            $arr['password'] = Hash::make($request->password);

            $this->model->create($arr);

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }

    public function edit($userId)
    {
        $data = $this->model->with('collaborator')->find($userId);
        $userRole = [];

        if (is_null($data)) {
            return redirect()->back();
        }

        $customerRole = CustomerRoleEnum::getArrWithUppercase();
        if (isSuperAdmin()) {
            $userRole = UserRoleEnum::getArrWithUppercase();
        }

        return view("admin.$this->table.edit", [
            'data'              => $data,
            'customerRole'      => $customerRole,
            'userRole'          => $userRole,
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $data = $this->model->find($id);
            $arr = $request->validated();

            if ($request->has('collaborator_id')) {
                $arr['collaborator_id'] = (int)$request->get('collaborator_id');
            }

            if ($arr['collaborator_id'] === 0) {
                $arr['collaborator_id'] = null;
            }

            if ($request->has('photo')) {
                $arr['photo'] = $request->file('photo')->getClientOriginalName();
                $request->file('photo')->storeAs('public/user_avatar', $arr['photo']);
            }

            $data->update($arr);

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->model->find($id);
            $data->delete();

            return $this->successResponse();
        } catch (\Throwable $th) {

            return $this->errorResponse();
        }
    }
}
