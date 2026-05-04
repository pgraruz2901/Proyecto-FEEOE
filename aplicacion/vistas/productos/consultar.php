<h2>Consultar Producto</h2>
<!-- Tabla de consulta de producto -->
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
        <td><?php echo CHTML::modeloLabel($producto, "cod_cliente"); ?></td>
        <td><?php echo htmlspecialchars($producto->cod_cliente); ?></td>
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
<!-- Boton para volver a la lista de productos -->
<div class="botones-accion">
    <?php
    echo CHTML::link(
        "Volver al listado",
        Sistema::app()->generaURL(["productos", "index"]),
        ["class" => "btn-volver"]
    );
    ?>
</div>

<!-- Estilos de la pagina ya que solo los necesito en esta pagina -->
<style>
    .tabla-consulta {
    width: 100%;
    max-width: 750px; 
    margin: 3rem auto;
    border-collapse: collapse;
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
}

.tabla-consulta th {
    background: #f97316;
    color: white;
    padding: 18px; 
    text-align: left;
    font-weight: 600;
    font-size: 1rem;
}

.tabla-consulta td {
    padding: 16px 18px; 
    border-bottom: 1px solid #f3f4f6;
    color: #374151;
    font-size: 0.95rem;
}

.tabla-consulta td:first-child {
    font-weight: 600;
    color: #111827;
    width: 35%;
}

.tabla-consulta tr:nth-child(even) {
    background: #fff7ed;
}

.tabla-consulta tr:hover {
    background: #ffedd5;
}

.botones-accion {
    margin: 2.5rem 0;
    text-align: center;
}

.btn-volver {
    display: inline-block;
    padding: 0.75rem 2rem; 
    background: #f97316;
    color: white;
    text-decoration: none;
    border-radius: 0.5rem;
    font-size: 0.95rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-volver:hover {
    background: #fb923c;
    transform: translateY(-2px);
}
</style>