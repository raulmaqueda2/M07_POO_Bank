<?php
namespace ComBank\ApiCalls;

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



}