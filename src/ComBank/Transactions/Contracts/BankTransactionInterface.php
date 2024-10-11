<?php namespace ComBank\Transactions\Contracts;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:29 PM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\InvalidOverdraftFundsException;

interface BankTransactionInterface
{
    public function applyTransaction(BackAccountInterface $b):float;
    public function getTransactionInfo():string;
    public function getAmount():float;

}
