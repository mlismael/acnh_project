<?php
// Punto de entrada principal de la aplicación
// Todas las peticiones se enrutan a través de este fichero

session_start();

// Incluimos el FrontController
require 'libs/FrontController.php';

// Iniciamos la aplicación
FrontController::main();
?>
