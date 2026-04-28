<?php
include RUTA_BASE . "/scripts/librerias/peticionesCURL.php";

class clienteAPIControlador extends CControlador
{
    public array $menuizq = [];

    private string $_urlAPIclientes = "";

    public function __construct()
    {
        $this->_urlAPIclientes = "http://" . $_SERVER["HTTP_HOST"] . "/API/clientes";

        $this->menuizq = [
            [
                "texto" => "Inicio",
                "enlace" => ["inicial"]
            ],
            [
                "texto" => "API Clientes",
                "enlace" => ["clienteAPI", "index"]
            ],
        ];
    }

    // =========================
    // LISTADO
    // =========================
    public function accionIndex()
    {
        $res = petCURLGet($this->_urlAPIclientes);

        if (!$res) {
            Sistema::app()->paginaError(400, "Error API");
            return;
        }

        $res = json_decode($res, true);

        if (!isset($res["correcto"]) || !$res["correcto"]) {
            Sistema::app()->paginaError(500, "Error datos API");
            return;
        }

        $filas = $res["datos"];

        foreach ($filas as $k => $fila) {

			$filas[$k]["borrado"] = ($fila["borrado"] == 1) ? "Sí" : "No";

            $filas[$k]["borr"] = CHTML::link(
                CHTML::imagen("/imagenes/24x24/borrar.png"),
                Sistema::app()->generaURL(["clienteAPI", "borrar"], ["id" => $fila["cod_cliente"]])
            );

            $filas[$k]["modificar"] = CHTML::link(
                CHTML::imagen("/imagenes/24x24/modificar.png"),
                Sistema::app()->generaURL(["clienteAPI", "editar"], ["id" => $fila["cod_cliente"]])
            );
			 $filas[$k]["nuevo"] = CHTML::link(
                CHTML::imagen("/imagenes/24x24/nuevo.png"),
                Sistema::app()->generaURL(["clienteAPI", "crear"])
            );
        }

        $cabecera = [
            ["ETIQUETA" => "NOMBRE", "CAMPO" => "nombre"],
            ["ETIQUETA" => "EMAIL", "CAMPO" => "email"],
            ["ETIQUETA" => "TELÉFONO", "CAMPO" => "telefono"],
            ["ETIQUETA" => "FECHA", "CAMPO" => "fecha_alta"],
            ["ETIQUETA" => "SALDO", "CAMPO" => "saldo"],
			["ETIQUETA" => "Borrado", "CAMPO" => "borrado"],
			["ETIQUETA" => "Activo", "CAMPO" => "activo"],
            ["ETIQUETA" => "", "CAMPO" => "borr"],
            ["ETIQUETA" => "", "CAMPO" => "modificar"],
            ["ETIQUETA" => "", "CAMPO" => "nuevo"]
        ];

        $this->dibujaVista("index", ["fil" => $filas, "cab" => $cabecera], "Clientes API");
    }

    // =========================
    // CREAR
    // =========================
    public function accionCrear()
    {
        if (isset($_POST["crear"])) {

            $datos = [
                "nombre" => $_POST["nombre"],
                "apellidos" => $_POST["apellidos"],
                "email" => $_POST["email"],
                "telefono" => $_POST["telefono"],
                "fecha_alta" => $_POST["fecha_alta"],
                "saldo" => $_POST["saldo"],
                "activo" => $_POST["activo"] ?? 1
            ];

            $res = petCURLPost($this->_urlAPIclientes, http_build_query($datos));

            if (!$res) {
                Sistema::app()->paginaError(400, "Error API");
                return;
            }

            $res = json_decode($res, true);

            if (!isset($res["correcto"]) || !$res["correcto"]) {
                Sistema::app()->paginaError(400, "No se pudo crear");
                return;
            }

            Sistema::app()->irAPagina(["clienteAPI"]);
            return;
        }

        $this->dibujaVista("crear", [], "Nuevo cliente");
    }

    // =========================
    // EDITAR
    // =========================
    public function accionEditar()
    {
        if (!isset($_REQUEST["id"])) {
            Sistema::app()->paginaError(400, "Falta ID");
            return;
        }

        $id = intval($_REQUEST["id"]);

        $res = petCURLGet($this->_urlAPIclientes, "id=$id");

        if (!$res) {
            Sistema::app()->paginaError(400, "Error API");
            return;
        }

        $res = json_decode($res, true);

        if (!isset($res["correcto"]) || !$res["correcto"]) {
            Sistema::app()->paginaError(404, "Cliente no encontrado");
            return;
        }

        $cliente = $res["datos"];

        if (isset($_POST["guardar"])) {

            $datos = [
                "id" => $id,
                "nombre" => $_POST["nombre"],
                "apellidos" => $_POST["apellidos"],
                "email" => $_POST["email"],
                "telefono" => $_POST["telefono"],
                "fecha_alta" => $_POST["fecha_alta"],
                "saldo" => $_POST["saldo"],
                "activo" => $_POST["activo"],
                "borrado" => $_POST["borrado"]
            ];

            $res = petCURLPUT($this->_urlAPIclientes, http_build_query($datos));

            if (!$res) {
                Sistema::app()->paginaError(400, "Error API");
                return;
            }

            $res = json_decode($res, true);

            if (!isset($res["correcto"]) || !$res["correcto"]) {
                Sistema::app()->paginaError(400, $res["datos"] ?? "Error modificar");
                return;
            }

            Sistema::app()->irAPagina(["clienteAPI"]);
            return;
        }

        $this->dibujaVista("modificar", ["prod" => $cliente], "Editar cliente");
    }

    // =========================
    // BORRAR
    // =========================
    public function accionBorrar()
	{
		if (!isset($_REQUEST["id"])) {
			Sistema::app()->paginaError(400, "Falta ID");
			return;
		}

		$id = intval($_REQUEST["id"]);

		// =========================
		// SI CONFIRMA BORRADO
		// =========================
		if (isset($_POST["borrar"])) {

			$res = petCURLDelete(
				$this->_urlAPIclientes,
				http_build_query(["id" => $id])
			);

			$res = json_decode($res, true);

			if (!isset($res["correcto"]) || !$res["correcto"]) {
				Sistema::app()->paginaError(400, "No se pudo borrar");
				return;
			}

			Sistema::app()->irAPagina(["clienteAPI"]);
			return;
		}

		// =========================
		// GET CLIENTE PARA VISTA
		// =========================
		$res = petCURLGet($this->_urlAPIclientes, "id=$id");
		$res = json_decode($res, true);

		if (!isset($res["correcto"]) || !$res["correcto"]) {
			Sistema::app()->paginaError(404, "Cliente no encontrado");
			return;
		}

		$cliente = $res["datos"];

		// =========================
		// VISTA CONFIRMACIÓN
		// =========================
		$this->dibujaVista(
			"borrar",
			["prod" => $cliente],
			"Borrar cliente"
		);
	}
}