<?php

declare(strict_types=1);

namespace Planka\Bridge\Enum;

enum AutoLogoutModeEnum: string
{
    case NEVER = 'never';
    case TWO_MINUTES = '2m';
    case FIVE_MINUTES = '5m';
    case TEN_MINUTES = '10m';
    case THIRTY_MINUTES = '30m';
    case TWELVE_HOURS = '12h';
}
