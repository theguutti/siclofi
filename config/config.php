<?php
    define('BASE_URL', 'http://localhost/siclofi/');
    define('SITE_NAME', 'SICLOFI');

    date_default_timezone_set('America/Sao_Paulo');

    header('Content-Type: text/html; charset=utf-8');
    mb_internal_encoding('UTF-8');

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
