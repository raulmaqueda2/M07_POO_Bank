<?php

namespace ComBank\Bank;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:25 PM
 */
use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\BankNacionalToInternacionalException;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use PhpParser\Node\Expr\Throw_;
use PhpParser\Node\Stmt\If_;
use ComBank\Bank\Interfaces\BankAccountInterface;
use Serializable;
use ComBank\ApiCalls\api;


class BankAccount implements BackAccountInterface, Serializable
{

    private $balance;
    private $status;
    private $overdraft;
    private $international = false;

    public function __construct(float $balance, bool $international = false)
    {
        $this->balance = $balance;
        $this->status = BankAccount::STATUS_OPEN;
        $this->overdraft = new NoOverdraft();
        $this->international = $international;

    }

    public function transaction(BankTransactionInterface $a): void
    {
        if (!($this->status == BankAccount::STATUS_OPEN)) {
            throw new BankAccountException("exception because the account is closed");
        }
        try {
            $this->balance = ($a->applyTransaction($this));
        } catch (\Throwable $th) {
            throw new FailedTransactionException("failed transaction due to overdraft");
        }
    }
    public function openAccount(): bool
    {
        return $this->status != BankAccount::STATUS_CLOSED;
    }
    public function reopenAccount(): void
    {
        if (($this->status == BankAccount::STATUS_OPEN)) {
            throw (new BankAccountException("exception because the account is already open"));
        }
        $this->status = BankAccount::STATUS_OPEN;
    }
    public function closeAccount(): void
    {
        if (($this->status == BankAccount::STATUS_CLOSED)) {
            throw (new BankAccountException("exception because the account is already closed"));
        }
        $this->status = BankAccount::STATUS_CLOSED;
    }
    public function getBalance(): float
    {
        return $this->balance;
    }
    public function getBalanceEur(): string
    {
        return "$this->balance" . "€";
    }
    public function getBalanceDolar(): string
    {
        if ($this->international == false) {
            throw (new BankNacionalToInternacionalException("error"));
        }
        return (new api())->toDolars($this->balance) . "$";
    }
    public function getOverdraft(): OverdraftInterface
    {

        return $this->overdraft;
    }
    public function applyOverdraft(OverdraftInterface $a): void
    {
        $this->overdraft = $a;
    }
    public function setBalance(float $a): void
    {
        $this->balance = $a;
    }
    public function serialize()
    {
        if ($this->international) {
            return serialize([
                'balanceEur' => $this->balance,
                'balanceUsd' => changeUsd($this->balance)
            ]);
        }
        return serialize([
            'balance' => $this->balance
        ]);
    }
    public function unserialize($data)
    {
        $unserializedData = unserialize($data);
        $this->balance = $unserializedData['balance'];
    }


}
