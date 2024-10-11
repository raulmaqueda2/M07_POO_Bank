<?php

namespace ComBank\Bank;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:25 PM
 */

use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class BankAccount implements BackAccountInterface {
    private $balance;
    private $status;
    private $overdraft;

    public function transaction(BankTransactionInterface $a): void{



    }
    public function openAccount(): bool{

        return false;
    }
    public function reopenAccount(): void{
        $this->status = $GLOBALS['STATUS_OPEN'];
    }
    public function closeAccount(): void{
        $this->status = $GLOBALS['STATUS_CLOSED'];
    }
    public function getBalance(): float{

        return $this->balance;
    }
    public function getOverdraft(): OverdraftInterface{

        return new OverdraftInterface;
    }
    public function applyOverdraft(OverdraftInterface $a): void{
        $this->overdraft = $a;
    }
    public function setBalance(float $a): void{
        $this->balance = $a;
    }

}
