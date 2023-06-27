<?php

namespace App\Models;

use App\Enums\SystemCacheKeyEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    public static function getAndCache($is_public): array
    {
        return cache()->remember(
            SystemCacheKeyEnum::CONFIGS . $is_public,
            86400 * 30,
            function () use ($is_public) {
                $data = self::query()
                    ->where('is_public', $is_public)
                    ->get();

                $arr = [];

                foreach ($data as $each) {
                    $arr[$each->ke_y] = $each->valu_e;
                }
                return $arr;
            }
        );
    }
}
