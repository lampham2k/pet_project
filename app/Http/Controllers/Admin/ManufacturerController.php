<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Manufacturer\StoreRequest;
use App\Http\Requests\Manufacturer\UpdateRequest;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class ManufacturerController extends Controller
{
    use ResponseTrait;

    private object $model;
    private string $table;

    public function __construct()
    {
        if (!isSuperAdmin()) {
            dd("System error");
        }
        $this->model = Manufacturer::query();
        $this->table = (new Manufacturer())->getTable();

        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }

    public function index()
    {
        $data = $this->model->paginate(4);

        return view("admin.$this->table.index", [
            'data' => $data,
        ]);
    }

    public function create()
    {
        return view("admin.$this->table.create");
    }

    public function store(StoreRequest $request)
    {
        try {
            $arr = $request->validated();
            $arr['photo'] = $request->file('photo')->getClientOriginalName();
            $request->file('photo')->storeAs('public/manufacturer_logo', $arr['photo']);

            $this->model->create($arr);

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }

    public function edit($manufacturerId)
    {
        $data = $this->model->find($manufacturerId);

        if (is_null($data)) {
            return redirect()->back();
        }

        return view("admin.$this->table.edit", [
            'data' => $data,
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $data = $this->model->find($id);

            if ($request->file('photo')) {
                $data->photo = $request->file('photo')->getClientOriginalName();
                $request->file('photo')->storeAs('public/manufacturer_logo', $data->photo);
            }

            $data->update([
                'name'          => $request->get('name'),
                'address'       => $request->get('address'),
                'phone_number'  => $request->get('phone_number'),
            ]);

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }

    public function delete($id)
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
