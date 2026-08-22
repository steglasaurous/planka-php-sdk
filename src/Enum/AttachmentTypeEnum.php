<?php

declare(strict_types=1);

namespace Planka\Bridge\Enum;

enum AttachmentTypeEnum: string
{
    case FILE = 'file';
    case LINK = 'link';
}
