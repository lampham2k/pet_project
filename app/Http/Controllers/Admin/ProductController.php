<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Config;
use App\Models\Manufacturer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ProductController extends Controller
{
    use ResponseTrait;

    private object $model;
    private string $table;

    public function __construct()
    {
        $this->model = Product::query();
        $this->table = (new Product())->getTable();

        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }

    public function index(Request $request)
    {
        $configs         = Config::getAndCache(0);
        $minPrice        = $request->get('min_price', $configs['min_price']);
        $maxPrice        = $request->get('max_price', $configs['max_price']);
        $manufacturerId  = $request->get('manufacturer_id');
        $typeId          = $request->get('type_id');

        $filters = [];

        if ($request->has('min_price')) {
            $filters['min_price'] = $minPrice;
        }
        if ($request->has('max_price')) {
            $filters['max_price'] = $maxPrice;
        }
        if ($request->has('manufacturer_id')) {
            $filters['manufacturer_id'] = $manufacturerId;
        }
        if ($request->has('type_id')) {
            $filters['type_id'] = $typeId;
        }

        $types = getAndCacheTypes();
        $manufacturers = Manufacturer::query()->select([
            'id',
            'name',
        ])->get();

        $data = $this->model->indexProducts($filters)->paginate(5);

        return view("admin.$this->table.index", [
            'data'           => $data,
            'types'          => $types,
            'manufacturers'  => $manufacturers,
            'minPrice'       => $minPrice,
            'maxPrice'       => $maxPrice,
            'typeId'         => $typeId,
            'manufacturerId' => $manufacturerId,
            'configs'        => $configs,
        ]);
    }

    public function create()
    {
        $types = getAndCacheTypes();
        $sizes = getAndCacheSizes();
        $manufacturers = Manufacturer::query()->select([
            'id',
            'name',
        ])->get();

        return view('admin.products.create', [
            'types'         => $types,
            'manufacturers' => $manufacturers,
            'sizes'         => $sizes,
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {
            $arr = $request->validated();

            $arr['photo']           = $request->file('photo')->getClientOriginalName();
            $request->file('photo')->storeAs('public/product_photo', $arr['photo']);
            $arr['type_id']         = (int)$request->get('type_id');
            $arr['size_id']         = (int)$request->get('size_id');
            $arr['manufacturer_id'] = (int)$request->get('manufacturer_id');

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
}
