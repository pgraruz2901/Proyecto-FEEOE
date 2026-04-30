
<?php
// Requisitos para el CPager
$this->textoHead = CPager::requisitos();
?>
<header class="catalogo-header">
    <h1>Clientes</h1>
    <p>Estos son nuestros Clientes</p>
</header>
<!-- Formulario con los filtros de los productos -->
<div class="filtros-bar">
        <form method="get" action="">
            <input type="hidden" name="ruta" value="inicial">
            <input type="hidden" name="accion" value="index">

            <!-- Filtro de nombre -->
            <div class="filtros-grid">
                <div class="filtro-grupo">
                    <input type="text" id="filtro_nombre" name="filtro_nombre"
                        value="<?php echo htmlspecialchars($datos["filtroNombre"]); ?>"
                        placeholder="Buscar productos...">
                </div>

                <!-- Filtro de borrado -->
                <div class="filtro-grupo">
                    <select id="filtro_borrado" name="filtro_borrado">
                        <option value="">Todos los estados</option>
                        <option value="0" <?php if ($datos["filtroBorrado"] === "0") echo 'selected'; ?>>Disponible</option>
                        <option value="1" <?php if ($datos["filtroBorrado"] === "1") echo 'selected'; ?>>No Disponible</option>
                    </select>
                </div>

                <button type="submit" class="btn-filtrar">Filtrar</button>
            </div>
        </form>
    </div>
<?php
    //Mostrar tabla de clientes
    if (count($filas) > 0): ?>
        <div class="productos-grid">
            <?php
            //Recorremos un array de kas filas para dibujar por cada producto una tarjeta con el mismo
            foreach ($filas as $fila) {
                $cliente = $fila;
                $this->dibujaVistaParcial("tarjetas", compact("cliente"));
            }
            ?>
        </div>
    <?php else: ?>
        <div class="sin-resultados">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <h3>No se encontraron CLientes</h3>
            <p>Intenta con otros filtros de búsqueda</p>
        </div>
    <?php endif; ?>
     <?php
    // Creamos el paginador de las tarjetas
    $pagi = new CPager($datos["opcPag"], array());
    // Dibujamos el paginador
    echo $pagi->dibujate();
    ?>

<!-- Estilos para la tabla de clientes -->
 <style>
    .filtros-bar {
        margin-left: 20px;
    }
    .catalogo-header {
        margin-left: 20px;
    }
    .productos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
        padding-left: 20px;
    }
    div.tabla table.tabla {
        width: 90%;
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        font-size: 14px;
        padding-left: 20px;
    }
    div.tabla {
        padding-left: 30px;
    }
    div.tabla table.tabla th {
        background: #f97316;
        color: white;
        padding: 12px;
        text-align: left;
        font-weight: 600;
    }

    div.tabla table.tabla td {
        padding: 10px 12px;
        border-bottom: 1px solid #eee;
    }

    div.tabla table.tabla tr:hover {
        background: #fff7ed;
        transition: 0.2s;
    }

    div.tabla table.tabla tr.par {
        background: #fafafa;
    }

    div.tabla table.tabla tr.impar {
        background: white;
    }
 </style>