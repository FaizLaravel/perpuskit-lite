<?php

namespace App\Services;

use App\Models\Loan;
use Illuminate\Http\Request;

class MyRequestService
{
    public function cancel(int $loanId, int $userId): void
    {
        $loan = Loan::where('id', $loanId)
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->first();

        if (!$loan) {
            throw new \Exception('Loan cannot be cancelled.');
        }

        $loan->update([
            'status' => 'dibatalkan',
        ]);
    }
}
