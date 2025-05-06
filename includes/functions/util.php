<?php

function escapeOutput(string $string): string
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function redirectBackWithParam($key, $value)
{
    $referer = $_SERVER['HTTP_REFERER'];
    $urlParts = parse_url($referer);

    // Keep path + query separately
    $baseUrl = $urlParts['path'];
    parse_str($urlParts['query'] ?? '', $queryParams);

    // Replace or add `request`
    $queryParams[$key] = $value;

    // Build final redirect
    $finalUrl = $baseUrl . '?' . http_build_query($queryParams);

    return $finalUrl;
}


function validateFields($data)
{
    $error = '';
    foreach ($data as $key => $value) {
        if (empty($value)) {
            $error .= "$key is empty!<br>";
        }
    }

    return $error ?: "";
}
