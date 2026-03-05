<h2>Modificar Producto</h2>

<?php
echo CHTML::iniciarForm("", "post", ["enctype" => "multipart/form-data"]);

echo CHTML::modeloLabel($producto, "cod_categoria");
echo CHTML::modeloListaDropDown($producto, "cod_categoria", $categorias);
echo CHTML::modeloError($producto, "cod_categoria");
echo "<br>";

echo CHTML::modeloLabel($producto, "nombre");
echo CHTML::modeloText($producto, "nombre", ["maxlength" => 30]);
echo CHTML::modeloError($producto, "nombre");
echo "<br>";

echo CHTML::modeloLabel($producto, "categoria");
echo CHTML::modeloText($producto, "categoria", ["maxlength" => 40, "readonly" => true]);
echo "<small>Campo de solo lectura, se llena automáticamente</small>";
echo CHTML::modeloError($producto, "categoria");
echo "<br>";

echo CHTML::modeloLabel($producto, "fabricante");
echo CHTML::modeloText($producto, "fabricante", ["maxlength" => 30]);
echo CHTML::modeloError($producto, "fabricante");
echo "<br>";

echo CHTML::modeloLabel($producto, "fecha_alta");
echo CHTML::modeloDate($producto, "fecha_alta");
echo CHTML::modeloError($producto, "fecha_alta");
echo "<br>";

echo CHTML::modeloLabel($producto, "unidades");
echo CHTML::modeloNumber($producto, "unidades");
echo CHTML::modeloError($producto, "unidades");
echo "<br>";

echo CHTML::modeloLabel($producto, "precio_base");
echo CHTML::modeloNumber($producto, "precio_base", ["step" => "0.01", "min" => 0]);
echo CHTML::modeloError($producto, "precio_base");
echo "<br>";

$opcionesIVA = array(4 => "4%", 10 => "10%", 21 => "21%");
echo CHTML::modeloLabel($producto, "iva");
echo CHTML::modeloListaDropDown($producto, "iva", $opcionesIVA);
echo CHTML::modeloError($producto, "iva");
echo "<br>";

echo CHTML::modeloLabel($producto, "foto");
echo "<input type='file' name='foto' accept='image/*'>";
echo "<small>Sube una nueva imagen para el producto (jpg, png, gif). Deja vacío para mantener la actual.</small>";
echo CHTML::modeloError($producto, "foto");
echo "<br>";

$opcionesBorrado = array(0 => "No", 1 => "Sí");
echo CHTML::modeloLabel($producto, "borrado");
echo CHTML::modeloListaDropDown($producto, "borrado", $opcionesBorrado);
echo CHTML::modeloError($producto, "borrado");
echo "<br>";

echo CHTML::campoBotonSubmit("Guardar");
echo CHTML::finalizarForm();
?>

<div class="botones-accion">
    <?php echo CHTML::link("Cancelar", Sistema::app()->generaURL(["productos", "index"])); ?>
</div>