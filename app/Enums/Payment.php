<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Payment extends Enum
{
    const Cash =   'Cash';
    const EasyPaisa =   'Easypaisa';
    const CreditCard = 'Credit Card';
}
