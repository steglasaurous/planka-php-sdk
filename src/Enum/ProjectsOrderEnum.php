<?php

declare(strict_types=1);

namespace Planka\Bridge\Enum;

enum ProjectsOrderEnum: string
{
    case BY_DEFAULT = 'byDefault';
    case ALPHABETICALLY = 'alphabetically';
    case BY_CREATION_TIME = 'byCreationTime';
}
