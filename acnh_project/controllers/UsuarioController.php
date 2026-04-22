<?php

class UsuarioController
{
    private function setCorsHeaders()
    {
        header('Access-Control-Allow-Origin: http://localhost:4200');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        header('Access-Control-Allow-Credentials: true');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }
    }

    public function listar()
    {
        $this->setCorsHeaders();

        require 'models/UsuarioModel.php';
        $modelo = new UsuarioModel();
        echo json_encode(['status' => 'success', 'data' => $modelo->getAll()]);
    }

    public function ver()
    {
        $this->setCorsHeaders();

        if (empty($_REQUEST['id'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'ID requerido']);
            exit;
        }

        require 'models/UsuarioModel.php';
        $modelo = new UsuarioModel();
        $user = $modelo->getById($_REQUEST['id']);

        if (!$user) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado']);
            exit;
        }

        echo json_encode(['status' => 'success', 'data' => $user]);
    }

    public function crear()
    {
        $this->setCorsHeaders();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $required = ['username', 'email', 'password'];

        foreach ($required as $field) {
            if (empty($input[$field])) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => "$field requerido"]);
                exit;
            }
        }

        require 'models/UsuarioModel.php';
        $modelo = new UsuarioModel();

        $hashedPassword = password_hash($input['password'], PASSWORD_BCRYPT);
        $ok = $modelo->crear($input['username'], $hashedPassword, $input['email']);

        if ($ok) {
            echo json_encode(['status' => 'success', 'message' => 'Usuario creado']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Error al crear usuario']);
        }
    }
}
?>