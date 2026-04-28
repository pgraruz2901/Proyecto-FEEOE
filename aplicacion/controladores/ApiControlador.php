<?php

class APIControlador extends CControlador
{
    public array $menuizq = [];
    public string $textoHead = "";

    private mysqli $bd;

    public function __construct()
    {
        $this->menuizq = [
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

        // =========================
        // GET
        // =========================
        if ($_SERVER["REQUEST_METHOD"] == "GET") {

            // ---- GET POR ID ----
            if (isset($_GET["id"])) {

                $id = intval($_GET["id"]);

                $sql = "SELECT * FROM clientes_api WHERE cod_cliente = $id";
                $res = $bd->query($sql);

                if (!$res || $res->num_rows == 0) {
                    echo json_encode([
                        "correcto" => false,
                        "datos" => "Cliente no encontrado"
                    ]);
                    return;
                }

                echo json_encode([
                    "correcto" => true,
                    "datos" => $res->fetch_assoc()
                ]);
                return;
            }

            // ---- LISTADO ----
            $sql = "SELECT * FROM clientes_api ORDER BY nombre";
            $res = $bd->query($sql);

            $filas = [];

            while ($fila = $res->fetch_assoc()) {
                $filas[] = $fila;
            }

            echo json_encode([
                "correcto" => true,
                "datos" => $filas
            ]);
            return;
        }

        // =========================
        // POST
        // =========================
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nombre = $bd->real_escape_string($_POST["nombre"] ?? "");
            $apellidos = $bd->real_escape_string($_POST["apellidos"] ?? "");
            $email = $bd->real_escape_string($_POST["email"] ?? "");
            $telefono = $bd->real_escape_string($_POST["telefono"] ?? "");
            $fecha_alta = $bd->real_escape_string($_POST["fecha_alta"] ?? date("Y-m-d"));

            $sql = "INSERT INTO clientes_api 
                    (nombre, apellidos, email, telefono, fecha_alta, activo, saldo, borrado)
                    VALUES
                    ('$nombre', '$apellidos', '$email', '$telefono', '$fecha_alta', 1, 0, 0)";

            $ok = $bd->query($sql);

            echo json_encode([
                "correcto" => $ok,
                "datos" => $ok ? "Cliente creado" : "Error"
            ]);
            return;
        }

        // =========================
        // PUT (CORREGIDO COMPLETO)
        // =========================
        if ($_SERVER["REQUEST_METHOD"] == "PUT") {

            parse_str(file_get_contents("php://input"), $p);

            if (!isset($p["id"])) {
                echo json_encode(["correcto" => false, "datos" => "Falta ID"]);
                return;
            }

            $id = intval($p["id"]);
            $nombre = $bd->real_escape_string($p["nombre"] ?? "");
            $apellidos = $bd->real_escape_string($p["apellidos"] ?? "");
            $email = $bd->real_escape_string($p["email"] ?? "");
            $telefono = $bd->real_escape_string($p["telefono"] ?? "");
            $fecha_alta = $bd->real_escape_string($p["fecha_alta"] ?? "");

            $saldo = floatval($p["saldo"] ?? 0);
            $activo = intval($p["activo"] ?? 1);
            $borrado = intval($p["borrado"] ?? 0);

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

            $ok = $bd->query($sql);

            echo json_encode([
                "correcto" => $ok,
                "datos" => $ok ? "Cliente actualizado" : "Error"
            ]);
            return;
        }

        // =========================
        // DELETE (BORRADO LÓGICO)
        // =========================
        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {

            parse_str(file_get_contents("php://input"), $p);

            if (!isset($p["id"])) {
                echo json_encode(["correcto" => false, "datos" => "Falta ID"]);
                return;
            }

            $id = intval($p["id"]);

            $sql = "UPDATE clientes_api SET borrado=1 WHERE cod_cliente=$id";

            $ok = $bd->query($sql);

            echo json_encode([
                "correcto" => $ok,
                "datos" => $ok ? "Cliente borrado" : "Error"
            ]);
        }
    }
}