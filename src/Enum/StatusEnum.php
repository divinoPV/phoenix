<?php

namespace App\Enum;

enum StatusEnum: string
{
    case Done = 'enum.status.done';
    case Feedback = 'enum.status.feedback';
    case NeedReview = 'enum.status.need_review';
    case Pending = 'enum.status.pending';
    case Start = 'enum.status.start';
    case Tested = 'enum.status.tested';
    case ToTest = 'enum.status.to_test';
    case Todo = 'enum.status.todo';
    case UnderTesting = 'enum.status.under_testing';
}
