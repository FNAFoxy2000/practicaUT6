<?php

class BD
{
    private static $destino = "mysql:host=localhost;dbname=Configurador_Ordenadores;charset=utf8mb4";
    private static $user = "root";
    private static $password = "";
    private static $conn = null;


    public static function Conectar()
    {
        try {
            // Crear conexion PDO
            self::$conn = new PDO(BD::$destino, BD::$user, BD::$password);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Conectado :)<br>";
        } catch (PDOException $e) {
            echo "Error en la conexion: " . $e->getMessage();
        }
        return self::$conn;
    }

    // Método para cerrar la conexión
    public static function CerrarConexion()
    {
        self::$conn = null;
    }

    // REGISTRAR
    public static function RegistrarUsuario($usuario, $password, $email): bool
    {
        try {
            $sql = "INSERT INTO usuario (usuario_nombre, password, email) VALUES (:usuario, :password, :email)";
            $passwordCifrada = password_hash($password, PASSWORD_DEFAULT); // Hasheamos el password
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':password', $passwordCifrada);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error al registrar usuario: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }

    // INICIAR SESION
    public static function Login($usuario, $password): bool
    {
        try {
            // Crear la consulta SQL
            $sql = "SELECT password FROM usuario WHERE usuario_nombre = :usuario";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();

            // Verificar si el usuario existe
            if ($stmt->rowCount() > 0) {
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                $passwordHash = $resultado['password'];

                // Validar la contraseña usando password_verify
                if (password_verify($password, $passwordHash)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new Exception("Error al validar usuario: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }

    // Comprobar si el usuario es admin
    public static function esAdmin($usuario): bool
    {
        try {
            // Crear la consulta SQL
            $sql = "SELECT admin FROM usuario WHERE usuario_nombre = :usuario LIMIT 1";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();

            // Verificar si el usuario es admin
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultado["admin"] == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new Exception("Error al leer usuario: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }

    public static function getListaUsuarios(){
        try {
            //Consulta con un param
            $sql = "SELECT * FROM usuario";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
            //Recuperar los datos
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($usuarios) {
                var_dump($usuarios);
                return $usuarios;
            } else {
                echo "No se han encontrado usuarios";
            }
        } catch (PDOException $e) {
            throw new Exception("Error al leer usuario: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }

    public static function borrarUsuario($usuario):bool{
        try {
            //Consulta con un param
            $sql = "DELETE FROM usuario WHERE usuario_nombre = :usuario_nombre";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario_nombre', $usuario);
            $stmt->execute();
            $lineas = $stmt->rowCount();
            //Recuperar los datos
            if ($lineas) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new Exception("Error al leer usuario: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }
}
