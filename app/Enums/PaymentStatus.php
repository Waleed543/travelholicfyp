<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PaymentStatus extends Enum
{
    const  Unpaid =   'Unpaid';
    const UnderReview =   'Under Review';
    const Successful =   'Successful';
}
