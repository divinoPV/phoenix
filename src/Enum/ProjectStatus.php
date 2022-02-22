<?php

namespace App\Enum;

enum ProjectStatus: string
{
    case DONE = 'enum.status.done';
    case FEEDBACK = 'enum.status.feedback';
    case NEED_REVIEW = 'enum.status.need_review';
    case PENDING = 'enum.status.pending';
    case START = 'enum.status.start';
    case TESTED = 'enum.status.tested';
    case TO_TEST = 'enum.status.to_test';
    case TODO = 'enum.status.todo';
    case UNDER_TESTING = 'enum.status.under_testing';
}
