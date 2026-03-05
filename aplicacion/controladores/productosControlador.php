<?php

class productosControlador extends CControlador
{
    public array $menuizq = [];
    public array $menuhead = [];
    public function __construct() {}
    public function accionIndex()
    {
        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "login"]);
        }
        
        $this->menuhead = [
            [
                "texto" => "Inicio",
                "enlace" => ["inicial"]
            ],
            [
                "texto" => "Productos",
                "enlace" => ["productos"]
            ]
        ];
        $this->menuizq = [
            [
                "texto" => "Inicio",
                "enlace" => ["inicial"]
            ],
            [
                "texto" => "Productos",
                "enlace" => ["productos"]
            ]
        ];
        $producto = new Productos();

        $filtroNombre = isset($_GET["filtro_nombre"]) ? trim($_GET["filtro_nombre"]) : "";
        $filtroCategoria = isset($_GET["filtro_categoria"]) ? trim($_GET["filtro_categoria"]) : "";
        $filtroBorrado = isset($_GET["filtro_borrado"]) ? $_GET["filtro_borrado"] : "";

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

        $pag = isset($_GET["pag"]) ? intval($_GET["pag"]) : 1;
        $regPag = isset($_GET["reg_pag"]) ? intval($_GET["reg_pag"]) : 10;
    
        if ($pag < 1) $pag = 1;

        $opcionesCount = array();
        if ($where !== "") {
            $opcionesCount["where"] = $where;
        }
        $totalRegistros = $producto->buscarTodosNRegistros($opcionesCount);

        $offset = ($pag - 1) * $regPag;

        $opciones = array();
        if ($where !== "") {
            $opciones["where"] = $where;
        }
        $opciones["order"] = "nombre ASC";
        $opciones["limit"] = "$offset, $regPag";

        $filas = $producto->buscarTodos($opciones);

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

        $urlBase = Sistema::app()->generaURL(
            array_merge(["productos", "index"], $parametrosFiltros)
        );
        
        $opcPaginador = array(
            "URL" => $urlBase,
            "TOTAL_REGISTROS" => $totalRegistros,
            "PAGINA_ACTUAL" => $pag,
            "REGISTROS_PAGINA" => $regPag,
            "TAMANIOS_PAGINA" => array(
                    5 => "5",
                    10 => "10",
                    20 => "20"
                ),
            "MOSTRAR_TAMANIOS" => true,
            "PAGINAS_MOSTRADAS" => 5
        );

        $datos = array(
            "filas" => $filas,
            "filtroNombre" => $filtroNombre,
            "filtroCategoria" => $filtroCategoria,
            "filtroBorrado" => $filtroBorrado,
            "totalRegistros" => $totalRegistros,
            "pag" => $pag,
            "regPag" => $regPag,
            "opcPag" => $opcPaginador
        );

        $this->dibujaVista("indice", $datos, "Listado de Productos");
    }
    public function accionDescargar()
    {
        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "login"]);
        }

        $producto = new Productos();

        $filtroNombre = isset($_GET["filtro_nombre"]) ? trim($_GET["filtro_nombre"]) : "";
        $filtroCategoria = isset($_GET["filtro_categoria"]) ? trim($_GET["filtro_categoria"]) : "";
        $filtroBorrado = isset($_GET["filtro_borrado"]) ? $_GET["filtro_borrado"] : "";

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

        $opciones = array();
        if ($where !== "") {
            $opciones["where"] = $where;
        }
        $opciones["order"] = "nombre ASC";

        $filas = $producto->buscarTodos($opciones);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="productos_' . date('YmdHis') . '.csv"');

        $salida = fopen('php://output', 'w');

        fputcsv($salida, array(
            'Código',
            'Categoría',
            'Nombre',
            'Fabricante',
            'Fecha Alta',
            'Unidades',
            'Precio Base',
            'IVA',
            'Precio con IVA',
            'Precio Venta',
            'Foto',
            'Borrado'
        ), ';');

        foreach ($filas as $fila) {
            fputcsv($salida, array(
                $fila["cod_producto"],
                $fila["cod_categoria"],
                $fila["nombre"],
                $fila["fabricante"],
                $fila["fecha_alta"],
                $fila["unidades"],
                $fila["precio_base"],
                $fila["iva"],
                $fila["precio_iva"],
                $fila["precio_venta"],
                $fila["foto"],
                $fila["borrado"] == 1 ? 'SI' : 'NO'
            ), ';');
        }

        fclose($salida);
        exit;
    }

    public function accionConsultar()
    {
        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "login"]);
        }
        
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

        if ($id <= 0) {
            Sistema::app()->paginaError(404, "Producto no encontrado");
            return;
        }
        $producto = new Productos();

        if (!$producto->buscarPorId($id)) {
            echo "No se ha encontrao";
            Sistema::app()->paginaError(404, "Producto no encontrado");
            return;
        }

        $datos = array(
            "producto" => $producto
        );

        $this->dibujaVista("consultar", $datos, "Consultar Producto");
    }

    public function accionNuevo()
    {
        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "login"]);
        }
        
        $producto = new Productos();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $producto->setValores($_POST["Productos"]);

            if (!empty($producto->cod_categoria)) {
                $cat = new Categorias();
                if ($cat->buscarPorId($producto->cod_categoria)) {
                    $producto->categoria = $cat->descripcion;
                }
            }

            if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
                $archivo = $_FILES["foto"];
                $nombreArchivo = $archivo["name"];
                $tipoArchivo = $archivo["type"];
                $tempArchivo = $archivo["tmp_name"];

                if (strpos($tipoArchivo, "image/") === 0) {
                    $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
                    $nuevoNombre = "prod_" . time() . "_" . mt_rand(1000, 9999) . "." . $extension;
                    $rutaDestino = $_SERVER["DOCUMENT_ROOT"] . "/imagenes/productos/" . $nuevoNombre;

                    if (move_uploaded_file($tempArchivo, $rutaDestino)) {
                        $producto->foto = $nuevoNombre;
                    }
                }
            }

            if (empty($producto->foto)) {
                $producto->foto = "base.png";
            }

            if (isset($producto->fecha_alta) && !empty($producto->fecha_alta)) {
                $fechaPartes = explode("-", $producto->fecha_alta);
                if (count($fechaPartes) === 3) {
                    $producto->fecha_alta = $fechaPartes[2] . "/" . $fechaPartes[1] . "/" . $fechaPartes[0];
                }
            }

            if ($producto->validar()) {
                echo "Validación correcta";
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
        foreach ($categorias as $cat) {
            $listaCategorias[$cat["cod_categoria"]] = $cat["descripcion"];
        }

        if (!empty($producto->fecha_alta)) {
            $producto->fecha_alta = date("Y-m-d", strtotime($producto->fecha_alta));
        }
        $datos = array(
            "producto" => $producto,
            "categorias" => $listaCategorias
        );

        $this->dibujaVista("nuevo", $datos, "Nuevo Producto");
    }

    public function accionModificar()
    {
        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "login"]);
        }
        
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

        if ($id <= 0) {
            Sistema::app()->paginaError(404, "Producto no encontrado");
            return;
        }

        $producto = new Productos();

        if (!$producto->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Producto no encontrado");
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $fotoActual = $producto->foto;

            $producto->setValores($_POST["Productos"]);

            if (!empty($producto->cod_categoria)) {
                $cat = new Categorias();
                if ($cat->buscarPorId($producto->cod_categoria)) {
                    $producto->categoria = $cat->descripcion;
                }
            }

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
                    $rutaDestino = $_SERVER["DOCUMENT_ROOT"] . "/imagenes/productos/" . $nuevoNombre;

                    if (move_uploaded_file($tempArchivo, $rutaDestino)) {
                        $producto->foto = $nuevoNombre;
                    }
                }
            }

            if (isset($producto->fecha_alta) && !empty($producto->fecha_alta)) {
                $fechaPartes = explode("-", $producto->fecha_alta);
                if (count($fechaPartes) === 3) {
                    $producto->fecha_alta = $fechaPartes[2] . "/" . $fechaPartes[1] . "/" . $fechaPartes[0];
                }
            }

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
        foreach ($categorias as $cat) {
            $listaCategorias[$cat["cod_categoria"]] = $cat["descripcion"];
        }

        if (!empty($producto->fecha_alta)) {
            $producto->fecha_alta = date("Y-m-d", strtotime($producto->fecha_alta));
        }

        $datos = array(
            "producto" => $producto,
            "categorias" => $listaCategorias
        );

        $this->dibujaVista("modificar", $datos, "Modificar Producto");
    }

    public function accionBorrar()
    {
        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->irAPagina(["registro", "login"]);
        }
        
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

        if ($id <= 0) {
            Sistema::app()->paginaError(404, "Producto no encontrado");
            return;
        }

        $producto = new Productos();

        if (!$producto->buscarPorId($id)) {
            Sistema::app()->paginaError(404, "Producto no encontrado");
            return;
        }

        $producto->borrado = 1;

        if ($producto->guardar()) {
            header("Location: " . Sistema::app()->generaURL(["productos", "Index"]));
            exit;
        } else {
            Sistema::app()->paginaError(500, "Error al borrar el producto");
        }
    }
    public function accionInforme() {}
}
