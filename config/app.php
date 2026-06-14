<?php

// This file stores the base URL for local XAMPP.
// when deploying to Railway, using APP_BASE_URL.
$base_url = getenv('APP_BASE_URL');

if ($base_url === false) {
    $base_url = '/studymate';
}

$base_url = rtrim($base_url, '/');