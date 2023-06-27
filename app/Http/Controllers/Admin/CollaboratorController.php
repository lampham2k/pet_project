<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CollaboratorRoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Collaborator\StoreRequest;
use App\Http\Requests\Collaborator\UpdateRequest as CollaboratorUpdateRequest;
use App\Models\Collaborator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;

class CollaboratorController extends Controller
{
    use ResponseTrait;

    private object $model;
    private string $table;

    public function __construct()
    {
        if (!isSuperAdmin()) {
            dd("System error");
        }
        $this->model = Collaborator::query();
        $this->table = (new Collaborator())->getTable();

        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }

    public function index(Request $request)
    {
        // $customerRole = CustomerRoleEnum::getArrWithUppercase();
        // $userRole = UserRoleEnum::getArrWithUppercase();
        // $filterCustomerRole = $request->get('customer_role');
        // $filterUserRole = $request->get('user_role');

        // $filters = [];

        // if ($request->has('customer_role')) {
        //     $filters['customer_role'] = $filterCustomerRole;
        // }
        // if ($request->has('user_role')) {
        //     $filters['user_role'] = $filterUserRole;
        // }

        // $data = $this->model->indexUsers($filters)->paginate(5);

        $data = $this->model->paginate(5);

        return view("admin.$this->table.index", [
            'data'                  => $data,
            // 'customerRole'          => $customerRole,
            // 'userRole'              => $userRole,
            // 'filterCustomerRole'    => $filterCustomerRole,
            // 'filterUserRole'        => $filterUserRole,
        ]);
    }

    public function create()
    {
        $role = CollaboratorRoleEnum::getArrWithUppercase();

        return view("admin.$this->table.create", [
            'role' => $role,
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {
            $arr = $request->validated();

            if ($request->has('photo')) {
                $arr['photo'] = $request->file('photo')->getClientOriginalName();
                $request->file('photo')->storeAs('public/collaborator_avatar', $arr['photo']);
            }

            if ($arr['f0_id'] === 0) {
                $arr['f0_id'] = null;
            }

            $arr['password']    = Hash::make($request->password);

            $this->model->create($arr);

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }

    public function edit($userId)
    {
        $data       = $this->model->find($userId);
        $role       = CollaboratorRoleEnum::getArrWithUppercase();
        $f0_name    = Collaborator::find($data->f0_id)->name ?? "Nobody";

        if (is_null($data)) {
            return redirect()->back();
        }

        return view("admin.$this->table.edit", [
            'data'              => $data,
            'role'              => $role,
            'f0_name'           => $f0_name,
        ]);
    }

    public function update(CollaboratorUpdateRequest $request, $id)
    {
        try {
            $data = $this->model->find($id);
            $arr = $request->validated();

            if ($arr['f0_id'] === 0) {
                $arr['f0_id'] = null;
            }

            if ($request->has('photo')) {
                $arr['photo'] = $request->file('photo')->getClientOriginalName();
                $request->file('photo')->storeAs('public/collaborator_avatar', $arr['photo']);
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

    public function marketing($id)
    {
        $data = $this->model->find($id);

        return view("admin.$this->table.marketing", [
            'data'  => $data,
        ]);
    }
}
