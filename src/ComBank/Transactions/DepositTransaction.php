<?php

namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 11:30 AM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Bank\Contracts\BankAcountInterface;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use ComBank\Exceptions\ZeroAmountException;

class DepositTransaction extends BaseTransaction implements BankTransactionInterface
{
    public function __construct(float $amount)
    {
        $this->date = date("l jS \of F Y h:i:s A",time());
        if ($amount > 0.00) {
            $this->amount = $amount;
        } else {
            throw new ZeroAmountException("invalidAmountProvider");
        }
    }
    public function applyTransaction(BackAccountInterface $b): float
    {
        return ($b->getBalance() + $this->amount);
    }
    public function getTransactionInfo(): string
    {
        return "DEPOSIT_TRANSACTION";
    }
    public function getAmount(): float
    {
        return $this->amount;
    }
}
