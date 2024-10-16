<?php

namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface
{
    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    public function applyTransaction(BackAccountInterface $b): float
    {
        if ((($b->getOverdraft()->getOverdraftFundsAmount() + ($b->getBalance())) - ($this->amount)) >= 0) {
            return ($b->getBalance() - $this->amount);
        }
        throw new FailedTransactionException("failed transaction due to overdraft ");
    }
    public function getTransactionInfo(): string
    {
        return " ";
    }
    public function getAmount(): float
    {
        return $this->amount;
    }
}
