<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;
use Illuminate\Support\Str;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserRoleEnum extends Enum
{
    public const SUPER_ADMIN = 1;
    public const ADMIN = 2;
    public const CUSTOMER = 3;

    public static function getArrWithUppercase()
    {
        return getArrWithUppercaseEnum(Self::asArray());
    }

    public static function getArrWithStringToLower()
    {
        $arr = [];

        $data = Self::asArray();

        foreach ($data as $key => $val) {
            $index      = str::lower(str_replace('_', ' ', $key));
            $arr[$index] = $val;
        }

        return $arr;
    }
}
