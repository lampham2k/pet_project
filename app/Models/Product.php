<?php

namespace App\Models;

use App\Enums\SystemCacheKeyEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'price',
        'quantity',
        'type_id',
        'manufacturer_id',
        'photo',
        'size_id',
    ];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    protected static function booted()
    {
        // static::saved(function ($object) {
        //     $type = $object->type->name;
        //     $arrTypes = getAndCacheTypesExistInProducts();

        //     if (!in_array($type, $arrTypes)) {
        //         $arrTypes[] = $type;
        //     }

        //     cache()->put(SystemCacheKeyEnum::TYPE, $arrTypes);
        // });
    }

    public function scopeIndexProducts($query, $filters)
    {
        $discountProductTable = Discount::query()
            ->addSelect('product_id')
            ->selectRaw('MAX(percent_reduction) as max_discount_percent')
            ->selectRaw('MAX(money_reduced) as max_discount_money')
            ->join('discount_product', 'discount_product.discount_id', 'discounts.id')
            ->groupBy('product_id');

        $query = Product::query()->with([
            'manufacturer' => function ($q) {
                return $q->select([
                    'id',
                    'name',
                ]);
            },
            'type' => function ($q) {
                return $q->select([
                    'id',
                    'name',
                ]);
            },
            'size' => function ($q) {
                return $q->select([
                    'id',
                    'size',
                ]);
            },
        ])
            ->when(isset($filters['min_price']), function ($q) use ($filters) {
                $q->where(function ($q) use ($filters) {
                    $q->orWhere('price', '>=', $filters['min_price']);
                    $q->orWhereNull('price');
                });
            })
            ->when(isset($filters['max_price']), function ($q) use ($filters) {
                $q->where(function ($q) use ($filters) {
                    $q->orWhere('price', '<=', $filters['max_price']);
                    $q->orWhereNull('price');
                });
            })
            ->when(isset($filters['type_id']), function ($q) use ($filters) {
                $q->where(function ($q) use ($filters) {
                    $q->orWhere('type_id', $filters['type_id']);
                    $q->orWhereNull('type_id');
                });
            })
            ->when(isset($filters['product_name']), function ($q) use ($filters) {
                $q->where(function ($q) use ($filters) {
                    $q->orWhere('name', 'like', '%' . $filters['product_name'] . '%');
                    $q->orWhereNull('name');
                });
            })
            ->when(isset($filters['manufacturer_id']), function ($q) use ($filters) {
                $q->where(function ($q) use ($filters) {
                    $q->orWhere('manufacturer_id', $filters['manufacturer_id']);
                    $q->orWhereNull('manufacturer_id');
                });
            });

        if (isset($filters['types'])) {
            $query->whereIn('type_id', $filters['types']);
        }

        if (isset($filters['manufacturers'])) {
            $query->whereIn('manufacturer_id', $filters['manufacturers']);
        }

        if (isset($filters['discount'])) {
            $query->addSelect('products.*')
                ->addSelect('maxDiscountProductTable.max_discount_percent')
                ->addSelect('maxDiscountProductTable.max_discount_money')
                ->joinSub($discountProductTable, 'maxDiscountProductTable', function ($join) {
                    $join->on('maxDiscountProductTable.product_id', 'products.id');
                });
        } else {
            $query->addSelect('products.*')
                ->addSelect('maxDiscountProductTable.max_discount_percent')
                ->addSelect('maxDiscountProductTable.max_discount_money')
                ->leftJoinSub($discountProductTable, 'maxDiscountProductTable', function ($join) {
                    $join->on('maxDiscountProductTable.product_id', 'products.id');
                });
        }
        return $query;
    }

    public function getPriceNewAttribute()
    {
        $percent    = $this->max_discount_percent;
        $oldPrice   = $this->price;
        return ($oldPrice * $percent) / 100;
    }
}
