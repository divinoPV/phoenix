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

    public function color(): string
    {
        return match ($this->value) {
            'status.done' => 'done',
            'status.feedback' => 'feedback',
            'status.need_review' => 'need_review',
            'status.pending' => 'pending',
            'status.start' => 'start',
            'status.tested' => 'tested',
            'status.to_test' => 'to_test',
            'status.todo' => 'todo',
            'status.under_testing' => 'under_testing'
        };
    }

    public function placement(): string
    {
        return match ($this->value) {
            'status.done' => 1,
            'status.feedback' => 2,
            'status.need_review' => 3,
            'status.pending' => 4,
            'status.start' => 5,
            'status.tested' => 6,
            'status.to_test' => 7,
            'status.todo' => 8,
            'status.under_testing' => 9
        };
    }
}
