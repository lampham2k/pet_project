<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CustomerRoleEnum extends Enum
{
    public const IRON       = 1;
    public const BRONZE     = 2;
    public const SILVER     = 3;
    public const GOLD       = 4;
    public const PLATINUM   = 5;
    public const DIAMOND    = 6;
    public const OWNER      = 7;

    public static function getArrWithUppercase()
    {
        return getArrWithUppercaseEnum(Self::asArray());
    }
}
