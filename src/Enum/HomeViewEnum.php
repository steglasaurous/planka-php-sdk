<?php

declare(strict_types=1);

namespace Planka\Bridge\Enum;

enum HomeViewEnum: string
{
    case GRID_PROJECTS = 'gridProjects';
    case GROUPED_PROJECTS = 'groupedProjects';
}
