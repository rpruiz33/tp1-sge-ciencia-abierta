<?php
define("OPENALEX_EMAIL", "rpruiz33@gmail.com");
define("BASE_URL", "http://localhost/tp1");
define("DEBUG", true);
if (DEBUG) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
}