<?php

namespace App\Business\Enum;

enum PostEventState
{
    case ONSAVE;
    case ONUPDATE;
    case ONDELETE;
}