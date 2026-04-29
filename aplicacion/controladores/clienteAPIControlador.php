<?php
include RUTA_BASE . "/scripts/librerias/peticionesCURL.php";

class clienteAPIControlador extends CControlador
{
    public array $menuizq = [];
    public array $menuhead = [];

    private string $_urlAPIclientes = "";
    private mysqli $bd;

    public function __construct()
    {
		//URL base de la API de clientes
        $this->_urlAPIclientes = $_SERVER["HTTP_HOST"] . "/API/clientes";

		//Menú de la izquierda
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
		//Menú de la cabecera
		$this->menuhead = [
            [
                "texto" => "Inicio",
                "enlace" => ["inicial"]
            ],
            [
                "texto" => "API Clientes",
                "enlace" => ["clienteAPI", "index"]
            ],
        ];
        $this->bd = new mysqli("localhost", "root", "", "proyecto");
        $this->bd->set_charset("utf8");
    }

    //Listado de los clientesa
    public function accionIndex()
    {
		//Realizamos la petición a la API para obtener el listado de clientes
        $res = petCURLGet($this->_urlAPIclientes);

		//Si la petición ha fallado, mostramos error
        if (!$res) {
            Sistema::app()->paginaError(400, "Error API");
            return;
        }
        // Obtenemos la página en la cual estamos y los registros por página
		$pag = isset($_GET["pag"]) ? intval($_GET["pag"]) : 1;
		$regPag = isset($_GET["reg_pag"]) ? intval($_GET["reg_pag"]) : 8;

		if ($pag < 1) $pag = 1;

		//Decodificamos la respuesta JSON
        $res = json_decode($res, true);

		//Si la respuesta no es correcta, mostramos error
        if (!isset($res["correcto"]) || !$res["correcto"]) {
            Sistema::app()->paginaError(500, "Error datos API");
            return;
        }

        // Calculamos offset
		$offset = ($pag - 1) * $regPag;

		// Obtenemos los registros para la página actual
	
		$opciones["order"] = "nombre ASC";
		$opciones["limit"] = "$offset, $regPag";

		$urlBase = Sistema::app()->generaURL(["clienteAPI", "index"]);

		//Obtenemos el listado de clientes
        $filas = $res["datos"];

        $cmd = new CCommand(
            $this->bd,
            "SELECT COUNT(*) AS total
            FROM productos"
        );

        $fila = $cmd->fila();

        $totalRegistros = $fila["total"];
        
        // Opciones para el CPager
		$opcPaginador = array(
			"URL" => $urlBase,
			"TOTAL_REGISTROS" => $totalRegistros,
			"PAGINA_ACTUAL" => $pag,
			"REGISTROS_PAGINA" => $regPag,
			"TAMANIOS_PAGINA" => array(4 => "4", 8 => "8",12 => "12", 16 => "16", 20 => "20", 25=>"25"),
			"MOSTRAR_TAMANIOS" => true,
			"PAGINAS_MOSTRADAS" => 5
		);

		//Preparamos los datos para la vista
        foreach ($filas as $k => $fila) {

			//Añadimos enlaces de acción para cada cliente (borrar)
            $filas[$k]["borr"] = CHTML::link(
                CHTML::imagen("/imagenes/24x24/borrar.png"),
                Sistema::app()->generaURL(["clienteAPI", "borrar"], ["id" => $fila["cod_cliente"]])
            );

			//Añadimos enlaces de acción para cada cliente (modificar)
            $filas[$k]["modificar"] = CHTML::link(
                CHTML::imagen("/imagenes/24x24/modificar.png"),
                Sistema::app()->generaURL(["clienteAPI", "editar"], ["id" => $fila["cod_cliente"]])
            );
			//Añadimos enlace para crear nuevo cliente
			 $filas[$k]["nuevo"] = CHTML::link(
                CHTML::imagen("/imagenes/24x24/nuevo.png"),
                Sistema::app()->generaURL(["clienteAPI", "crear"])
            );
        }
        $datos = array(
			"pag" => $pag,
			"regPag" => $regPag,
			"opcPag" => $opcPaginador,
    		"totalRegistros" => $totalRegistros

		);

		//Dibujamos la vista pasando el listado de clientes y el encabezado de la tabla
        $this->dibujaVista("index", ["filas" => $filas, "datos" => $datos], "Clientes API");
    }

