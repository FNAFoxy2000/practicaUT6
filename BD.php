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
            // Crear usuario
            $sql = "INSERT INTO usuario (usuario_nombre, password, email) VALUES (:usuario, :password, :email)";
            $passwordCifrada = password_hash($password, PASSWORD_DEFAULT); // Hasheamos el password
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':password', $passwordCifrada);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Crear ordenador para el usuario
            $usuario_id = BD::getUsuarioId($usuario);
            $sql = "INSERT INTO ordenador (usuario_id) VALUES (:usuario_id)";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id);
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
            if ($resultado) {
                if ($resultado["admin"] == 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new Exception("Error al leer usuario: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }

    public static function getListaUsuarios()
    {
        try {
            //Consulta con un param
            $sql = "SELECT * FROM usuario";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            //Recuperar los datos
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($usuarios) {
                return $usuarios;
            } else {
                throw new PDOException("No se encontró ningún usuario");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al obtener usuarios: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }

    public static function borrarUsuario($usuario): bool
    {
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
                throw new PDOException("No se encontró ningún usuario");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al borrar usuario: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }

    /* public static function getListaComponentes()
    {
        try {
            //Consulta con un param
            $componentes = [];
            $sql1 = "SELECT * FROM caja";
            $sql2 = "SELECT * FROM disco_duro";
            $sql3 = "SELECT * FROM marca";
            $sql4 = "SELECT * FROM placa_base";
            $sql5 = "SELECT * FROM procesador";
            $sql6 = "SELECT * FROM ram";
            $sql7 = "SELECT * FROM tarjeta_grafica";

            $conn = self::Conectar();
            $stmt = $conn->prepare($sql1);
            $stmt->execute();

            //Recuperar los datos
            $caja = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($caja) {
                $componentes[] = $caja;
            } else {
                throw new PDOException("Error al leer tabla caja");
            }
            //Recuperar los datos
            $disco_duro = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($disco_duro) {
                $componentes[] = $disco_duro;
            } else {
                throw new PDOException("Error al leer tabla disco_duro");
            }
            //Recuperar los datos
            $placa_base = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($placa_base) {
                $componentes[] = $placa_base;
            } else {
                throw new PDOException("Error al leer tabla placa_base");
            }
            //Recuperar los datos
            $procesador = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($procesador) {
                $componentes[] = $procesador;
            } else {
                throw new PDOException("Error al leer tabla procesador");
            }

            //Recuperar los datos
            $ram = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($ram) {
                $componentes[] = $ram;
            } else {
                throw new PDOException("Error al leer tabla ram");
            }

            //Recuperar los datos
            $tarjeta_grafica = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($tarjeta_grafica) {
                $componentes[] = $tarjeta_grafica;
            } else {
                throw new PDOException("Error al leer tabla tarjeta_grafica");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al obtener los componentes: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    } */

    public static function getOrdenador($usuario_id)
    {
        try {
            $sql = "SELECT * FROM ordenador WHERE usuario_id = :usuario_id LIMIT 1";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->execute();
            $ordenador = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($ordenador) {
                return $ordenador;
            } else {
                throw new PDOException("No encontró ningún ordenador para ese usuario");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al obtener el ordenador: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }

    /* public static function getComponentesOrdenador($usuario_id)
    {
        try {
            $sql = "SELECT placa_id, caja_id, proc_id, grafica_id, ram_id, discoDuro_id FROM ordenador WHERE usuario_id = :usuario_id LIMIT 1";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->execute();
            $ordenador = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($ordenador) {
                return $ordenador[0];
            } else {
                throw new PDOException("No encontró ningún ordenador para ese usuario");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al obtener el ordenador: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    } */

    public static function getComponentesOrdenador($usuario_id)
    {
        try {
            $sql = "SELECT c.caja_nombre, d.discoDuro_nombre, pb.placa_nombre, p.proc_nombre, r.ram_nombre, t.grafica_nombre ";
            $sql .= "FROM caja c, disco_duro d, placa_base pb, procesador p, ram r, tarjeta_grafica t, ordenador o ";
            $sql .= "WHERE usuario_id = :usuario_id ";
            $sql .= "AND o.caja_id = c.caja_id AND o.discoDuro_id = d.discoDuro_id ";
            $sql .= "AND o.placa_id = pb.placa_id AND o.proc_id = p.proc_id ";
            $sql .= "AND o.ram_id = r.ram_id AND o.grafica_id = t.grafica_id; ";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->execute();
            $ordenador = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($ordenador) {
                return $ordenador[0];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new Exception("Error al obtener el ordenador: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }

    public static function getUsuarioId($usuario)
    {
        try {
            //Consulta con un param
            $sql = "SELECT usuario_id FROM usuario WHERE usuario_nombre = :usuario_nombre LIMIT 1";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario_nombre', $usuario);
            $stmt->execute();

            //Recuperar los datos
            $id = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($id) {
                return $id["usuario_id"];
            } else {
                throw new PDOException("No se han encontrado usuarios");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al leer usuario: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }

    public static function getTablaComponente($nombre_tabla)
    {
        try {
            $sql = "SELECT c.*, m.marca_nombre ";
            $sql .= "FROM $nombre_tabla c ";
            $sql .= "LEFT JOIN marca m on m.marca_id = c.marca_id ";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            //Recuperar los datos
            $componentes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($componentes) {
                return $componentes;
            } else {
                echo "No se han encontrado componentes";
            }
        } catch (PDOException $e) {
            throw new Exception("Error al obtener tabla: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }



    // Añadir componente al ordenador
    public static function agregarComponenteOrdenador($usuario_id, $tipo_componente, $componente_id)
    {
        try {
            $sql = "UPDATE ORDENADOR SET $tipo_componente = :componente_id WHERE usuario_id = :usuario_id";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            // $stmt->bindParam(':tipo_componente', $tipo_componente);
            $stmt->bindParam(':componente_id', $componente_id);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->execute();
            //Recuperar los datos
            $lineas = $stmt->rowCount();
            if ($lineas > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new Exception("Error al obtener tabla: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }

    // Obtener nombre segun id
    /* public static function obtenerNombrePorId($nombreTablaComponente, $tipo_componente, $componente_id)
    {
        $nombreComponente = $tipo_componente . "_nombre";
        $idComponente = $tipo_componente . "_id";
        if ($componente_id != null) {
            try {
                $sql = "SELECT $nombreComponente FROM $nombreTablaComponente WHERE $idComponente = $componente_id";
                $conn = self::Conectar();
                $stmt = $conn->prepare($sql);
                // $stmt->bindParam(':tipo_componente', $tipo_componente);
                $stmt->execute();
                //Recuperar los datos
                $componente_nombre = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($componente_nombre) {
                    return $componente_nombre[$nombreComponente];
                } else {
                    throw new PDOException("No se encontró ningun componente con ese id");
                }
            } catch (PDOException $e) {
                throw new Exception("Error al obtener tabla: " . $e->getMessage());
            } finally {
                self::CerrarConexion();
            }
        }else{
            return "";
        }
    } */

    public static function borrarComponente($nombre_tabla, $tipo_componente,$id): bool
    {
        try {
            //Consulta con un param
            $sql = "DELETE FROM $nombre_tabla WHERE $tipo_componente = :id" ;
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $lineas = $stmt->rowCount();
            //Recuperar los datos
            if ($lineas) {
                return true;
            } else {
                throw new PDOException("No se encontró ningún componente");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al borrar componente: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }
}
