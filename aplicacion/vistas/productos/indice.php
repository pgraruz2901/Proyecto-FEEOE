<?php
// Requisitos para CPager
$this->textoHead = CPager::requisitos();
?>
<h2>Listado de Productos</h2>

<!-- Formulario de filtros -->
<div class="filtro-form">
    <form method="get" action="">
        <input type="hidden" name="ruta" value="productos">
        <input type="hidden" name="accion" value="index">

        <div class="filtro-row">
            <label for="filtro_nombre">Nombre:</label>
            <input type="text" id="filtro_nombre" name="filtro_nombre"
                value="<?php echo htmlspecialchars($filtroNombre); ?>">

            <label for="filtro_categoria">Categoría:</label>
            <input type="text" id="filtro_categoria" name="filtro_categoria"
                value="<?php echo htmlspecialchars($filtroCategoria); ?>">

            <label for="filtro_borrado">Borrado:</label>
            <select id="filtro_borrado" name="filtro_borrado">
                <option value="">Todos</option>
                <option value="0" <?php if ($filtroBorrado === "0") echo 'selected'; ?>>No</option>
                <option value="1" <?php if ($filtroBorrado === "1") echo 'selected'; ?>>Sí</option>
            </select>

            <input type="submit" value="Filtrar">

            <a href="<?php echo Sistema::app()->generaURL(
                            ["productos", "descargar"],
                            array_merge(
                                ["filtro_nombre" => $filtroNombre],
                                ["filtro_categoria" => $filtroCategoria],
                                ["filtro_borrado" => $filtroBorrado]
                            )
                        ); ?>"
                class="btn-descargar">
                Descargar CSV
            </a>
        </div>
    </form>
</div>

<?php
// Definir columnas del CGrid
$columnas = array(
    array("CAMPO" => "foto", "ETIQUETA" => "Foto", "ANCHO" => "50", "VISIBLE" => true),
    array("CAMPO" => "cod_producto", "ETIQUETA" => "Cód.", "ANCHO" => "50", "VISIBLE" => false),
    array("CAMPO" => "cod_categoria", "ETIQUETA" => "Cód. Cat.", "ANCHO" => "80", "VISIBLE" => false),
    array("CAMPO" => "categoria", "ETIQUETA" => "Categoría", "ANCHO" => "150", "VISIBLE" => true, "ALINEA" => "izq"),
    array("CAMPO" => "nombre", "ETIQUETA" => "Nombre", "ANCHO" => "200", "VISIBLE" => true, "ALINEA" => "izq"),
    array("CAMPO" => "fabricante", "ETIQUETA" => "Fabricante", "ANCHO" => "150", "VISIBLE" => true, "ALINEA" => "izq"),
    array("CAMPO" => "fecha_alta", "ETIQUETA" => "Fecha Alta", "ANCHO" => "100", "VISIBLE" => true, "ALINEA" => "cen"),
    array("CAMPO" => "unidades", "ETIQUETA" => "Unidades", "ANCHO" => "80", "VISIBLE" => true, "ALINEA" => "der"),
    array("CAMPO" => "precio_venta", "ETIQUETA" => "Precio Venta", "ANCHO" => "100", "VISIBLE" => true, "ALINEA" => "der"),
    array("CAMPO" => "borrado", "ETIQUETA" => "Borrado", "ANCHO" => "80", "VISIBLE" => true, "ALINEA" => "cen"),
    array("CAMPO" => "acciones", "ETIQUETA" => "Acciones", "ANCHO" => "150", "VISIBLE" => true, "ALINEA" => "cen")
);

// Preparar filas con acciones
$filasConAcciones = array();
foreach ($filas as $fila) {
    $borradoTexto = $fila["borrado"] == 1 ? "Sí" : "No";

    // Enlaces para acciones CRUD
    $acciones =
        CHTML::link("Ver", Sistema::app()->generaURL(["productos", "consultar"], ["id" => $fila["cod_producto"]]), ["class" => "btn-accion btn-ver"]) . " " .
        CHTML::link("Editar", Sistema::app()->generaURL(["productos", "modificar"], ["id" => $fila["cod_producto"]]), ["class" => "btn-accion btn-editar"]) . " " .
        CHTML::link("Borrar", Sistema::app()->generaURL(["productos", "borrar"], ["id" => $fila["cod_producto"]]), ["class" => "btn-accion btn-borrar"]);

    $fila["acciones"] = $acciones;
    $fila["borrado"] = $borradoTexto;
    $fila["precio_venta"] = number_format($fila["precio_venta"], 2) . "€";

    $filasConAcciones[] = $fila;
}

// Dibujar el CGrid
$grid = new CGrid($columnas, $filasConAcciones);
echo $grid->dibujate();

?>

<?php
// Crear el paginador
$pagi = new CPager($opcPag, array());
// Dibujar el paginador (superior)
echo $pagi->dibujate();
?>

<!-- Enlace a nuevo producto -->
<div class="nuevo-producto">
    <?php
    echo CHTML::link(
        CHTML::imagen("/imagenes/16x16/nuevo.png", "Nuevo Producto") . " Nuevo Producto",
        Sistema::app()->generaURL(["productos", "nuevo"]),
        ["class" => "btn-nuevo"]
    );
    ?>
</div>