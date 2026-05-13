

<div class="catalogo-container">

    <!-- Encabezado del catálogo -->
    <header class="catalogo-header">
        <h1>Catálogo de Bebidas </h1>
        <p>Bebidas obtenidas desde TheCocktailDB API</p>
    </header>

    <div class="info-api">
        <!-- Información sobre la fuente de datos -->
        <p>
            <strong>Fuente:</strong> TheCocktailDB (API externa)
        </p>
    </div>

    <!-- Contenedor principal del catálogo -->
    <?php if (!empty($productos)): ?>

        <div class="productos-grid">

            <?php
            //Mostramos cada bebida en una tarjeta
            foreach ($productos as $producto) {
                $this->dibujaVistaParcial("tarjetas", [
                    "producto" => $producto
                ]);
            }
            ?>

        </div>

    <?php else: ?>

        <!-- Mensaje si no hay bebidas disponibles -->
        <div class="sin-resultados">
            <h3>No hay bebidas disponibles</h3>
            <p>Intenta con otra búsqueda</p>
        </div>

    <?php endif; ?>

</div>