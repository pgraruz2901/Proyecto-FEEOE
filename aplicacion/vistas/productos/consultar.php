<h2>Consultar Producto</h2>

<table class="tabla-consulta">
    <tr>
        <th>Campo</th>
        <th>Valor</th>
    </tr>
    <tr>
        <td><?php echo CHTML::modeloLabel($producto, "cod_categoria"); ?></td>
        <td><?php echo htmlspecialchars($producto->cod_categoria); ?></td>
    </tr>
    <tr>
        <td><?php echo CHTML::modeloLabel($producto, "categoria"); ?></td>
        <td><?php echo htmlspecialchars($producto->categoria); ?></td>
    </tr>
    <tr>
        <td><?php echo CHTML::modeloLabel($producto, "nombre"); ?></td>
        <td><?php echo htmlspecialchars($producto->nombre); ?></td>
    </tr>
    <tr>
        <td><?php echo CHTML::modeloLabel($producto, "fabricante"); ?></td>
        <td><?php echo htmlspecialchars($producto->fabricante); ?></td>
    </tr>
    <tr>
        <td><?php echo CHTML::modeloLabel($producto, "fecha_alta"); ?></td>
        <td><?php echo htmlspecialchars($producto->fecha_alta); ?></td>
    </tr>
    <tr>
        <td><?php echo CHTML::modeloLabel($producto, "unidades"); ?></td>
        <td><?php echo htmlspecialchars($producto->unidades); ?></td>
    </tr>
    <tr>
        <td><?php echo CHTML::modeloLabel($producto, "precio_base"); ?></td>
        <td><?php echo number_format($producto->precio_base, 2); ?>€</td>
    </tr>
    <tr>
        <td><?php echo CHTML::modeloLabel($producto, "iva"); ?></td>
        <td><?php echo htmlspecialchars($producto->iva); ?>%</td>
    </tr>
    <tr>
        <td><?php echo CHTML::modeloLabel($producto, "precio_iva"); ?></td>
        <td><?php echo number_format($producto->precio_iva, 2); ?>€</td>
    </tr>
    <tr>
        <td><?php echo CHTML::modeloLabel($producto, "precio_venta"); ?></td>
        <td><?php echo number_format($producto->precio_venta, 2); ?>€</td>
    </tr>
    <tr>
        <td><?php echo CHTML::modeloLabel($producto, "foto"); ?></td>
        <td><?php echo htmlspecialchars($producto->foto); ?></td>
    </tr>
    <tr>
        <td><?php echo CHTML::modeloLabel($producto, "borrado"); ?></td>
        <td><?php echo $producto->borrado == 1 ? "Sí" : "No"; ?></td>
    </tr>
</table>

<div class="botones-accion">
    <?php
    echo CHTML::link(
        "Volver al listado",
        Sistema::app()->generaURL(["productos", "index"]),
        ["class" => "btn-volver"]
    );
    ?>
</div>

<style>
    .tabla-consulta {
        width: 100%;
        max-width: 600px;
        margin: 20px auto;
        border-collapse: collapse;
    }

    .tabla-consulta th {
        background: #007bff;
        color: white;
        padding: 12px;
        text-align: left;
        width: 40%;
    }

    .tabla-consulta td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .tabla-consulta tr:nth-child(even) {
        background: #f9f9f9;
    }

    .botones-accion {
        margin: 20px 0;
        text-align: center;
    }

    .btn-volver {
        display: inline-block;
        padding: 10px 20px;
        background: #6c757d;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }

    .btn-volver:hover {
        background: #5a6268;
    }
</style>