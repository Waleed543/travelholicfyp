<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Active()
 * @method static static Inactive()
 * @method static static Inprogress()
 */
final class Status extends Enum
{
    const Active =   'Active';
    const InActive =   'In Active';
    const InProgress = 'In Progress';
    const Canceled = 'Canceled';
}
