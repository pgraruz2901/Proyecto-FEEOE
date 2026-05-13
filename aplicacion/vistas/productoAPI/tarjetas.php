<!-- Tarjeta bebida API -->
<div class="product-card">

    <!-- Imagen de la bebida -->
    <div class="product-image">

        <img src="<?php echo $producto["strDrinkThumb"]; ?>"
             alt="<?php echo htmlspecialchars($producto["strDrink"]); ?>">

        <div class="stock-badge in-stock">
            Bebida
        </div>

    </div>

    <div class="product-info">

        <!-- La categoría de la bebida -->
        <p class="product-category">
            <?php echo htmlspecialchars($producto["strCategory"]); ?>
        </p>

        <!-- El nombre de la bebida -->
        <h3 class="product-name">
            <?php echo htmlspecialchars($producto["strDrink"]); ?>
        </h3>

        <!-- Información adicional de la bebida -->
        <div class="product-details">

            <p>
                <?php echo substr(
                    htmlspecialchars($producto["strInstructions"]),
                    0,
                    90
                ); ?>...
            </p>

        </div>

        <!-- En lugar de precio, mostramos si es alcohólica o no -->    
        <div class="product-price">
            <span class="price-value">
                <?php echo htmlspecialchars($producto["strAlcoholic"]); ?>
            </span>
        </div>

        <!-- Botones de acción para cada bebida -->
        <div class="product-actions">

            <?php
            echo CHTML::link(
                "Ver",
                "#",
                ["class" => "btn-product btn-primary"]
            );

            echo CHTML::link(
                "Detalle",
                "#",
                ["class" => "btn-product btn-secondary"]
            );
            ?>

        </div>

    </div>

</div>