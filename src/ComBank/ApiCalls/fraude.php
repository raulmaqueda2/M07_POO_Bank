<?php
namespace ComBank\ApiCalls;
require_once '../../../vendor/autoload.php';
use ComBank\Transactions\Contracts\BankTransactionInterface;
use ComBank\Transactions\DepositTransaction;

function checkFraudeTransaction(BankTransactionInterface $transacion): bool
{
    $amount = $transacion->getAmount();
    $transacion = $transacion->getTransactionInfo() == "DEPOSIT_TRANSACTION" ? "extraer" : "depositar";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://api-fraude.onrender.com/?tipo=$transacion&cantidad=$amount");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = json_decode(curl_exec($curl));
    $isValid = ($response->fraude) > 80;
    return $isValid;
}
//print (checkFraudeTransaction(new DepositTransaction(80)));

