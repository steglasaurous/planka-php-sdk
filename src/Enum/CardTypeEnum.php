<?php

declare(strict_types=1);

namespace Planka\Bridge\Enum;

enum CardTypeEnum: string
{
    case PROJECT = 'project';
    case STORY = 'story';
}
