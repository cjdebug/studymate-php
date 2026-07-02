<?php

// This file stores the base URL of the application.
// For local XAMPP, the default base URL is /studymate.
// For future deployment, APP_BASE_URL can be set as an environment variable.

$base_url = getenv('APP_BASE_URL');

if ($base_url === false) {
    $base_url = '/studymate';
}

$base_url = rtrim($base_url, '/');