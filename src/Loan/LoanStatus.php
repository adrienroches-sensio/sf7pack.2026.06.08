<?php

declare(strict_types=1);

namespace App\Loan;

enum LoanStatus: string
{
    case Pending = 'pending';
}
