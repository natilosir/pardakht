<?php

namespace natilosir\pardakht;
use natilosir\orm\db;

class zarinpal
{
    private static $merchantId = ""; // Merchant ID should be set here
    private static $callbackUrl = "callbackzarinpal.php";

    public static function initiatePayment($cst)
    {
        if (!$cst) {
            header("location: /");
            exit;
        }

        $item = self::getItem($cst);
        if (!$item) {
            header("location: /");
            exit;
        }

        $amount = $item['ghay'] . '0';
        $data = [
            "merchant_id" => self::$merchantId,
            "amount" => $amount,
            "callback_url" => self::$callbackUrl,
            "description" => $cst
        ];

        $response = self::http('https://api.zarinpal.com/pg/v4/payment/request.json', $data);
        
        if (isset($response->errors)) {
            echo 'Error Code: ' . $response->errors->code;
            echo '<br>Message: ' . $response->errors->message . '<br><br>';
            return;
        }

        if ($response->data->code == 100) {
            self::updateTrackId($cst, $response->data->authority);
            header("location: https://www.zarinpal.com/pg/StartPay/" . $response->data->authority);
            exit;
        }
    }

    private static function getItem($cst)
    {
        return DB::Table('shoping')->where('ids', $cst)->where('page', '<', 7)->first();
    }

    private static function updateTrackId($cst, $authority)
    {
        return DB::Table('shoping')->where('ids', $cst)->update(['trackId' => $authority]);
    }

    private static function http($uri, $data = [], $method = 'POST')
    {
        $ch = curl_init();
        $method = strtoupper($method);
        $jsonData = json_encode($data);

        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ]);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        }

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }
}

// استفاده از کلاس
$cst = $_GET['id'] ?? null;
zarinpal::initiatePayment($cst);
?>
