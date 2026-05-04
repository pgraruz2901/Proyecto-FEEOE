<!-- Tarjeta de producto -->
<div class="product-card">
    <div class="product-image">
        <?php
        // Si no hay foto o es la foto por defecto, se muestra la imagen por defecto
        $ruta = "/imagenes/tabla/" . (empty($producto["foto"]) || $producto["foto"] === "default.jpg" ? "default.jpg" : $producto["foto"]);
        ?>
        <img src="<?php echo $ruta; ?>" alt="<?php echo htmlspecialchars($producto["nombre"]); ?>">

        <?php if ($producto["borrado"] == 1): ?>
            <div class="stock-badge out-of-stock">No disponible</div>
        <?php else: ?>
            <div class="stock-badge in-stock">Disponible</div>
        <?php endif; ?>
    </div>
    <!-- Información del producto -->
    <div class="product-info">
        <p class="product-category"><?php echo htmlspecialchars($producto["categoria"]); ?></p>
        <h3 class="product-name"><?php echo htmlspecialchars($producto["nombre"]); ?></h3>

        <div class="product-details">
            <p class="product-brand"><?php echo htmlspecialchars($producto["fabricante"]); ?></p>
            <p class="product-stock">Stock: <?php echo intval($producto["unidades"]); ?> uds</p>
            <p class="cod-cliente">Código Cliente: <?php echo intval($producto["cod_cliente"]); ?></p>
        </div>

        <div class="product-price">
            <span class="price-value"><?php echo number_format($producto["precio_venta"], 2); ?>€</span>
        </div>

        <!-- Botones de acción para cada producto -->
        <div class="product-actions">
            <?php
            echo CHTML::link("Ver detalles", Sistema::app()->generaURL(["productos", "consultar"], ["id" => $producto["cod_producto"]]), ["class" => "btn-product btn-primary"]);
            echo CHTML::link("Editar", Sistema::app()->generaURL(["productos", "modificar"], ["id" => $producto["cod_producto"]]), ["class" => "btn-product btn-secondary"]);
            echo CHTML::link("Borrar", Sistema::app()->generaURL(["productos", "borrar"], ["id" => $producto["cod_producto"]]), ["class" => "btn-product btn-secondary"]);
            ?>
        </div>
    </div>
</div>
