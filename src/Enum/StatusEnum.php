<?php

namespace App\Enum;

use App\Beable\Enum\Trumpable;

enum StatusEnum: string
{
    use Trumpable;

    case Done = 'status.done';
    case Feedback = 'status.feedback';
    case NeedReview = 'status.need_review';
    case Pending = 'status.pending';
    case Start = 'status.start';
    case Tested = 'status.tested';
    case ToTest = 'status.to_test';
    case Todo = 'status.todo';
    case UnderTesting = 'status.under_testing';
}