    //funcion para crear nuevo cliente
    public function accionCrear()
    {
		//Si se ha enviado el formulario de creación
        if (isset($_POST["crear"])) {

			//Preparamos los datos para enviar a la API
            $datos = [
                "nombre" => $_POST["nombre"],
                "apellidos" => $_POST["apellidos"],
                "email" => $_POST["email"],
                "telefono" => $_POST["telefono"],
                "fecha_alta" => $_POST["fecha_alta"],
                "saldo" => $_POST["saldo"],
                "activo" => $_POST["activo"] ?? 1
            ];

			//Realizamos la petición POST a la API para crear el nuevo cliente
            $res = petCURLPost($this->_urlAPIclientes, http_build_query($datos));

			//Si la petición ha fallado, mostramos error
            if (!$res) {
                Sistema::app()->paginaError(400, "Error API");
                return;
            }

			//Decodificamos la respuesta JSON
            $res = json_decode($res, true);

			//Si la respuesta no es correcta, mostramos error
            if (!isset($res["correcto"]) || !$res["correcto"]) {
                Sistema::app()->paginaError(400, "No se pudo crear");
                return;
            }

			//Si se ha creado correctamente, redirigimos al listado de clientes
            Sistema::app()->irAPagina(["clienteAPI"]);
            return;
        }

		//Si no se ha enviado el formulario, mostramos la vista de creación
        $this->dibujaVista("nuevo", [], "Nuevo cliente");
    }

    //funcion para modificar cliente
    public function accionEditar()
    {
		//Si no se ha recibido el ID del cliente, mostramos error
        if (!isset($_REQUEST["id"])) {
            Sistema::app()->paginaError(400, "Falta ID");
            return;
        }

		//Pasamos el id a entero
        $id = intval($_REQUEST["id"]);

		//Realizamos la petición a la API para obtener los datos del cliente a modificar
        $res = petCURLGet($this->_urlAPIclientes, "id=$id");

		//Si la petición ha fallado, mostramos error
        if (!$res) {
            Sistema::app()->paginaError(400, "Error API");
            return;
        }

		//Decodificamos la respuesta JSON
        $res = json_decode($res, true);

		//Si la respuesta no es correcta o no se encuentra el cliente, mostramos error
        if (!isset($res["correcto"]) || !$res["correcto"]) {
            Sistema::app()->paginaError(404, "Cliente no encontrado");
            return;
        }

		//Obtenemos los datos del cliente
        $cliente = $res["datos"];

        if (isset($_POST["guardar"])) {

		//Preparamos los datos para enviar a la API si se ha enviado el formulario de modificación
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

			//Realizamos la petición PUT a la API para modificar el cliente
            $res = petCURLPUT($this->_urlAPIclientes, http_build_query($datos));

			//Si la petición ha fallado, mostramos error
            if (!$res) {
                Sistema::app()->paginaError(400, "Error API");
                return;
            }

			//Decodificamos la respuesta JSON
            $res = json_decode($res, true);

			//Si la respuesta no es correcta, mostramos error
            if (!isset($res["correcto"]) || !$res["correcto"]) {
                Sistema::app()->paginaError(400, $res["datos"] ?? "Error modificar");
                return;
            }

			//Si se ha modificado correctamente, redirigimos al listado de clientes
            Sistema::app()->irAPagina(["clienteAPI"]);
            return;
        }

		//Si no se ha enviado el formulario, mostramos la vista de modificación pasando los datos del cliente
        $this->dibujaVista("modificar", ["prod" => $cliente], "Editar cliente");
    }

    //funcion para borrar cliente
    public function accionBorrar()
	{
		//Si no se ha recibido el ID del cliente, mostramos error
		if (!isset($_REQUEST["id"])) {
			Sistema::app()->paginaError(400, "Falta ID");
			return;
		}

		//Pasamos el id a entero
		$id = intval($_REQUEST["id"]);

		//Si se ha enviado el formulario de confirmación de borrado
		if (isset($_POST["borrar"])) {

		//Realizamos la petición DELETE a la API para marcar como borrado el cliente
			$res = petCURLDelete(
				$this->_urlAPIclientes,
				http_build_query(["id" => $id])
			);
		
			$res = json_decode($res, true);

			//Si la petición ha fallado, mostramos error
			if (!isset($res["correcto"]) || !$res["correcto"]) {
				Sistema::app()->paginaError(400, "No se pudo borrar");
				return;
			}

			//Si se ha borrado correctamente, redirigimos al listado de clientes
			Sistema::app()->irAPagina(["clienteAPI"]);
			return;
		}

		//Realizamos la petición a la API para obtener los datos del cliente a borrar
		$res = petCURLGet($this->_urlAPIclientes, "id=$id");
		$res = json_decode($res, true);

		//Si la petición ha fallado o no se encuentra el cliente, mostramos error
		if (!isset($res["correcto"]) || !$res["correcto"]) {
			Sistema::app()->paginaError(404, "Cliente no encontrado");
			return;
		}

		//Obtenemos los datos del cliente
		$cliente = $res["datos"];

		//Mostramos la vista de confirmación de borrado pasando los datos del cliente seleccionado
		$this->dibujaVista(
			"borrar",
			["prod" => $cliente],
			"Borrar cliente"
		);
	}
}