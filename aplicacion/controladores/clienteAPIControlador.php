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
                "enlace" => ["productos"]
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
                "enlace" => ["productos"]
            ],
            [
                "texto" => "API Clientes",
                "enlace" => ["clienteAPI", "index"]
            ],
        ];

        //Conectamos la base de datos
        $this->bd = new mysqli("localhost", "root", "", "proyecto");
        $this->bd->set_charset("utf8");
    }

    //Listado de los clientesa
    public function accionIndex()
    {
         //Si hay usuario logueado se podra hacer sino no
        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "login"]);
        }
        //Si el usuario no tiene permiso 9 se muestra error
       if (!Sistema::app()->Acceso()->puedePermiso(9)) {
            Sistema::app()->paginaError(404, "No tienes permiso 9");
        }

        // Filtros
        $filtroNombre = isset($_GET["filtro_nombre"]) ? trim($_GET["filtro_nombre"]) : "";
        $filtroBorrado = isset($_GET["filtro_borrado"]) ? $_GET["filtro_borrado"] : "";

        // Paginación
        $pag = isset($_GET["pag"]) ? intval($_GET["pag"]) : 1;
        $regPag = isset($_GET["reg_pag"]) ? intval($_GET["reg_pag"]) : 8;

        //Si la página es menor que 1, la ponemos a 1
        if ($pag < 1) $pag = 1;

        // Llamada a la API (TODO incluido en query string)
        $query = [
            "filtro_nombre" => $filtroNombre,
            "filtro_borrado" => $filtroBorrado,
            "pag" => $pag,
            "reg_pag" => $regPag
        ];

        //Realizamos la petición GET a la API para obtener el listado de clientes con los filtros y los datos de la paginacion
        $res = petCURLGet($this->_urlAPIclientes . "?" . http_build_query($query));

        // Si la petición ha fallado, mostramos error
        if (!$res) {
            Sistema::app()->paginaError(400, "Error API");
            return;
        }

        // Decodificamos la respuesta JSON
        $res = json_decode($res, true);

        // Si la respuesta no es correcta, mostramos error
        if (!isset($res["correcto"]) || !$res["correcto"]) {
            Sistema::app()->paginaError(500, "Error datos API");
            return;
        }

        // Datos que se han obtenido de la API
        $filas = $res["datos"];
        $totalRegistros = $res["total"];

        // Parámetros para CPager (IMPORTANTE: SIN meterlos en URL manualmente)
        $parametrosFiltros = [];

        //Agregamos a $parametrosFiltros los filtros q vamos a usar en el filtrado
        if ($filtroNombre !== "") {
            $parametrosFiltros["filtro_nombre"] = $filtroNombre;
        }

        if ($filtroBorrado !== "") {
            $parametrosFiltros["filtro_borrado"] = $filtroBorrado;
        }

        // URL base para el paginador 
        $urlBase = Sistema::app()->generaURL(["clienteAPI", "index"]);

        // Si hay filtros, los agregamos como query string
        if (!empty($parametrosFiltros)) {
            // Si ya hay un ?, usamos &, si no, usamos ?
            $urlBase .= (strpos($urlBase, '?') === false ? '?' : '&') . http_build_query($parametrosFiltros);
        }

        //Opciones para el paginador
        $opcPaginador = [
            "URL" => $urlBase,
            "PARAMS" => $parametrosFiltros,
            "TOTAL_REGISTROS" => $totalRegistros,
            "PAGINA_ACTUAL" => $pag,
            "REGISTROS_PAGINA" => $regPag,
            "TAMANIOS_PAGINA" => [
                4 => "4",
                8 => "8",
                12 => "12",
                16 => "16",
                20 => "20",
                25 => "25"
            ],
            "MOSTRAR_TAMANIOS" => true,
            "PAGINAS_MOSTRADAS" => 5
        ];

        // Datos para pasar a la vista
        $datos = [
            "filtroNombre" => $filtroNombre,
            "filtroBorrado" => $filtroBorrado,
            "pag" => $pag,
            "regPag" => $regPag,
            "opcPag" => $opcPaginador,
            "totalRegistros" => $totalRegistros
        ];

        //Dibujamos la vista
        $this->dibujaVista("index", [
            "filas" => $filas,
            "datos" => $datos
        ], "Clientes API");
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