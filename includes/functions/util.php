<?php

function escapeOutput(string $string): string
{
    $safeString = str_replace(['<', '>', '&'], ['&lt;', '&gt;', '&amp;'], $string);
    return nl2br($safeString);
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

        // Automatically validate any field ending with "_id" as an integer
        if (str_ends_with($key, '_id') && !filter_var($value, FILTER_VALIDATE_INT)) {
            $error .= "$key must be a valid number!<br>";
        }
    }

    return $error ?: "";
}
