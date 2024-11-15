<?php
use PHPUnit\Framework\TestCase;
use ComBank\Bank\BankAccount;
use ComBank\Transactions\DepositTransaction;

use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\OverdraftStrategy\SilverOverdraft;
use ComBank\Exceptions\BankAccountException;
use ComBank\Bank\Contracts\BankAccountInterface;
use ComBank\Transactions\WithdrawTransaction;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\Exceptions\BankNacionalToInternacionalException;
use ComBank\Exceptions\FailedCreateAccountException;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:47 PM
 */

class curlTest extends TestCase
{

    //Test euro
    /**
     * @test
     * */
    public function testVerifyNacionalReturnsInEuro()
    {
        $bankAccount = new BankAccount(150.0, false);
        $this->assertEquals("150€", $bankAccount->getBalanceEur());
    }

    /**
     * @test
     * */
    public function testVerifyInternacionalReturnsInEuro()
    {
        $bankAccount = new BankAccount(150.0, true);
        $this->assertEquals("150€", $bankAccount->getBalanceEur());
    }
    /**
     * @test
     * */
    //Test euro


    //Test dolar

    public function testVerifyInternacionalReturnsInDolar()
    {
        $bankAccount = new BankAccount(150.0, true);
        $this->assertMatchesRegularExpression('/[€$]$/', $bankAccount->getBalanceDolar(), "El valor esperado no contiene un símbolo de moneda");
    }
    /**
     * @test
     * 
     * */
    public function testVerifyNacionalReturnsInDolar()
    {
        $this->expectException(BankNacionalToInternacionalException::class);
        $bankAccount = new BankAccount(150.0, international: false);
        $bankAccount->getBalanceDolar();
    }
    /**
     * @test
     */
    //Test dolar

    //Test email

    public function testEmailValid()
    {
        //$bankAccount = new BankAccount(150.0, false, "raulmaqueda2004@gmail.com");
        //  $this->assertEquals("raulmaqueda2004@gmail.com", $bankAccount->getEmail());
    }

    public function testEmailInvalid()
    {
        // $this->expectException(FailedCreateAccountException::class);
        //   $bankAccount = new BankAccount(150.0, false, "email@gmail.com");

    }
    //Test email

    //Test Deposit fraude
    public function TestDepositFraudFuncuonalityAllow()
    {
        $bankAccount = new BankAccount(150.0);
        $bankAccount->transaction(new DepositTransaction(30));
    }
    public function TestDepositFraudFuncuonalityDeny()
    {
        $this->expectException(FailedCreateAccountException::class);
        $bankAccount = new BankAccount(250.0);
        $bankAccount->transaction(new DepositTransaction(200));
    }
    //Test Deposit fraude
    //Test Withdraw fraude
    public function TestWithdrawFraudFuncuonalityAllow()
    {
        $bankAccount = new BankAccount(150.0);
        $bankAccount->transaction(new WithdrawTransaction(30));
    }
    public function TestWithdrawFraudFuncuonalityDeny()
    {
        $this->expectException(FailedCreateAccountException::class);
        $bankAccount = new BankAccount(250.0);
        $bankAccount->transaction(new WithdrawTransaction(200));
    }
    //Test Withdraw fraude

}