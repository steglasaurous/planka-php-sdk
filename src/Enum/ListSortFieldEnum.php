<?php

declare(strict_types=1);

namespace Planka\Bridge\Enum;

enum ListSortFieldEnum: string
{
    case NAME = 'name';
    case DUE_DATE = 'dueDate';
    case CREATED_AT = 'createdAt';
}
