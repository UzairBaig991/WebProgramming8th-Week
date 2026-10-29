<?php
require_once __DIR__ . '/db.php';

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function post($key)
{
    return trim(isset($_POST[$key]) ? $_POST[$key] : '');
}

function saveError($exception)
{
    error_log($exception->getMessage());
    return (int) $exception->getCode() === 1062
        ? 'This record already exists.'
        : 'Could not save the record. Check your entries and database setup.';
}
