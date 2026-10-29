<?php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPassword = '';
$dbName = 'userregistration';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$con = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
$con->set_charset('utf8mb4');
