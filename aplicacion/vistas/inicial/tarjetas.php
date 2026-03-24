<div class="product-card">
    <div class="product-image">
        <?php
        $ruta = "/imagenes/tabla/" . (empty($producto["foto"]) || $producto["foto"] === "base.png" ? "base.png" : $producto["foto"]);
        ?>
        <img src="<?php echo $ruta; ?>" alt="<?php echo htmlspecialchars($producto["nombre"]); ?>">

        <?php if ($producto["borrado"] == 1): ?>
            <div class="stock-badge out-of-stock">Agotado</div>
        <?php else: ?>
            <div class="stock-badge in-stock">Disponible</div>
        <?php endif; ?>
    </div>

    <div class="product-info">
        <p class="product-category"><?php echo htmlspecialchars($producto["categoria"]); ?></p>
        <h3 class="product-name"><?php echo htmlspecialchars($producto["nombre"]); ?></h3>

        <div class="product-details">
            <p class="product-brand"><?php echo htmlspecialchars($producto["fabricante"]); ?></p>
            <p class="product-stock">Stock: <?php echo intval($producto["unidades"]); ?> uds</p>
        </div>

        <div class="product-price">
            <span class="price-value"><?php echo number_format($producto["precio_venta"], 2); ?>€</span>
        </div>

        <div class="product-actions">
            <?php
            echo CHTML::link("Ver detalles", Sistema::app()->generaURL(["inicial", "consultar"], ["id" => $producto["cod_producto"]]), ["class" => "btn-product btn-primary"]);
            echo CHTML::link("Editar", Sistema::app()->generaURL(["inicial", "modificar"], ["id" => $producto["cod_producto"]]), ["class" => "btn-product btn-secondary"]);
            echo CHTML::link("Borrar", Sistema::app()->generaURL(["inicial", "borrar"], ["id" => $producto["cod_producto"]]), ["class" => "btn-product btn-secondary"]);
            ?>
        </div>
    </div>
</div>

