<?php

// ============================
// CONFIGURACIÓN GENERAL
// ============================

// Email para la API de OpenAlex (buena práctica)
define("OPENALEX_EMAIL", "rpruiz33@gmail.com");

// URL base del proyecto (opcional pero útil)
define("BASE_URL", "http://localhost/tp1");

// Activar modo debug (true = muestra errores)
define("DEBUG", true);

// ============================
// CONFIGURACIÓN DE ERRORES
// ============================

if (DEBUG) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
}