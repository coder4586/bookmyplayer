<?php

if (!function_exists('getB2AuthToken')) {
    function getB2AuthToken()
    {
        $accountId = env('B2_KEY_ID');
        $applicationKey = env('B2_APPLICATION_KEY');
        
        $credentials = base64_encode($accountId . ':' . $applicationKey);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.backblazeb2.com/b2api/v2/b2_authorize_account');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . $credentials
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
}