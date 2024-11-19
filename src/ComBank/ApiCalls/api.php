<?php
namespace ComBank\ApiCalls;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use ComBank\Transactions\DepositTransaction;

class api
{
    public function __construct()
    {
    }
    public function toDolars($eur)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://latest.currency-api.pages.dev/v1/currencies/eur.json");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl));
        $valDolar = $response->eur->usd;
        $dolar = $eur * $valDolar;
        return $dolar;
    }
    public function validEmail($email): bool
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://emailvalidation.abstractapi.com/v1/?api_key=3a3fbc89a0804b6d97750d4b9f4c2b8f&email=$email");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl));
        $isValid = ($response->quality_score) * 100 > 75;
        curl_close($curl);
        return $isValid;
    }

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

    function ultimaTransacion(): mixed
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://getpantry.cloud/apiv1/pantry/9699a76f-d96e-485c-ba83-4e153bb85420");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curl));
        return $response->baskets;
    }

    function postTransaction(BankTransactionInterface $transacion): void
    {
        $Tipotransacion = $transacion->getTransactionInfo() == "DEPOSIT_TRANSACTION" ? "extraer" : "depositar";
        $post = json_encode(array(
            'tipo' => "$Tipotransacion",
            'cantidad' => $transacion->getAmount(),
        ));
        $curl = curl_init("https://getpantry.cloud/apiv1/pantry/9699a76f-d96e-485c-ba83-4e153bb85420/basket/transacion");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($post)
        ));
        $response = curl_exec($curl);
    }

}