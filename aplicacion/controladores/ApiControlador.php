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
                "enlace" => ["productos"]
            ]
        ];
        //Menú de la cabecera 
        $this->menuhead = [
            [
                "texto" => "Inicio",
                "enlace" => ["productos"]
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
            $sql = "SELECT * FROM clientes_api WHERE 1=1";

            //Filtro Nombre para la consulta
            if (isset($_GET["filtro_nombre"]) && $_GET["filtro_nombre"] !== "") {
                $nombre = $bd->real_escape_string($_GET["filtro_nombre"]);
                $sql .= " AND nombre LIKE '%$nombre%'";
            }

            //Filtro Borrado para la consulta
            if (isset($_GET["filtro_borrado"]) && $_GET["filtro_borrado"] !== "") {
                $borrado = intval($_GET["filtro_borrado"]);
                $sql .= " AND borrado = $borrado";
            }

            //Contamos el total de registros para usarlo en la paginación
            $sqlCount = "SELECT COUNT(*) AS total FROM clientes_api WHERE 1=1";

            //Paginación
            $pag = isset($_GET["pag"]) ? intval($_GET["pag"]) : 1;
            $regPag = isset($_GET["reg_pag"]) ? intval($_GET["reg_pag"]) : 8;
            if ($pag < 1) $pag = 1;

            //Calculamos el offset para la consulta SQL
            $offset = ($pag - 1) * $regPag;

            //Añadimos el orden y el límite a la consulta SQL
            $sql .= " ORDER BY cod_cliente LIMIT $offset, $regPag";

            //Ejecutamos la consulta para obtener los clientes
            $cmd = new CCommand($bd, $sql);
            $filas = $cmd->filas();

            //Ejecutamos la consulta para contar el total de registros
            $cmdCount = new CCommand($bd, $sqlCount);
            $total = $cmdCount->fila();

            echo json_encode([
                "correcto" => true,
                "datos" => $filas,
                "total" => $total["total"]
            ]);
            return;
        }

        //Metodo POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //Recogemos los datos del cliente a crear 
            $nombre = $bd->real_escape_string($_POST["nombre"] ?? "");
            $apellidos = $bd->real_escape_string($_POST["apellidos"] ?? "");
            $email = $bd->real_escape_string($_POST["email"] ?? "");
            $telefono = $bd->real_escape_string($_POST["telefono"] ?? "");
            $fecha_alta = $bd->real_escape_string($_POST["fecha_alta"] ?? date("Y-m-d"));
            $saldo = floatval($_POST["saldo"] ?? 0);

            //Comprobamos que se hayan pasado los datos obligatorios, sino se devuelve error
            if ($nombre === "" || $apellidos === "" || $email === "") {
                echo json_encode([
                    "correcto" => false,
                    "datos" => "Nombre, apellidos y email son obligatorios"
                ]);
                return;
            }
            //Consulta para insertar el nuevo cliente
            $sql = "INSERT INTO clientes_api 
                    (nombre, apellidos, email, telefono, fecha_alta, activo, saldo, borrado)
                    VALUES
                    ('$nombre', '$apellidos', '$email', '$telefono', '$fecha_alta', 1, $saldo, 0)";

            //Ejecutamos la consulta para crear el nuevo cliente
            $cmd = new CCommand($bd, $sql);
            $ok = ($cmd->error() == 0);

            echo json_encode([
                "correcto" => $ok,
                "datos" => $ok ? "Cliente creado" : "Error"
            ]);
            return;
        }

        //Metodo PUT
        if ($_SERVER["REQUEST_METHOD"] == "PUT") {

            parse_str(file_get_contents("php://input"), $p);

            //Comprobamos que se ha pasado el ID del cliente que vamosa modificar
            if (!isset($p["id"])) {
                echo json_encode(["correcto" => false, "datos" => "Falta ID"]);
                return;
            }

            //Preparamos los datos para modificar el cliente
            $id = intval($p["id"]);
            $nombre = $bd->real_escape_string($p["nombre"] ?? "");
            $apellidos = $bd->real_escape_string($p["apellidos"] ?? "");
            $email = $bd->real_escape_string($p["email"] ?? "");
            $telefono = $bd->real_escape_string($p["telefono"] ?? "");
            $fecha_alta = $bd->real_escape_string($p["fecha_alta"] ?? "");

            //Cmo son datos numericos los pasamos a su correspondiente tipo
            $saldo = floatval($p["saldo"] ?? 0);
            $activo = intval($p["activo"] ?? 1);
            $borrado = intval($p["borrado"] ?? 0);

            //Consulta para modificar el cliente
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

            //Ejecutamos la consulta para modificar el cliente
            $cmd = new CCommand($bd, $sql);
            $ok = ($cmd->error() == 0);

            echo json_encode([
                "correcto" => $ok,
                "datos" => $ok ? "Cliente actualizado" : "Error"
            ]);
            return;
        }

        //Metodo DELETE (Borrado lógico)
        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {

            parse_str(file_get_contents("php://input"), $p);

            //Comprobamos que se ha pasado el ID del cliente que vamos a borrar
            if (!isset($p["id"])) {
                echo json_encode(["correcto" => false, "datos" => "Falta ID"]);
                return;
            }

            //Pasamo sel id a entero
            $id = intval($p["id"]);

            //Consulta para realizar el borrado lógico del cliente
            $sql = "UPDATE clientes_api SET borrado=1 WHERE cod_cliente=$id";

            //Ejecutamos la consulta para borrar el cliente
            $cmd = new CCommand($bd, $sql);
            $ok = ($cmd->error() == 0);

            echo json_encode([
                "correcto" => $ok,
                "datos" => $ok ? "Cliente borrado" : "Error"
            ]);
        }
    }
}