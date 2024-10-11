<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 11:30 AM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Bank\Contracts\BankAcountInterface;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class DepositTransaction implements BankTransactionInterface
{
    public function applyTransaction(BackAccountInterface $b): float
    {
        return 0.0;

    }
    public function getTransactionInfo():string{
        return " ";
    }
    public function getAmount():float{
        return 0.0;
    }
    
   
}
