<?php

declare(strict_types=1);

namespace Planka\Bridge\Enum;

enum NotificationTypeEnum: string
{
    case MOVE_CARD = 'moveCard';
    case COMMENT_CARD = 'commentCard';
    case ADD_MEMBER_TO_CARD = 'addMemberToCard';
    case MENTION_IN_COMMENT = 'mentionInComment';
}
