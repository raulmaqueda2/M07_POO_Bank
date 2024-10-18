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
use ComBank\Exceptions\ZeroAmountException;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface
{
    public function __construct(float $amount)
    {
        if ($amount > 0.00) {
            $this->amount = $amount;
        } else {
            throw new ZeroAmountException("invalidAmountProvider");
        }
    }

    public function applyTransaction(BackAccountInterface $b): float
    {
        if ((($b->getOverdraft()->getOverdraftFundsAmount() + ($b->getBalance())) - ($this->amount)) >= 0) {
            return ($b->getBalance() - $this->amount);
        }
        throw new InvalidOverdraftFundsException("failed transaction due to overdraft ");
    }
    public function getTransactionInfo(): string
    {
        return "WITHDRAW_TRANSACTION";
    }
    public function getAmount(): float
    {
        return $this->amount;
    }
}
