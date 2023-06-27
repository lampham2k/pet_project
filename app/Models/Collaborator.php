<?php

namespace App\Models;

use App\Enums\CollaboratorRoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'description',
        'birthday',
        'gender',
        'photo',
        'phone_number',
        'accumulated_points',
        'role',
        'f0_id',
        'created_at',
    ];

    protected $casts = [
        'birthday'  => 'date:d-m-Y',
    ];

    protected static function booted()
    {
        if (!isSuperAdmin()) {
            static::creating(function ($object) {
                $object->role = CollaboratorRoleEnum::IRON;
            });
        }
    }

    public function getF0IdNameAttribute()
    {
        $data = Collaborator::find($this->f0_id);

        return $data->name ?? "Nobody";
    }

    public function getDateFormatAttribute()
    {
        return dateFormatAttributeYmd($this->birthday);
    }
}
