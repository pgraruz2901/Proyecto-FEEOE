<?php
// Requisitos para el CPager
$this->textoHead = CPager::requisitos();
?>

<div class="catalogo-container">
    <header class="catalogo-header">
        <h1>Catálogo</h1>
        <p>Explora nuestra colección de productos</p>
    </header>

    <!-- Formulario con los filtros de los productos -->
    <div class="filtros-bar">
        <form method="get" action="">
            <input type="hidden" name="ruta" value="inicial">
            <input type="hidden" name="accion" value="index">

            <div class="filtros-grid">
                <div class="filtro-grupo">
                    <input type="text" id="filtro_nombre" name="filtro_nombre"
                        value="<?php echo htmlspecialchars($filtroNombre); ?>"
                        placeholder="Buscar productos...">
                </div>

                <div class="filtro-grupo">
                    <select id="filtro_categoria" name="filtro_categoria">
                        <option value="">Todas las categorías</option>
                        <?php
                        // Obtenemos las categorías 
                        $catModel = new Categorias();
                        $cats = $catModel->buscarTodos();
                        foreach ($cats as $cat):
                        ?>
                        <option value="<?php echo htmlspecialchars($cat["descripcion"]); ?>"
                            <?php if ($filtroCategoria === $cat["descripcion"]) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($cat["descripcion"]); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filtro-grupo">
                    <select id="filtro_borrado" name="filtro_borrado">
                        <option value="">Todos los estados</option>
                        <option value="0" <?php if ($filtroBorrado === "0") echo 'selected'; ?>>Disponibles</option>
                        <option value="1" <?php if ($filtroBorrado === "1") echo 'selected'; ?>>Agotados</option>
                    </select>
                </div>

                <button type="submit" class="btn-filtrar">Filtrar</button>
            </div>
        </form>
    </div>

    <?php if (count($filas) > 0): ?>
        <div class="productos-grid">
            <?php
            //Recorremos un array de kas filas para dibujar por cada producto una tarjeta con el mismo
            foreach ($filas as $fila) {
                $producto = $fila;
                $this->dibujaVistaParcial("tarjetas", compact("producto"));
            }
            ?>
        </div>
    <?php else: ?>
        <div class="sin-resultados">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <h3>No se encontraron productos</h3>
            <p>Intenta con otros filtros de búsqueda</p>
        </div>
    <?php endif; ?>

    <?php
    // Creamos el paginador de las tarjetas
    $pagi = new CPager($opcPag, array());
    // Dibujamos el paginador
    echo $pagi->dibujate();
    ?>
</div>
