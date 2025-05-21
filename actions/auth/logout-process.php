<?php
session_start();

include_once __DIR__ . '/../../config.php';
include_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/db.php';

session_start(); //  access the session.
session_unset(); // remove all session variables.
session_destroy(); // to fully kill the session.



header('Location: ' . $BASE_URL . '/pages/login.php');
exit;
