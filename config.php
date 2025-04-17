<?php
$host = $_SERVER['HTTP_HOST'];
$port = $_SERVER['SERVER_PORT'];

if ($host === 'localhost' && $port === '80') {
    $BASE_URL = '/mybook';
} else {
    $BASE_URL = '';
}
