<?php


function http($uri, $array = [], $method = 'POST')
{
    // Initialize a cURL session
    $ch = curl_init();

    // Convert the method to uppercase to avoid case-sensitivity issues
    $method = strtoupper($method);

    // Ensure the array is not empty, or use an empty string as query
    $queryString = is_array($array) && ! empty($array) ? http_build_query($array) : '';

    // Configure URL and method-specific settings
    if ($method === 'GET') {
        $url = $queryString ? '?'.$queryString : '';
    } else {
        // Default to POST
        curl_setopt($ch, CURLOPT_POST, 1);
        if ($queryString) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $queryString);
        }
    }

    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $url);

    // Common cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Execute the cURL session and fetch the response
    $response = curl_exec($ch);

    // Close the cURL session
    curl_close($ch);

    // Return the decoded JSON response
    return json_decode($response);
}
