<?php

class ColeccionablesUsuarioController
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
        require 'models/ColeccionablesUsuarioModel.php';
        $modelo = new ColeccionablesUsuarioModel();
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

        require 'models/ColeccionablesUsuarioModel.php';
        $modelo = new ColeccionablesUsuarioModel();
        $item = $modelo->getById($_REQUEST['id']);

        if (!$item) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'No encontrado']);
            exit;
        }

        echo json_encode(['status' => 'success', 'data' => $item]);
    }

    public function listarPorUsuario()
    {
        $this->setCorsHeaders();

        if (empty($_REQUEST['id_usuario'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'id_usuario requerido']);
            exit;
        }

        require 'models/ColeccionablesUsuarioModel.php';
        $modelo = new ColeccionablesUsuarioModel();
        echo json_encode(['status' => 'success', 'data' => $modelo->getByUsuario($_REQUEST['id_usuario'])]);
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
        $required = ['id_usuario', 'id_tipo', 'id_api', 'nombre'];
        foreach ($required as $field) {
            if (empty($input[$field])) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => "$field requerido"]);
                exit;
            }
        }

        require 'models/ColeccionablesUsuarioModel.php';
        $modelo = new ColeccionablesUsuarioModel();
        $ok = $modelo->crear(
            $input['id_usuario'],
            $input['id_tipo'],
            $input['id_api'],
            $input['nombre'],
            $input['imagen'] ?? ''
        );

        if ($ok) {
            echo json_encode(['status' => 'success', 'message' => 'Coleccionable creado']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Error al crear']);
        }
    }

    public function actualizar()
    {
        $this->setCorsHeaders();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            exit;
        }

        if (empty($_REQUEST['id'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'ID requerido']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        require 'models/ColeccionablesUsuarioModel.php';
        $modelo = new ColeccionablesUsuarioModel();

        $ok = $modelo->actualizar(
            $_REQUEST['id'],
            $input['id_tipo'] ?? 0,
            $input['id_api'] ?? 0,
            $input['nombre'] ?? '',
            $input['imagen'] ?? ''
        );

        if ($ok) {
            echo json_encode(['status' => 'success', 'message' => 'Coleccionable actualizado']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar']);
        }
    }

    public function eliminar()
    {
        $this->setCorsHeaders();

        if (empty($_REQUEST['id'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'ID requerido']);
            exit;
        }

        require 'models/ColeccionablesUsuarioModel.php';
        $modelo = new ColeccionablesUsuarioModel();

        if ($modelo->eliminar($_REQUEST['id'])) {
            echo json_encode(['status' => 'success', 'message' => 'Coleccionable eliminado']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar']);
        }
    }
}
?>