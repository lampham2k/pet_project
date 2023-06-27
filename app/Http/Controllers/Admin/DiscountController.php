<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Discount\StoreRequest;
use App\Models\Config;
use App\Models\Discount;
use App\Models\Manufacturer;
use App\Models\Product;
use Illuminate\Support\Facades\View;

class DiscountController extends Controller
{
    use ResponseTrait;

    private object $model;
    private string $table;

    public function __construct()
    {
        $this->model = Discount::query();
        $this->table = (new Discount())->getTable();

        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }

    public function index(Request $request)
    {
        $data = $this->model->paginate(5);

        return view("admin.$this->table.index", [
            'data'           => $data,
        ]);
    }

    public function create()
    {
        return view('admin.discounts.create');
    }

    public function store(StoreRequest $request)
    {
        try {
            $arr = $request->validated();

            $arr['percent_reduction'] = (int)($request->get('percent_reduction'));

            $this->model->create($arr);

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }

    public function edit($productId)
    {
        $data = $this->model->find($productId);
        if (is_null($data)) {
            return redirect()->back();
        }
        $types = getAndCacheTypes();
        $manufacturers = Manufacturer::query()->select([
            'id',
            'name',
        ])->get();


        return view("admin.$this->table.edit", [
            'data' => $data,
            'types' => $types,
            'manufacturers' => $manufacturers,
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $data = $this->model->find($id);

            $data->update($request->validated());

            if ($request->file('photo')) {
                $data->photo = $request->file('photo')->getClientOriginalName();
                $data->save();
                $request->file('photo')->storeAs('public/product_photo', $data->photo);
            }

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

    public function product($id)
    {
        $dataDiscount = $this->model->with('product')->find($id);

        return view("admin.$this->table.product", [
            'dataDiscount'  => $dataDiscount,
        ]);
    }

    public function products(Request $request)
    {
        try {
            $discount = Discount::find($request->get('discount_id'));
            foreach ($request->get('product_id') as $each) {
                $discount->Product()->attach($each);
            }

            return $this->successResponse();
        } catch (\Throwable $th) {

            return $this->errorResponse();
        }
    }

    public function productDelete(Request $request)
    {
        try {
            $discount = $this->model->find($request->discountId);

            $discount->Product()->detach($request->productId);

            return $this->successResponse();
        } catch (\Throwable $th) {

            return $this->errorResponse();
        }
    }
}
