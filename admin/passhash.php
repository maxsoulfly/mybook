<?php
$passwords = ['fakepass1', 'fakepass1', 'fakepass1', 'fakepass1', 'fakepass1'];

echo "<pre>";
foreach ($passwords as $password) {
    echo $password . ' => ' . password_hash($password, PASSWORD_DEFAULT) . PHP_EOL;
}


echo "</pre>";