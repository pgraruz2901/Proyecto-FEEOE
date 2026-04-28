<?php

echo CHTML::dibujaEtiqueta("h1", [], "MODIFICAR PRODUCTO");
echo "<br>";

echo CHTML::iniciarForm("", "post");

echo "<div class='tabla-consulta'>";

// ID (solo lectura)
echo "<div>";
echo "ID:<br>";
echo CHTML::campoHidden("id", $prod["cod_producto"]);
echo "<b>".$prod["cod_producto"]."</b>";
echo "</div><br>";

// Nombre
echo "<div>";
echo "Nombre:<br>";
echo CHTML::campoText("nombre", $prod["nombre"]);
echo "</div><br>";

// Precio
echo "<div>";
echo "Precio base:<br>";
echo CHTML::campoText("precio_base", $prod["precio_venta"]);
echo "</div><br>";


echo "Fecha alta:<br>";
echo CHTML::campoText("fecha_alta", $prod["fecha_alta"]);

echo "</div>";


echo "<div class='botones-accion'>";
echo CHTML::campoBotonSubmit("guardar", ["name" => "guardar", "class" => "btn-nuevo"]);
echo CHTML::link("Volver", ["clienteAPI"], ["class" => "btn-volver"]);
echo "</div>";

echo CHTML::finalizarForm();
?>

<style>
    /* ===== FORMULARIO MODIFICAR PRODUCTO ===== */

.tabla-consulta {
    max-width: 500px;
    margin: 30px auto;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    padding-right:50px;
}

/* Título */
h1 {
    text-align: center;
    color: #ea580c;
    font-size: 1.8rem;
    margin-bottom: 10px;
}

/* Cada bloque del formulario */
.tabla-consulta div {
    margin-bottom: 15px;
}

/* Labels */
.tabla-consulta b {
    font-size: 1rem;
    color: #111827;
}

/* Inputs */
.tabla-consulta input[type="text"],
.tabla-consulta input[type="number"] {
    width: 100%;
    padding: 10px 12px;
    margin-top: 5px;
    border: 1px solid #fdba74;
    border-radius: 6px;
    font-size: 0.95rem;
    transition: all 0.2s ease;
}

.tabla-consulta input:focus {
    outline: none;
    border-color: #f97316;
    box-shadow: 0 0 0 3px rgba(249,115,22,0.2);
}

/* ID destacado */
.tabla-consulta b {
    display: inline-block;
    padding: 5px 10px;
    background: #fff7ed;
    border: 1px solid #fed7aa;
    border-radius: 6px;
    margin-top: 5px;
}

/* Botonera */
.botones-accion {
    text-align: center;
    margin-top: 20px;
}

/* Botón guardar (usa tu estilo base pero reforzado) */
.btn-nuevo {
    padding: 0.75rem 1.5rem;
    background: #f97316;
    color: white;
    border: none;
    border-radius: 0.375rem;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-right: 10px;
}

.btn-nuevo:hover {
    background: #fb923c;
    transform: translateY(-1px);
}

/* Botón volver */
.btn-volver {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    background: #6b7280;
    color: white;
    text-decoration: none;
    border-radius: 0.375rem;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.btn-volver:hover {
    background: #4b5563;
}
</style>