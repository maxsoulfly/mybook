<?php

function escapeOutput(string $string): string
{
    $safeString = str_replace(['<', '>', '&'], ['&lt;', '&gt;', '&amp;'], $string);
    return nl2br($safeString);
}
function safeOutput($value)
{
    return htmlspecialchars($value ?? '');
}
function redirectBackWithParam($key, $value)
{
    $referer = $_SERVER['HTTP_REFERER'];
    $urlParts = parse_url($referer);

    // Keep path + query separately
    $baseUrl = $urlParts['path'];
    parse_str($urlParts['query'] ?? '', $queryParams);

    // Update or add the provided parameter
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


function resizeAndCropImage(string $sourcePath, string $destinationPath, int $targetWidth, int $targetHeight): bool
{
    $info = getimagesize($sourcePath);
    if (!$info) return false;

    [$width, $height, $type] = $info;

    switch ($type) {
        case IMAGETYPE_JPEG:
            $src = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $src = imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_WEBP:
            $src = imagecreatefromwebp($sourcePath);
            break;
        default:
            return false;
    }

    // Original aspect ratio
    $srcAspect = $width / $height;
    $targetAspect = $targetWidth / $targetHeight;

    // Crop to center based on aspect ratio
    if ($srcAspect > $targetAspect) {
        // Wider: crop sides
        $newWidth = $height * $targetAspect;
        $srcX = ($width - $newWidth) / 2;
        $srcY = 0;
        $cropWidth = $newWidth;
        $cropHeight = $height;
    } else {
        // Taller: crop top/bottom
        $newHeight = $width / $targetAspect;
        $srcX = 0;
        $srcY = ($height - $newHeight) / 2;
        $cropWidth = $width;
        $cropHeight = $newHeight;
    }

    $dst = imagecreatetruecolor($targetWidth, $targetHeight);
    imagecopyresampled($dst, $src, 0, 0, $srcX, $srcY, $targetWidth, $targetHeight, $cropWidth, $cropHeight);

    // Save as JPEG
    return imagejpeg($dst, $destinationPath, 90);
}


function timeAgoShort(string $datetime): string
{
    $timestamp = strtotime($datetime);
    if ($timestamp === false) return '';

    $diff = time() - $timestamp;
    if ($diff < 60) {
        return $diff . 's';
    } elseif ($diff < 3600) {
        return floor($diff / 60) . 'm';
    } elseif ($diff < 86400) {
        return floor($diff / 3600) . 'h';
    } else {
        return floor($diff / 86400) . 'd';
    }
}
