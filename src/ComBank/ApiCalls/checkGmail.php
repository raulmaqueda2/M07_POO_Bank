<?php
function checkGmail(string $email):bool{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://emailvalidation.abstractapi.com/v1/?api_key=3a3fbc89a0804b6d97750d4b9f4c2b8f&email=$email");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = json_decode(curl_exec($curl));
    $isValid = ($response->quality_score)*100 > 80;
    return $isValid;
}

