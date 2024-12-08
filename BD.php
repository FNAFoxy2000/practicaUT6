<?php
include_once "Usuario.php";
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
            self::$conn = new PDO(self::$destino, self::$user, self::$password);
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
    public static function RegistrarUsuario($usuario, $password, $email)
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
            $usuario_id = self::getUsuarioId($usuario);
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
    public static function Login($usuario, $password)
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
    public static function esAdmin($usuario)
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

    public static function borrarUsuario($usuario)
    {
        try {
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
            $sql .= "FROM ordenador o ";
            $sql .= "LEFT JOIN caja c ON o.caja_id = c.caja_id ";
            $sql .= "LEFT JOIN disco_duro d ON o.discoDuro_id = d.discoDuro_id ";
            $sql .= "LEFT JOIN placa_base pb ON o.placa_id = pb.placa_id ";
            $sql .= "LEFT JOIN procesador p ON o.proc_id = p.proc_id ";
            $sql .= "LEFT JOIN ram r ON o.ram_id = r.ram_id ";
            $sql .= "LEFT JOIN tarjeta_grafica t ON o.grafica_id = t.grafica_id ";
            $sql .= "WHERE o.usuario_id = :usuario_id;";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->execute();
            $ordenador = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($ordenador) {
                return $ordenador[0];
            } else {
                throw new PDOException("No se obtuvo el ordenador del usuario");
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

    public static function getTablaComponente($nombre_tabla, $precio_max = null, $marca_filtro = null, $ordenar = null)
    {
        try {
            // El nombre de la tabla y el nombre de las columnas es distinto
            $tipo_componente = null;
            switch ($nombre_tabla) {
                case "caja":
                    $tipo_componente = "caja";
                    break;
                case "disco_duro":
                    $tipo_componente = "discoDuro";
                    break;
                case "placa_base":
                    $tipo_componente = "placa";
                    break;
                case "procesador":
                    $tipo_componente = "proc";
                    break;
                case "ram":
                    $tipo_componente = "ram";
                    break;
                case "tarjeta_grafica":
                    $tipo_componente = "grafica";
                    break;
            }
            if ($tipo_componente != null) {
                $componente_precio = $tipo_componente . "_precio";

                // Para el ORDER BY
                $ordenarColumna = null;
                switch ($ordenar) {
                    case "nombre":
                        $ordenarColumna = $tipo_componente . "_nombre";
                        break;
                    case "precio":
                        $ordenarColumna = $componente_precio;
                        break;
                    case "marca":
                        $ordenarColumna = "marca_id";
                        break;
                }
            } else{
                throw new Exception("No se pudo obtener el tipo de componente");
            }

            $sql = "SELECT c.*, m.marca_nombre ";
            $sql .= "FROM $nombre_tabla c ";
            $sql .= "LEFT JOIN marca m on m.marca_id = c.marca_id ";
            $sql .= "WHERE 1 = 1 ";

            if ($precio_max != null) {
                $sql .= "AND c.$componente_precio <= $precio_max ";
            }

            if ($marca_filtro != null) {
                $sql .= "AND c.marca_id = $marca_filtro ";
            }

            if ($ordenarColumna != null) {
                $sql .= "ORDER BY $ordenarColumna ";
            }

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

    public static function getMarcas()
    {
        try {
            $sql = "SELECT * FROM marca";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            //Recuperar los datos
            $marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($marcas) {
                return $marcas;
            } else {
                throw new PDOException("No se encontró ningúna marca");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al obtener marcas: " . $e->getMessage());
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

    public static function borrarComponente($nombre_tabla, $tipo_componente, $id)
    {
        try {
            $sql = "DELETE FROM $nombre_tabla WHERE $tipo_componente = :id";
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


    #region AÑADIR PRODUCTOS (ADMIN)

    public static function anadirCaja($caja_nombre, $caja_precio, $marca_id)
    {
        try {
            $sql = "INSERT INTO caja (caja_nombre, caja_precio, marca_id) VALUES (:caja_nombre, :caja_precio, :marca_id)";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':caja_nombre', $caja_nombre);
            $stmt->bindParam(':caja_precio', $caja_precio);
            $stmt->bindParam(':marca_id', $marca_id);
            $stmt->execute();
            $lineas = $stmt->rowCount();
            //Recuperar los datos
            if ($lineas) {
                return true;
            } else {
                throw new PDOException("No se agregó ninguna caja");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al agregar caja: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }

    public static function anadirdiscoDuro($discoDuro_nombre, $capacidad, $tipo, $discoDuro_precio, $marca_id)
    {
        try {
            $sql = "INSERT INTO disco_duro (discoDuro_nombre, capacidad, tipo, discoDuro_precio, marca_id) ";
            $sql .= "VALUES (:discoDuro_nombre, :capacidad, :tipo, :discoDuro_precio, :marca_id)";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':discoDuro_nombre', $discoDuro_nombre);
            $stmt->bindParam(':capacidad', $capacidad);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':discoDuro_precio', $discoDuro_precio);
            $stmt->bindParam(':marca_id', $marca_id);
            $stmt->execute();
            $lineas = $stmt->rowCount();
            //Recuperar los datos
            if ($lineas) {
                return true;
            } else {
                throw new PDOException("No se agregó ningún disco duro");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al agregar disco duro: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }

    public static function anadirMarca($marca_nombre)
    {
        try {
            $sql = "INSERT INTO marca (marca_nombre) VALUES (:marca_nombre)";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':marca_nombre', $marca_nombre);
            $stmt->execute();
            $lineas = $stmt->rowCount();
            //Recuperar los datos
            if ($lineas) {
                return true;
            } else {
                throw new PDOException("No se agregó ninguna marca");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al agregar marca: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }

    public static function anadirPlacaBase($placa_nombre, $placa_precio, $marca_id)
    {
        try {
            $sql = "INSERT INTO placa_base (placa_nombre, placa_precio, marca_id) VALUES (:placa_nombre, :placa_precio, :marca_id)";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':placa_nombre', $placa_nombre);
            $stmt->bindParam(':placa_precio', $placa_precio);
            $stmt->bindParam(':marca_id', $marca_id);
            $stmt->execute();
            $lineas = $stmt->rowCount();
            //Recuperar los datos
            if ($lineas) {
                return true;
            } else {
                throw new PDOException("No se agregó ninguna placa");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al agregar placa: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }

    public static function anadirProcesador($proc_nombre, $gHz, $nucleos, $proc_precio, $marca_id)
    {
        try {
            $sql = "INSERT INTO proc (proc_nombre, gHz, nucleos, proc_precio, marca_id) VALUES (:proc_nombre, :gHz, :nucleos, :proc_precio, :marca_id)";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':proc_nombre', $proc_nombre);
            $stmt->bindParam(':gHz', $gHz);
            $stmt->bindParam(':nucleos', $nucleos);
            $stmt->bindParam(':proc_precio', $proc_precio);
            $stmt->bindParam(':marca_id', $marca_id);
            $stmt->execute();
            $lineas = $stmt->rowCount();
            //Recuperar los datos
            if ($lineas) {
                return true;
            } else {
                throw new PDOException("No se agregó ningún procesador");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al agregar procesador: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }

    public static function anadirRam($ram_nombre, $ram_gb, $ram_mhz, $ram_precio, $marca_id)
    {
        try {
            $sql = "INSERT INTO ram (ram_nombre, ram_gb, ram_mhz, ram_precio, marca_id) VALUES (:ram_nombre,  :ram_gb, :ram_mhz, :ram_precio, :marca_id)";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':ram_nombre', $ram_nombre);
            $stmt->bindParam(':ram_gb', $ram_gb);
            $stmt->bindParam(':ram_mhz', $ram_mhz);
            $stmt->bindParam(':ram_precio', $ram_precio);
            $stmt->bindParam(':marca_id', $marca_id);
            $stmt->execute();
            $lineas = $stmt->rowCount();
            //Recuperar los datos
            if ($lineas) {
                return true;
            } else {
                throw new PDOException("No se agregó ninguna ram");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al agregar ram: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }

    public static function anadirGrafica($grafica_nombre, $grafica_Gb, $rtx, $grafica_precio, $marca_id)
    {
        try {
            $sql = "INSERT INTO tarjeta_grafica (grafica_nombre, grafica_Gb, rtx, grafica_precio, marca_id) VALUES (:grafica_nombre, :grafica_Gb, :rtx, :grafica_precio, :marca_id)";
            $conn = self::Conectar();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':grafica_nombre', $grafica_nombre);
            $stmt->bindParam(':grafica_Gb', $grafica_Gb);
            $stmt->bindParam(':rtx', $rtx);
            $stmt->bindParam(':grafica_precio', $grafica_precio);
            $stmt->bindParam(':marca_id', $marca_id);
            $stmt->execute();
            $lineas = $stmt->rowCount();
            //Recuperar los datos
            if ($lineas) {
                return true;
            } else {
                throw new PDOException("No se agregó ningúna grafica");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al agregar grafica: " . $e->getMessage());
        } finally {
            self::CerrarConexion();
        }
    }

    #endregion

    public static function exportarJson()
    {
        $usuarios = self::getListaUsuarios();
        $jsonUsuarios = json_encode($usuarios, JSON_PRETTY_PRINT);
        $rutaArchivoJson1 = "lista_usuarios.json";
        file_put_contents($rutaArchivoJson1, $jsonUsuarios);
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="lista_usuarios.json"');
        header('Content-Length: ' . strlen($jsonUsuarios));
        if (file_exists($rutaArchivoJson1)) {
            $usuariosDatos = file_get_contents($rutaArchivoJson1);
            echo "$usuariosDatos";
            $usuariosDatos = json_decode($usuariosDatos, true); // muy importante poner true para recibir cada cosa como array asociativa.
            // al decodificar un json con un objeto, hay que reconstruir las instancias

        }
        exit;
    }
}
