<?php
session_start();

session_destroy();

$domain = 'https://pxlsoftware.com/logout.php';
header("location: {$domain}");
