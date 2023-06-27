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
final class OrderStatusEnum extends Enum
{
    public const PENDING             = 0;
    public const APPROVED            = 1;
    public const CANCELED            = 3;
    public const DELIVERING          = 4;
    public const COMPLETED           = 5;

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
