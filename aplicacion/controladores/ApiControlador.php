<?php

class APIControlador extends CControlador
{
    public array $menuizq = [];
    public string $textoHead = "";

    public function __construct()
    {
        $this->menuizq = [
            [
                "texto" => "Inicio",
                "enlace" => ["inicial"]
            ]
        ];
    }

    // =========================
    // CRUD PRODUCTOS API
    // =========================
    public function accionProductos()
    {

        // =====================================================
        // GET -> CONSULTAR
        // =====================================================
        if ($_SERVER["REQUEST_METHOD"] == "GET") {

            $prod = new Productos();

            // ---- CONSULTA POR ID ----
            if (isset($_GET["id"])) {

                $id = intval($_GET["id"]);

                if (!$prod->buscarPorId($id) || $prod->borrado == 1) {

                    header("HTTP/1.0 404 No encontrado");

                    echo json_encode([
                        "datos" => "Producto no encontrado",
                        "correcto" => false
                    ], JSON_PRETTY_PRINT);

                    return;
                }

                echo json_encode([
                    "datos" => [
                        "id" => $prod->cod_producto,
                        "nombre" => $prod->nombre,
                        "precio" => $prod->precio_venta
                    ],
                    "correcto" => true
                ], JSON_PRETTY_PRINT);

                return;
            }

            // ---- LISTADO GENERAL ----
            $where = "borrado = 0";

            if (isset($_GET["nombre"]) && $_GET["nombre"] != "") {

                $nombre = CGeneral::addSlashes($_GET["nombre"]);
                $where .= " AND nombre LIKE '%$nombre%'";
            }

            $datos = $prod->buscarTodos([
                "where" => $where,
                "order" => "nombre ASC"
            ]);

            echo json_encode([
                "datos" => $datos,
                "correcto" => true
            ], JSON_PRETTY_PRINT);

            return;
        }

        // =====================================================
        // POST -> INSERTAR
        // =====================================================
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $prod = new Productos();

            $prod->setValores($_POST);

            if (!$prod->validar()) {

                echo json_encode([
                    "datos" => $prod->getErrores(),
                    "correcto" => false
                ], JSON_PRETTY_PRINT);

                return;
            }

            $prod->afterCreate();

            if ($prod->guardar()) {

                echo json_encode([
                    "datos" => "Producto insertado correctamente",
                    "correcto" => true
                ], JSON_PRETTY_PRINT);

            } else {

                echo json_encode([
                    "datos" => "Error al insertar",
                    "correcto" => false
                ], JSON_PRETTY_PRINT);
            }

            return;
        }

        // =====================================================
        // PUT -> MODIFICAR
        // =====================================================
        if ($_SERVER["REQUEST_METHOD"] == "PUT") {

            $param = $this->recogerParametros();

            if (!isset($param["id"])) {

                echo json_encode([
                    "datos" => "ID no indicado",
                    "correcto" => false
                ]);
                return;
            }

            $prod = new Productos();

            if (!$prod->buscarPorId($param["id"])) {

                echo json_encode([
                    "datos" => "Producto no encontrado",
                    "correcto" => false
                ]);
                return;
            }

            $prod->setValores($param);

            if (!$prod->validar()) {

                echo json_encode([
                    "datos" => $prod->getErrores(),
                    "correcto" => false
                ]);

                return;
            }

            $prod->afterCreate();

            if ($prod->guardar()) {

                echo json_encode([
                    "datos" => "Producto modificado correctamente",
                    "correcto" => true
                ]);
            }

            return;
        }

        // =====================================================
        // DELETE -> BORRADO LÓGICO
        // =====================================================
        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {

            $param = $this->recogerParametros();

            if (!isset($param["id"])) {

                echo json_encode([
                    "datos" => "ID no indicado",
                    "correcto" => false
                ]);
                return;
            }

            $prod = new Productos();

            if (!$prod->buscarPorId($param["id"])) {

                echo json_encode([
                    "datos" => "Producto no encontrado",
                    "correcto" => false
                ]);
                return;
            }

            $prod->borrado = 1;

            if ($prod->guardar()) {

                echo json_encode([
                    "datos" => "Producto eliminado (lógico)",
                    "correcto" => true
                ]);
            }

            return;
        }
    }

    // =========================
    // RECIBIR PUT / DELETE
    // =========================
    function recogerParametros()
    {
        $datos = file_get_contents("php://input");
        parse_str($datos, $par);
        return $par;
    }
}