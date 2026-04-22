<?php

class TipoColeccionableController
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
        require 'models/TipoColeccionableModel.php';

        $modelo = new TipoColeccionableModel();
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

        require 'models/TipoColeccionableModel.php';
        $modelo = new TipoColeccionableModel();
        $item = $modelo->getById($_REQUEST['id']);

        if (!$item) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'No encontrado']);
            exit;
        }

        echo json_encode(['status' => 'success', 'data' => $item]);
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
        if (empty($input['tipo']) || empty($input['url_api'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'tipo y url_api requeridos']);
            exit;
        }

        require 'models/TipoColeccionableModel.php';
        $modelo = new TipoColeccionableModel();

        $ok = $modelo->crear($input['tipo'], $input['url_api'], $input['descripcion'] ?? '');

        if ($ok) {
            echo json_encode(['status' => 'success', 'message' => 'Tipo de coleccionable creado']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Error al crear tipo']);
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
        require 'models/TipoColeccionableModel.php';
        $modelo = new TipoColeccionableModel();

        $ok = $modelo->actualizar(
            $_REQUEST['id'],
            $input['tipo'] ?? '',
            $input['url_api'] ?? '',
            $input['descripcion'] ?? ''
        );

        if ($ok) {
            echo json_encode(['status' => 'success', 'message' => 'Tipo de coleccionable actualizado']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Error al actualizar tipo']);
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

        require 'models/TipoColeccionableModel.php';
        $modelo = new TipoColeccionableModel();

        if ($modelo->eliminar($_REQUEST['id'])) {
            echo json_encode(['status' => 'success', 'message' => 'Tipo de coleccionable eliminado']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Error al eliminar tipo']);
        }
    }
}
?>