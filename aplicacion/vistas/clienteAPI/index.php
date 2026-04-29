

<header class="catalogo-header">
    <h1>Clientes</h1>
    <p>Estos son nuestros Clientes</p>
</header>
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