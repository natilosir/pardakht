<?php

namespace natilosir\pardakht;
use natilosir\orm\db;

class Zibal
{
    private static $merchantKey = ZIBAL_MERCHANT_KEY;
    private static $callbackUrl = ZIBAL_CALLBACK_URL;

    public static function requestPayment($id)
    {
        $amount = self::getAmountById($id);
        if ($amount === false) {
            return false;
        }

        $params = [
            "merchant" => self::$merchantKey,
            "callbackUrl" => self::$callbackUrl,
            "orderId" => $id,
            "amount" => $amount . '0',
        ];

        return self::http('request', $params);
    }

    public static function verifyPayment($trackId)
    {
        $params = [
            "merchant" => self::$merchantKey,
            "trackId" => $trackId,
        ];

        return self::http('verify', $params);
    }

    public static function inquiryPayment($trackId)
    {
        $params = [
            "merchant" => self::$merchantKey,
            "trackId" => $trackId,
        ];

        return self::http('inquiry', $params);
    }

    private static function getAmountById($id)
    {
        $result = DB::table('shoping')->where('ids', $id)->first();
        return $result ? $result['ghay'] : false;
    }

    private static function http($uri, $array = [], $method = 'POST')
    {
        $ch = curl_init();
        $method = strtoupper($method);
        $queryString = is_array($array) && !empty($array) ? http_build_query($array) : '';

        if ($method === 'GET') {
            $url = $queryString ? '?' . $queryString : '';
        } else {
            curl_setopt($ch, CURLOPT_POST, 1);
            if ($queryString) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $queryString);
            }
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }
}

// Main execution
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $rgse = Zibal::requestPayment($id);
    
    if ($rgse && isset($rgse->trackId)) {
        DB::table('shoping')->where('ids', $id)->update(['trackId' => $rgse->trackId]);
        $redirectUrl = 'https://gateway.zibal.ir/start/' . $rgse->trackId;
        header("Location: $redirectUrl");
        exit;
    }
}

if (isset($_GET['trackId'])) {
    $eg = $_GET['trackId'];
    $verificationResult = Zibal::verifyPayment($eg);
    $inquiryResult = Zibal::inquiryPayment($eg);

    if ($inquiryResult && isset($inquiryResult->status)) {
        $orderId = $inquiryResult->orderId;
        $status = $inquiryResult->status;

        if ($status == '1' || $status == '2') {
            DB::table('shoping')->where('ids', $orderId)->update(['page' => '55']);
            header("Location: qf53v3c3e$orderId");
            exit;
        } elseif ($status == '3') {
            DB::table('shoping')->where('ids', $orderId)->update(['page' => '0']);
            header("Location: qf53v3c3e$orderId");
            exit;
        }
    }
}

header("Location: index.php");
exit;
