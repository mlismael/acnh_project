<?php
// Script para configurar la aplicación web
// Establece las variables que indican los directorios de las clases
// Establece las variables para hacer la conexión a la base de datos

// Obtiene la instancia del objeto que guarda los datos de configuración
$config = Config::singleton();

// Carpetas para los Controladores y los Modelos
$config->set('controllersFolder', 'controllers/');
$config->set('modelsFolder', 'models/');

// Parámetros de conexión a la BD
$config->set('dbhost', '127.0.0.1');
$config->set('dbname', 'acnh_project'); 
$config->set('dbuser', 'root');
$config->set('dbpass', '');

// Configuración de Nookipedia (token privado)
$config->set('nookipedia_base_url', 'https://api.nookipedia.com');
$config->set('nookipedia_token', getenv('NOOKIPEDIA_TOKEN') ?: 'c4cc65ef-eac4-4574-8927-5ad618575787');
?>
