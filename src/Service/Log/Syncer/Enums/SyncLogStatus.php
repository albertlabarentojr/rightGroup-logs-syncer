<?php

namespace App\Service\Log\Syncer\Enums;

enum SyncLogStatus: string
{
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';
}
