<?php

// Controlador de autenticación y aplicación general
class AppController 
{
    // ===== ACCIONES DE AUTENTICACIÓN =====

    // Método para login
    public function login()
    {
        require 'models/UsuarioModel.php';
        
        $respuesta = ['status' => 'error', 'message' => ''];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($input['login']) || !isset($input['password'])) {
                $respuesta['message'] = 'Login y password requeridos';
                http_response_code(400);
                echo json_encode($respuesta);
                exit;
            }

            $usuario = new UsuarioModel();
            $usuario_existe = $usuario->getByLogin($input['login']);

            if (!$usuario_existe) {
                $respuesta['message'] = 'Usuario no existe';
                http_response_code(401);
                echo json_encode($respuesta);
                exit;
            }

            if ($usuario->autenticar($input['login'], $input['password'])) {
                $_SESSION['usuario_app'] = $input['login'];
                $_SESSION['usuario_codigo'] = $usuario_existe->getCodigo();
                
                $respuesta['status'] = 'success';
                $respuesta['message'] = 'Login exitoso';
                $respuesta['usuario'] = $input['login'];
                http_response_code(200);
                echo json_encode($respuesta);
                exit;
            } else {
                $respuesta['message'] = 'Contraseña incorrecta';
                http_response_code(401);
                echo json_encode($respuesta);
                exit;
            }
        }

        $respuesta['message'] = 'Método no permitido';
        http_response_code(405);
        echo json_encode($respuesta);
    }

    // Método para logout
    public function logout()
    {
        session_start();
        session_destroy();
        
        echo json_encode(['status' => 'success', 'message' => 'Sesión cerrada']);
    }

    // Método para verificar si el usuario está autenticado
    public function verificarSesion()
    {
        if (isset($_SESSION['usuario_app'])) {
            echo json_encode([
                'status' => 'success',
                'autenticado' => true,
                'usuario' => $_SESSION['usuario_app']
            ]);
        } else {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'autenticado' => false,
                'message' => 'No autenticado'
            ]);
        }
    }

    // Método index
    public function index()
    {
        echo json_encode([
            'status' => 'success',
            'message' => 'API REST - ACNH Project',
            'version' => '1.0'
        ]);
    }
}
?>
