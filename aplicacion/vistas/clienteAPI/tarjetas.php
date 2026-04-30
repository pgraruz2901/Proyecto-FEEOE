<!-- Tarjeta de producto -->
<div class="product-card">
    <div class="product-image">
        <?php
        // Si no hay foto o es la foto por defecto, se muestra la imagen por defecto
        $ruta = "/imagenes/tabla/iconoPersona.png";
        ?>
        <img src="<?php echo $ruta;?>" alt="<?php echo htmlspecialchars($cliente["nombre"]); ?>">

        <?php if ($cliente["borrado"] == 0): ?>
            <div class="stock-badge in-stock">Disponible</div>
        <?php else: ?>
            <div class="stock-badge out-of-stock">No disponible</div>

        <?php endif; ?>
    </div>
    <!-- Información del producto -->
    <div class="product-info">
        <p class="product-category"><?php echo htmlspecialchars($cliente["apellidos"]); ?></p>
        <h3 class="product-name"><?php echo htmlspecialchars($cliente["nombre"]); ?></h3>

        <div class="product-details">
            <p class="product-brand">Correo: <?php echo htmlspecialchars($cliente["email"]); ?></p>
            <p class="product-stock">Telefono: <?php echo intval($cliente["telefono"]); ?></p>
            <p class="cod-cliente">Código Cliente: <?php echo intval($cliente["cod_cliente"]); ?></p>
        </div>

        <div class="product-price">
            <span class="price-value">Saldo: <?php echo number_format($cliente["saldo"], 2); ?>€</span>
        </div>

        <!-- Botones de acción para cada producto -->
        <div class="product-actions">
            <?php
            echo CHTML::link("Borrar", Sistema::app()->generaURL(["clienteAPI", "borrar"], ["id" => $cliente["cod_cliente"]]), ["class" => "btn-product btn-primary"]);
            echo CHTML::link("Modificar", Sistema::app()->generaURL(["clienteAPI", "editar"], ["id" => $cliente["cod_cliente"]]), ["class" => "btn-product btn-secondary"]);
            echo CHTML::link("Nuevo", Sistema::app()->generaURL(["clienteAPI", "crear"]), ["class" => "btn-product btn-secondary"]);
            ?>
        </div>
    </div>
</div>

