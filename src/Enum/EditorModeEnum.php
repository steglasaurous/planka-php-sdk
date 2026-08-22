<?php

declare(strict_types=1);

namespace Planka\Bridge\Enum;

enum EditorModeEnum: string
{
    case WYSIWYG = 'wysiwyg';
    case MARKUP = 'markup';
}
