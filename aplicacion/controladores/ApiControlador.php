<?php

class APIControlador extends CControlador
{
    public array $menuizq = [];
    public array $menuhead = [];
    public string $textoHead = "";

    private mysqli $bd;

    public function __construct()
    {
        //Menú de la izquierda 
        $this->menuizq = [
            [
                "texto" => "Inicio",
                "enlace" => ["inicial"]
            ]
        ];
        //Menú de la cabecera 
        $this->menuhead = [
            [
                "texto" => "Inicio",
                "enlace" => ["inicial"]
            ]
        ];

        $this->bd = new mysqli("localhost", "root", "", "proyecto");
        $this->bd->set_charset("utf8");

        if ($this->bd->connect_errno) {
            die(json_encode([
                "correcto" => false,
                "datos" => "Error conexión BD"
            ]));
        }
    }

    public function accionClientes()
    {
        $bd = $this->bd;

        //Metodo Get
        if ($_SERVER["REQUEST_METHOD"] == "GET") {

            //Comprobamos si se ha pasado un ID para obtener un cliente concreto
            if (isset($_GET["id"])) {

                $id = intval($_GET["id"]);

                //sacamos la consulta del cliente concreto
                $sql = "SELECT * FROM clientes_api WHERE cod_cliente = $id";

                $cmd = new CCommand($bd, $sql);
                $fila = $cmd->fila();

                //Si no se ha encontrado el cliente, devolvemos error
                if (!$fila) {
                    echo json_encode([
                        "correcto" => false,
                        "datos" => "Cliente no encontrado"
                    ]);
                    return;
                }

                //Si se ha encontrado el cliente, devolvemos sus datosS
                echo json_encode([
                    "correcto" => true,
                    "datos" => $fila
                ]);
                return;
            }

            //Consulta del listado de clientes
            $sql = "SELECT * FROM clientes_api ORDER BY cod_cliente";

            $cmd = new CCommand($bd, $sql);
            $filas = $cmd->filas();

            //Devolvemos el resultado en formato JSONS
            echo json_encode([
                "correcto" => true,
                "datos" => $filas
            ]);
            return;
        }

        //Metodo POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Recogemos los datos enviados por POST y los preparamos para la inserción
            $nombre = $bd->real_escape_string($_POST["nombre"] ?? "");
            $apellidos = $bd->real_escape_string($_POST["apellidos"] ?? "");
            $email = $bd->real_escape_string($_POST["email"] ?? "");
            $telefono = $bd->real_escape_string($_POST["telefono"] ?? "");
            $fecha_alta = $bd->real_escape_string($_POST["fecha_alta"] ?? date("Y-m-d"));
            $saldo = $bd->real_escape_string($_POST["saldo"] ?? 0);

            //Consulta para insertar el nuevo cliente en la base de datos
            $sql = "INSERT INTO clientes_api 
                    (nombre, apellidos, email, telefono, fecha_alta, activo, saldo, borrado)
                    VALUES
                    ('$nombre', '$apellidos', '$email', '$telefono', '$fecha_alta', 1, $saldo, 0)";

            $cmd = new CCommand($bd, $sql);
            $ok = ($cmd->error() == 0);

            //Devolvemos el resultado de la operación en formato JSON
            echo json_encode([
                "correcto" => $ok,
                "datos" => $ok ? "Cliente creado" : "Error"
            ]);
            return;
        }

        //Metodo PUT
        if ($_SERVER["REQUEST_METHOD"] == "PUT") {

            //Recogemos los datos enviados por PUT y los preparamos para la actualización
            parse_str(file_get_contents("php://input"), $p);

            //Comprobamos que se ha pasado un ID para actualizar el cliente concretoS
            if (!isset($p["id"])) {
                echo json_encode(["correcto" => false, "datos" => "Falta ID"]);
                return;
            }

            //Preparamos los datos para la actualización
            $id = intval($p["id"]);
            $nombre = $bd->real_escape_string($p["nombre"] ?? "");
            $apellidos = $bd->real_escape_string($p["apellidos"] ?? "");
            $email = $bd->real_escape_string($p["email"] ?? "");
            $telefono = $bd->real_escape_string($p["telefono"] ?? "");
            $fecha_alta = $bd->real_escape_string($p["fecha_alta"] ?? "");

            //Para estos datos que no son string los combertimos en su tipo correspondiente
            $saldo = floatval($p["saldo"] ?? 0);
            $activo = intval($p["activo"] ?? 1);
            $borrado = intval($p["borrado"] ?? 0);

            //Consulta para actualizar el cliente en la base de datos
            $sql = "UPDATE clientes_api SET
                        nombre='$nombre',
                        apellidos='$apellidos',
                        email='$email',
                        telefono='$telefono',
                        fecha_alta='$fecha_alta',
                        saldo=$saldo,
                        activo=$activo,
                        borrado=$borrado
                    WHERE cod_cliente=$id";

            $cmd = new CCommand($bd, $sql);
            $ok = ($cmd->error() == 0);

            //Devolvemos el resultado de la operación en formato JSON
            echo json_encode([
                "correcto" => $ok,
                "datos" => $ok ? "Cliente actualizado" : "Error"
            ]);
            return;
        }

        //Metodo DELETE (Borrado lógico)
        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {

            //Recogemos los datos enviados por DELETE y los preparamos para la actualización
            parse_str(file_get_contents("php://input"), $p);

            //Comprobamos que se ha pasado un ID para actualizar el cliente concreto
            if (!isset($p["id"])) {
                echo json_encode(["correcto" => false, "datos" => "Falta ID"]);
                return;
            }

            //Pasamos el id a entero
            $id = intval($p["id"]);

            //Consulta para marcar como borrado el cliente en la base de datosS
            $sql = "UPDATE clientes_api SET borrado=1 WHERE cod_cliente=$id";

            $cmd = new CCommand($bd, $sql);
            $ok = ($cmd->error() == 0);

            //Devolvemos el resultado de la operación en formato JSON
            echo json_encode([
                "correcto" => $ok,
                "datos" => $ok ? "Cliente borrado" : "Error"
            ]);
        }
    }
}