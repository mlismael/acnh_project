<?php

class TipoColeccionableModel
{
    protected $db;
    private $id;
    private $tipo;
    private $url_api;
    private $descripcion;
    private $fecha_creacion;

    public function __construct()
    {
        $this->db = SPDO::singleton();
    }

    public function getAll()
    {
        $consulta = $this->db->prepare('SELECT * FROM TIPO_COLECCIONABLE');
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $gsent = $this->db->prepare('SELECT * FROM TIPO_COLECCIONABLE WHERE id = ?');
        $gsent->bindParam(1, $id);
        $gsent->execute();
        return $gsent->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($tipo, $url_api, $descripcion)
    {
        try {
            $gsent = $this->db->prepare('INSERT INTO TIPO_COLECCIONABLE (tipo, url_api, descripcion) VALUES (?, ?, ?)');
            $gsent->bindParam(1, $tipo);
            $gsent->bindParam(2, $url_api);
            $gsent->bindParam(3, $descripcion);
            return $gsent->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public function actualizar($id, $tipo, $url_api, $descripcion)
    {
        try {
            $gsent = $this->db->prepare('UPDATE TIPO_COLECCIONABLE SET tipo = ?, url_api = ?, descripcion = ? WHERE id = ?');
            $gsent->bindParam(1, $tipo);
            $gsent->bindParam(2, $url_api);
            $gsent->bindParam(3, $descripcion);
            $gsent->bindParam(4, $id);
            return $gsent->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public function eliminar($id)
    {
        try {
            $gsent = $this->db->prepare('DELETE FROM TIPO_COLECCIONABLE WHERE id = ?');
            $gsent->bindParam(1, $id);
            return $gsent->execute();
        } catch (Exception $e) {
            return false;
        }
    }
}
?>