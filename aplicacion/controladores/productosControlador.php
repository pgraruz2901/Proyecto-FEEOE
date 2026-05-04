<?php

class productosControlador extends CControlador
{
	public array $menuizq = [];
	public function __construct() {}
    //Accion index para mostrar el listado de productos con filtros y su paginación
	public function accionIndex()
	{
        //Menus
		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["productos"]
			]
		];
        $this->menuhead = [
			[
				"texto" => "Inicio",
				"enlace" => ["productos"]
			]
		];

		$producto = new Productos();
		// Obtener filtros de la URL
		$filtroNombre = isset($_GET["filtro_nombre"]) ? trim($_GET["filtro_nombre"]) : "";
		$filtroCategoria = isset($_GET["filtro_categoria"]) ? trim($_GET["filtro_categoria"]) : "";
		$filtroBorrado = isset($_GET["filtro_borrado"]) ? $_GET["filtro_borrado"] : "";

		// Construimos la cláusula WHERE
		$where = "";

		if ($filtroNombre !== "") {
			$nombreEscapado = CGeneral::addSlashes($filtroNombre);
			$where .= "nombre LIKE '%$nombreEscapado%' ";
		}
        
		if ($filtroCategoria !== "") {
			if ($where !== "") {
				$where .= " AND ";
			}
			$categoriaEscapada = CGeneral::addSlashes($filtroCategoria);
			$where .= "categoria LIKE '%$categoriaEscapada%' ";
		}

		if ($filtroBorrado !== "") {
			if ($where !== "") {
				$where .= " AND ";
			}
			$borradoEscapado = intval($filtroBorrado);
			$where .= "borrado = $borradoEscapado ";
		}

		// Obtenemos la página en la cual estamos y los registros por página
		$pag = isset($_GET["pag"]) ? intval($_GET["pag"]) : 1;
		$regPag = isset($_GET["reg_pag"]) ? intval($_GET["reg_pag"]) : 8;

		if ($pag < 1) $pag = 1;

		// Registros totales con filtros
		$opcionesCount = array();
		if ($where !== "") {
			$opcionesCount["where"] = $where;
		}
		$totalRegistros = $producto->buscarTodosNRegistros($opcionesCount);

		// Calculamos offset
		$offset = ($pag - 1) * $regPag;

		// Obtenemos los registros para la página actual
		$opciones = array();
		if ($where !== "") {
			$opciones["where"] = $where;
		}
		$opciones["order"] = "nombre ASC";
		$opciones["limit"] = "$offset, $regPag";

		$filas = $producto->buscarTodos($opciones);

		// Construimos la URL base con filtros para el CPager
		$parametrosFiltros = array();
		if ($filtroNombre !== "") {
			$parametrosFiltros["filtro_nombre"] = $filtroNombre;
		}
		if ($filtroCategoria !== "") {
			$parametrosFiltros["filtro_categoria"] = $filtroCategoria;
		}
		if ($filtroBorrado !== "") {
			$parametrosFiltros["filtro_borrado"] = $filtroBorrado;
		}

		// URL base del el pager con todos los filtros
		$urlBase = Sistema::app()->generaURL(["productos", "index"]);

        // Si hay filtros, los agregamos como query string
        if (!empty($parametrosFiltros)) {
            // Si ya hay un ?, usamos &, si no, usamos ?
            $urlBase .= (strpos($urlBase, '?') === false ? '?' : '&') . http_build_query($parametrosFiltros);
        }

		// Opciones para el CPager
		$opcPaginador = array(
			"URL" => $urlBase,
            "PARAMS" => $parametrosFiltros,
			"TOTAL_REGISTROS" => $totalRegistros,
			"PAGINA_ACTUAL" => $pag,
			"REGISTROS_PAGINA" => $regPag,
			"TAMANIOS_PAGINA" => array(4 => "4", 8 => "8",12 => "12", 16 => "16", 20 => "20", 25=>"25"),
			"MOSTRAR_TAMANIOS" => true,
			"PAGINAS_MOSTRADAS" => 5
		);

        //Recuperamos el id de la ultima bebida consultada guardada en coockies
        $ultimaBebidaId = $_COOKIE["ultima_bebida"] ?? null;
        $ultimaBebida = null;
        if ($ultimaBebidaId) {
            $prod = new Productos();
            if ($prod->buscarPorId($ultimaBebidaId)) {
                $ultimaBebida = $prod;
            }
        }

        //Datos a pasar en la vista
		$datos = array(
			"filas" => $filas,
			"filtroNombre" => $filtroNombre,
			"filtroCategoria" => $filtroCategoria,
			"filtroBorrado" => $filtroBorrado,
			"totalRegistros" => $totalRegistros,
			"pag" => $pag,
			"regPag" => $regPag,
			"opcPag" => $opcPaginador,
            "ultimaBebida" => $ultimaBebida
		);

		$this->dibujaVista("index", $datos, "Sanchez Garrido");
	}

    //Accion descargar para descargar el listado de productos con los filtros aplicados en formato CSV
	public function accionDescargar()
    {
        //Si hay usuario logueado se podra hacer sino no
        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "login"]);
        }
        //Si el usuario no tiene permiso 9 se muestra error
       if (!Sistema::app()->Acceso()->puedePermiso(9)) {
            Sistema::app()->paginaError(404, "No tienes permiso 9");
        }

        $producto = new Productos();

        //Cogemos los filtros de la URL para aplicalos en la consulta
        $filtroNombre = isset($_GET["filtro_nombre"]) ? trim($_GET["filtro_nombre"]) : "";
        $filtroCategoria = isset($_GET["filtro_categoria"]) ? trim($_GET["filtro_categoria"]) : "";
        $filtroBorrado = isset($_GET["filtro_borrado"]) ? $_GET["filtro_borrado"] : "";

        // Construimos la cláusula WHERE para aplicar los filtros en la consulta
        $where = "";

        if ($filtroNombre !== "") {
            $nombreEscapado = CGeneral::addSlashes($filtroNombre);
            $where .= "nombre LIKE '%$nombreEscapado%' ";
        }

        if ($filtroCategoria !== "") {
            if ($where !== "") {
                $where .= " AND ";
            }
            $categoriaEscapada = CGeneral::addSlashes($filtroCategoria);
            $where .= "categoria LIKE '%$categoriaEscapada%' ";
        }

        if ($filtroBorrado !== "") {
            if ($where !== "") {
                $where .= " AND ";
            }
            $borradoEscapado = intval($filtroBorrado);
            $where .= "borrado = $borradoEscapado ";
        }

        //opciones para la consulta con filtros
        $opciones = array();
        if ($where !== "") {
            $opciones["where"] = $where;
        }
        $opciones["order"] = "nombre ASC";

        //buscamos los productos con los filtros aplicados
        $filas = $producto->buscarTodos($opciones);

        // Configuramos las cabeceras para la descarga del archivo CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="productos_' . date('YmdHis') . '.csv"');

        $salida = fopen('php://output', 'w');

        // Escribimos la cabecera del CSV
        fputcsv($salida, array(
            'cod_producto',
            'cod_categoria',
            'nombre',
            'fabricante',
            'fecha_alta',
            'unidades',
            'precio_base',
            'iva',
            'precio_iva',
            'precio_venta',
            'foto',
            'borrado'
        ), ';');

        // Escribimos los datos de los productos en el CSV
        foreach ($filas as $fila) {
            fputcsv($salida, array(
                $fila["cod_producto"],
                $fila["cod_categoria"],
                $fila["nombre"],
                $fila["fabricante"],
                date("Y-m-d", strtotime($fila["fecha_alta"])),
                $fila["unidades"],
                number_format($fila["precio_base"], 2, '.', ''),
                $fila["iva"],
                number_format($fila["precio_iva"], 2, '.', ''),
                number_format($fila["precio_venta"], 2, '.', ''),
                $fila["foto"],
                $fila["borrado"] == 1 ? 'Sí' : 'No'
            ), ';');
        }

        fclose($salida);
        exit;
    }

    //Accion consultar para mostrar los detalles de un producto
    public function accionConsultar()
    {
        //Menus
        $this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["productos"]
			]
		];
        $this->menuhead = [
			[
				"texto" => "Inicio",
				"enlace" => ["productos"]
			]
		];
        //Si hay usuario logueado se podra hacer sino no
        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "login"]);
        }

        //Obtenemos el id del producto a consultar
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

        //Si el id no es valido mostramos error 
        if ($id <= 0) {
            Sistema::app()->paginaError(404, "Producto no encontrado");
            return;
        }
        $producto = new Productos();

        //Buscamos el producto por su id, si no se encuentra mostramos error
        if (!$producto->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Producto no encontrado");
            return;
        }

        //Guardamos el id del ultimo producto que hemos consultado para mostrarlo en la vista
        setcookie("ultima_bebida", $id, time() + 86400, "/");

        //Datos a pasar a la vista
        $datos = array(
            "producto" => $producto
        );

        //Dibujamos la vista para consultar el producto con sus datos correspondientes
        $this->dibujaVista("consultar", $datos, "Consultar Producto");
    }

    //Accion nuevo para crear un nuevo producto y mostrar el formulario de creación
    public function accionNuevo()
    {
        //Menus
        $this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["productos"]
			],
			[
				"texto" => "Nuevo Producto",
				"enlace" => ["productos", "nuevo"]
			]
		];
        $this->menuhead = [
			[
				"texto" => "Inicio",
				"enlace" => ["productos"]
			],
			[
				"texto" => "Nuevo Producto",
				"enlace" => ["productos", "nuevo"]
			]
		];
        //Si hay usuario logueado se podra hacer sino no
        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "login"]);
        }
        //Si el usuario no tiene permiso 9 se muestra error
       if (!Sistema::app()->Acceso()->puedePermiso(9)) {
            Sistema::app()->paginaError(404, "No tienes permiso 9");
        }

        
        $producto = new Productos();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $producto->setValores($_POST["Productos"]);

            //Obtenemos el nombre de la categoria para mostrarlo en la vista de consulta
            if (!empty($producto->cod_categoria)) {
                $cat = new Categorias();
                if ($cat->buscarPorId($producto->cod_categoria)) {
                    $producto->categoria = $cat->descripcion;
                }
            }

            //Gestionamos la subida de la foto del producto
            if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
                $archivo = $_FILES["foto"];
                $nombreArchivo = $archivo["name"];
                $tipoArchivo = $archivo["type"];
                $tempArchivo = $archivo["tmp_name"];

                if (strpos($tipoArchivo, "image/") === 0) {
                    $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
                    $nuevoNombre = "prod_" . time() . "_" . mt_rand(1000, 9999) . "." . $extension;
                    $rutaDestino = $_SERVER["DOCUMENT_ROOT"] . "/imagenes/tabla/" . $nuevoNombre;

                    if (move_uploaded_file($tempArchivo, $rutaDestino)) {
                        $producto->foto = $nuevoNombre;
                    }
                }
            }

            // Si no se ha subido una foto, se asigna la foto por defecto
            if (empty($producto->foto)) {
                $producto->foto = "default.jpg";
            }

            // Convertimos la fecha al formato correcto para la base de datos
            if (isset($producto->fecha_alta) && !empty($producto->fecha_alta)) {
                $fechaPartes = explode("-", $producto->fecha_alta);
                if (count($fechaPartes) === 3) {
                    $producto->fecha_alta = $fechaPartes[2] . "/" . $fechaPartes[1] . "/" . $fechaPartes[0];
                }
            }
            //Validamos el producto y si es correcto lo añadimos a la base de datos
            if ($producto->validar()) {
                $producto->precio_iva = $producto->precio_base * $producto->iva / 100;
                $producto->precio_venta = $producto->precio_base + $producto->precio_iva;

                if ($producto->guardar()) {
                    header("Location: " . Sistema::app()->generaURL(["productos", "index"]));
                    exit;
                }
            }else{
                foreach ($producto->getErrores() as $error) {
                    echo "<p class='error'>$error</p>";
                }
            }
        }

        $categoria = new Categorias();
        $categorias = $categoria->buscarTodos();
        $listaCategorias = array();
        // Creamos un array con las categorias para mostrarlo en el select del formulario
        foreach ($categorias as $cat) {
            $listaCategorias[$cat["cod_categoria"]] = $cat["descripcion"];
        }

        // Convertimos la fecha al formato correcto para mostrarlo en el formulario
        if (!empty($producto->fecha_alta)) {
            $producto->fecha_alta = date("Y-m-d", strtotime($producto->fecha_alta));
        }
        //Datos a pasar a la vista
        $datos = array(
            "producto" => $producto,
            "categorias" => $listaCategorias
        );

        //Dibujamos la vista para crear un nuevo producto con sus datos correspondientes
        $this->dibujaVista("nuevo", $datos, "Nuevo Producto");
    }

    //Accion modificar para modificar un producto existente y mostrar el formulario de modificación con los datos de dicho producto
    public function accionModificar()
    {
        //Menus
        $this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["productos"]
			]
		];
        $this->menuhead = [
			[
				"texto" => "Inicio",
				"enlace" => ["productos"]
			]
		];
        //Si hay usuario logueado se podra hacer sino no
        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "login"]);
        }
        //Si el usuario no tiene permiso 9 se muestra error
       if (!Sistema::app()->Acceso()->puedePermiso(9)) {
            Sistema::app()->paginaError(404, "No tienes permiso 9");
        }

        
        //Obtenemos el id del producto a modificar
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

        //Si el id no es valido mostramos error
        if ($id <= 0) {
            Sistema::app()->paginaError(404, "Producto no encontrado");
            return;
        }

        $producto = new Productos();

        //Buscamos el producto por su id, si no se encuentra mostramos error
        if (!$producto->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Producto no encontrado");
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $fotoActual = $producto->foto;

            $producto->setValores($_POST["Productos"]);
            //Obtenemos el nombre de la categoria para mostrarlo en la vista de consulta
            if (!empty($producto->cod_categoria)) {
                $cat = new Categorias();
                if ($cat->buscarPorId($producto->cod_categoria)) {
                    $producto->categoria = $cat->descripcion;
                }
            }
            //Si no se ha especificado una nueva foto, se mantiene la foto actual
            if (empty($producto->foto)) {
                $producto->foto = $fotoActual;
            }

            
            if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
                $archivo = $_FILES["foto"];
                $nombreArchivo = $archivo["name"];
                $tipoArchivo = $archivo["type"];
                $tempArchivo = $archivo["tmp_name"];

                if (strpos($tipoArchivo, "image/") === 0) {
                    $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
                    $nuevoNombre = "prod_" . time() . "_" . mt_rand(1000, 9999) . "." . $extension;
                    $rutaDestino = $_SERVER["DOCUMENT_ROOT"] . "/imagenes/tabla/" . $nuevoNombre;

                    if (move_uploaded_file($tempArchivo, $rutaDestino)) {
                        $producto->foto = $nuevoNombre;
                    }
                }
            }

            // Convertimos la fecha al formato correcto para la base de datos
            if (isset($producto->fecha_alta) && !empty($producto->fecha_alta)) {
                $fechaPartes = explode("-", $producto->fecha_alta);
                if (count($fechaPartes) === 3) {
                    $producto->fecha_alta = $fechaPartes[2] . "/" . $fechaPartes[1] . "/" . $fechaPartes[0];
                }
            }

            //Validamos el producto y si es correcto lo modificamos en la base de datos
            if ($producto->validar()) {
                $producto->precio_iva = $producto->precio_base * $producto->iva / 100;
                $producto->precio_venta = $producto->precio_base + $producto->precio_iva;

                if ($producto->guardar()) {
                    header("Location: " . Sistema::app()->generaURL(["productos", "index"]));
                    exit;
                }
            }
        }

        $categoria = new Categorias();
        $categorias = $categoria->buscarTodos();
        $listaCategorias = array();
        // Creamos un array con las categorias para mostrarlo en el select del formulario
        foreach ($categorias as $cat) {
            $listaCategorias[$cat["cod_categoria"]] = $cat["descripcion"];
        }

        // Convertimos la fecha al formato correcto para mostrarlo en el formulario
        if (!empty($producto->fecha_alta)) {
            $producto->fecha_alta = date("Y-m-d", strtotime($producto->fecha_alta));
        }

        //Datos a pasar a la vista
        $datos = array(
            "producto" => $producto,
            "categorias" => $listaCategorias
        );

        //Dibujamos la vista para modificar un producto con sus datos correspondientes
        $this->dibujaVista("modificar", $datos, "Modificar Producto");
    }

    //Accion borrar para marcar un producto como borrado en la base de datos
    public function accionBorrar()
    {
        //Si hay usuario logueado se podra hacer sino no
        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "login"]);
        }
        //Si el usuario no tiene permiso 9 se muestra error
       if (!Sistema::app()->Acceso()->puedePermiso(9)) {
            Sistema::app()->paginaError(404, "No tienes permiso 9");
        }

        
        //Obtenemos el id del producto a borrar
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

        //Si el id no es valido mostramos error
        if ($id <= 0) {
            Sistema::app()->paginaError(404, "Producto no encontrado");
            return;
        }

        $producto = new Productos();

        //Buscamos el producto por su id, si no se encuentra mostramos error
        if (!$producto->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Producto no encontrado");
            return;
        }

        //Ponemos el borrado logico en true
        $producto->borrado = 1;

        //Guardamos el producto con el borrado logico, si se guarda correctamente redirigimos al listado de productos, sino mostramos error
        if ($producto->guardar()) {
            header("Location: " . Sistema::app()->generaURL(["productos", "index"]));
            exit;
        } else {
            Sistema::app()->paginaError(500, "Error al borrar el producto");
        }
    }
}
