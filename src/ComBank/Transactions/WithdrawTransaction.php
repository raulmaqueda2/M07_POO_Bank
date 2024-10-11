<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class WithdrawTransaction implements BankTransactionInterface 
{
    public function applyTransaction(BackAccountInterface $b): float
    {
        return 0.0;

    }
    public function getTransactionInfo():string{
        return " ";
    }
    public function getAmount():float{
        $$amount;
    }
   
}
