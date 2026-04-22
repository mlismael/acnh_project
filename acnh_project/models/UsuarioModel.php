<?php

// Modelo Usuario: gestiona la autenticación y datos de usuarios
class UsuarioModel
{
    // Conexión a la BD
    protected $db;

    // Atributos del objeto usuario
    private $codigo;
    private $login;
    private $password;
    private $email;

    // Constructor
    public function __construct()
    {
        $this->db = SPDO::singleton();
    }

    // ===== GETTERS Y SETTERS =====
    public function getCodigo()
    {
        return $this->codigo;
    }
    public function setCodigo($codigo)
    {
        return $this->codigo = $codigo;
    }

    public function getLogin()
    {
        return $this->login;
    }
    public function setLogin($login)
    {
        return $this->login = $login;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        return $this->email = $email;
    }

    // ===== MÉTODOS DE BD =====

    public function getAll()
    {
        $consulta = $this->db->prepare('SELECT id, username, email, nombre_isla, fecha_registro, fecha_actualizacion, activo FROM USUARIO');
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $gsent = $this->db->prepare('SELECT id, username, email, nombre_isla, fecha_registro, fecha_actualizacion, activo FROM USUARIO WHERE id = ?');
        $gsent->bindParam(1, $id);
        $gsent->execute();
        return $gsent->fetch(PDO::FETCH_ASSOC);
    }

    public function getByLogin($login)
    {
        $gsent = $this->db->prepare('SELECT id, username, email, password, nombre_isla, fecha_registro, fecha_actualizacion, activo FROM USUARIO WHERE username = ?');
        $gsent->bindParam(1, $login);
        $gsent->execute();
        return $gsent->fetch(PDO::FETCH_ASSOC);
    }

    // Método para autenticar un usuario
    public function autenticar($login, $password): bool
    {
        $gsent = $this->db->prepare('SELECT * FROM USUARIO WHERE login = ? AND password = ?');
        $gsent->bindParam(1, $login);
        $password_encrypt = sha1($password);
        $gsent->bindParam(2, $password_encrypt);
        $gsent->execute();

        $resultado = $gsent->fetch();
        return ($resultado !== false);
    }

    // Método para crear un nuevo usuario
    public function crear($login, $password, $email): bool
    {
        try {
            $password_encrypt = sha1($password);
            $gsent = $this->db->prepare('INSERT INTO USUARIO (login, password, email) VALUES (?, ?, ?)');
            $gsent->bindParam(1, $login);
            $gsent->bindParam(2, $password_encrypt);
            $gsent->bindParam(3, $email);
            return $gsent->execute();
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
