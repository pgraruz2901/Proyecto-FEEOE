<div class="form-container">

<h2>Nuevo Producto</h2>

<!-- Formulario de creación de nuevo producto -->
<?php
echo CHTML::iniciarForm("", "post", ["enctype" => "multipart/form-data"]);
?>

<div class="form-grid">

<div class="form-group">
<?php
echo CHTML::modeloLabel($producto, "cod_categoria");
echo CHTML::modeloListaDropDown($producto, "cod_categoria", $categorias);
echo CHTML::modeloError($producto, "cod_categoria");
?>
</div>

<div class="form-group">
<?php
echo CHTML::modeloLabel($producto, "nombre");
echo CHTML::modeloText($producto, "nombre", ["maxlength" => 30]);
echo CHTML::modeloError($producto, "nombre");
?>
</div>

<div class="form-group">
<?php
echo CHTML::modeloLabel($producto, "categoria");
echo CHTML::modeloText($producto, "categoria", ["maxlength" => 40, "readonly" => true]);
echo "<small>Campo de solo lectura, se llena automáticamente</small>";
echo CHTML::modeloError($producto, "categoria");
?>
</div>

<div class="form-group">
<?php
echo CHTML::modeloLabel($producto, "fabricante");
echo CHTML::modeloText($producto, "fabricante", ["maxlength" => 30]);
echo CHTML::modeloError($producto, "fabricante");
?>
</div>

<div class="form-group">
<?php
echo CHTML::modeloLabel($producto, "fecha_alta");
echo CHTML::modeloDate($producto, "fecha_alta");
echo CHTML::modeloError($producto, "fecha_alta");
?>
</div>

<div class="form-group">
<?php
echo CHTML::modeloLabel($producto, "unidades");
echo CHTML::modeloNumber($producto, "unidades");
echo CHTML::modeloError($producto, "unidades");
?>
</div>

<div class="form-group">
<?php
echo CHTML::modeloLabel($producto, "precio_base");
echo CHTML::modeloNumber($producto, "precio_base", ["step" => "0.01", "min" => 0]);
echo CHTML::modeloError($producto, "precio_base");
?>
</div>

<div class="form-group">
<?php
$opcionesIVA = array(4 => "4%", 10 => "10%", 21 => "21%");
echo CHTML::modeloLabel($producto, "iva");
echo CHTML::modeloListaDropDown($producto, "iva", $opcionesIVA);
echo CHTML::modeloError($producto, "iva");
?>
</div>

<div class="form-group">
<?php
echo CHTML::modeloLabel($producto, "foto");
echo "<input type='file' name='foto' accept='image/*'>";
echo "<small>Sube una imagen para el producto (jpg, png, gif)</small>";
echo CHTML::modeloError($producto, "foto");
?>
</div>

<div class="form-group">
<?php
$opcionesBorrado = array(0 => "No", 1 => "Sí");
echo CHTML::modeloLabel($producto, "borrado");
echo CHTML::modeloListaDropDown($producto, "borrado", $opcionesBorrado);
echo CHTML::modeloError($producto, "borrado");
?>
</div>

</div>

<br>

<?php
echo "<button class='btn-submit'>Guardar</button>";
echo CHTML::finalizarForm();
?>

<div class="botones-accion">
    <?php echo CHTML::link("Cancelar", Sistema::app()->generaURL(["inicial", "index"])); ?>
</div>

</div>

<!-- Estilos de la pagina ya que no se porque no me van si los pongo en el archivo principal -->
<style>
    .form-container {
    max-width: 900px;
    margin: 3rem auto;
    background: white;
    padding: 2.5rem;
    border-radius: 1rem;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
}

/* Título */
.form-container h2 {
    text-align: center;
    margin-bottom: 2rem;
    font-weight: 600;
    color: #111827;
}

/* Grupo */
.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 1.5rem;
}

/* Labels */
.form-group label {
    font-size: 0.85rem;
    font-weight: 500;
    margin-bottom: 0.4rem;
    color: #374151;
}

/* Inputs */
.form-group input,
.form-group select {
    padding: 0.7rem 0.9rem;
    border: 1px solid #d1d5db;
    border-radius: 0.4rem;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

/* Focus naranja */
.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: #f97316;
    box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
}

/* Inputs readonly */
.form-group input[readonly] {
    background: #f3f4f6;
    color: #6b7280;
}

/* Small info */
.form-group small {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.3rem;
}

/* Errores */
.form-group .error {
    color: #dc2626;
    font-size: 0.75rem;
    margin-top: 0.2rem;
}

/* Grid para organizar */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

/* Botón */
.btn-submit {
    width: 100%;
    padding: 0.9rem;
    background: #f97316;
    color: white;
    border: none;
    border-radius: 0.5rem;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-submit:hover {
    background: #fb923c;
    transform: translateY(-1px);
}

/* Botón cancelar */
.botones-accion a {
    display: inline-block;
    margin-top: 1rem;
    padding: 0.6rem 1.5rem;
    background: #f3f4f6;
    color: #374151;
    border-radius: 0.4rem;
    text-decoration: none;
    transition: all 0.2s ease;
}

.botones-accion a:hover {
    background: #e5e7eb;
}
</style>