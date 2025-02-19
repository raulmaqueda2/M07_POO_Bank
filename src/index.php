<?php

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:24 PM
 */

use ComBank\Bank\BankAccount;
use ComBank\OverdraftStrategy\SilverOverdraft;
use ComBank\Transactions\DepositTransaction;
use ComBank\Transactions\WithdrawTransaction;
use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\ZeroAmountException;

require_once 'bootstrap.php';


//---[Bank account 1]---/
// create a new account1 with balance 400
$bankAccount1 = new BankAccount(400);
pl('--------- [Start testing bank account #1, No overdraft] --------');
try {
    // show balance account

    // close account

    // reopen account


    // deposit +150 
    pl('Doing transaction deposit (+150) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new DepositTransaction(150.0));
    pl('My new balance after deposit (+150) : ' . $bankAccount1->getBalance());

    // withdrawal -25
    pl('Doing transaction withdrawal (-25) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new WithdrawTransaction(25.0));

    pl('My new balance after withdrawal (-25) : ' . $bankAccount1->getBalance());

    // withdrawal -600
    pl('Doing transaction withdrawal (-600) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new WithdrawTransaction(600.0));

} catch (ZeroAmountException $e) {
    pl($e->getMessage());
} catch (BankAccountException $e) {
    pl($e->getMessage());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount1->getBalance());




//---[Bank account 2]---/
pl('--------- [Start testing bank account #2, Silver overdraft (100.0 funds)] --------');
try {
    $bankAccount2 = new BankAccount(200);
    $bankAccount2->applyOverdraft(new SilverOverdraft());

    // show balance account
   
    // deposit +100
    pl('Doing transaction deposit (+100) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new DepositTransaction(100.0));

    pl('My new balance after deposit (+100) : ' . $bankAccount2->getBalance());

    // withdrawal -300
    pl('Doing transaction deposit (-300) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(300.0));

    pl('My new balance after withdrawal (-300) : ' . $bankAccount2->getBalance());

    // withdrawal -50
    pl('Doing transaction deposit (-50) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(50.0));

    pl('My new balance after withdrawal (-50) with funds : ' . $bankAccount2->getBalance());

    // withdrawal -120
    pl('Doing transaction withdrawal (-120) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(120.0));

} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount2->getBalance());

try {
    $bankAccount2->transaction(new WithdrawTransaction(20.0));
    pl('Doing transaction withdrawal (-20) with current balance : ' . $bankAccount2->getBalance());

} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My new balance after withdrawal (-20) with funds : ' . $bankAccount2->getBalance());

pl('Closse account ');
$bankAccount2->closeAccount();


try {
    pl('re Closse account' .$bankAccount2->closeAccount());

    ;

} catch (BankAccountException $e) {
    pl($e->getMessage());
}
