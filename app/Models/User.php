<?php

namespace App\Models;

use App\Enums\CustomerRoleEnum;
use App\Enums\UserRoleEnum;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Support\Str;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'description',
        'birthday',
        'collaborator_id',
        'gender',
        'photo',
        'phone_number',
        'accumulated_points',
        'user_role',
        'customer_role',
        'created_at',
    ];

    protected $casts = [
        'birthday'  => 'date:d-m-Y',
    ];

    protected static function booted()
    {
        if (!isSuperAdmin()) {
            static::creating(function ($object) {
                $object->user_role     = UserRoleEnum::CUSTOMER;
                $object->customer_role = CustomerRoleEnum::IRON;
            });
        }
    }

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class);
    }

    public function getGenderNameAttribute()
    {
        return ($this->gender === 1) ? 'Male' : 'Female';
    }

    public function getUserRoleNameAttribute()
    {
        $key = UserRoleEnum::getKey($this->user_role);

        return str::title(str_replace('_', ' ', $key));
    }

    public function getDateFormatAttribute()
    {
        return dateFormatAttributeYmd($this->birthday);
    }

    public function getCustomerRoleNameAttribute()
    {
        $key = CustomerRoleEnum::getKey($this->customer_role);

        return str::title(str_replace('_', ' ', $key));
    }

    public function scopeIndexUsers($query, $filters)
    {
        return $query = User::query()->with([
            'collaborator' => function ($q) {
                return $q->select([
                    'id',
                    'name',
                ]);
            },
        ])
            ->when(isset($filters['customer_role']), function ($q) use ($filters) {
                $q->where(function ($q) use ($filters) {
                    $q->orWhere('customer_role', $filters['customer_role']);
                    $q->orWhereNull('customer_role');
                });
            })
            ->when(isset($filters['user_role']), function ($q) use ($filters) {
                $q->where(function ($q) use ($filters) {
                    $q->orWhere('user_role', $filters['user_role']);
                    $q->orWhereNull('user_role');
                });
            });
    }
}
