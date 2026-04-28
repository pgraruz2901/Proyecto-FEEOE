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
echo CHTML::campoText("precio_base", $prod["precio_base"]);
echo "</div><br>";

// Unidades
echo "<div>";
echo "Unidades:<br>";
echo CHTML::campoText("unidades", $prod["unidades"]);
echo "</div><br>";

echo "</div>";

echo "<div class='botones-accion'>";
echo CHTML::campoBotonSubmit("guardar", ["name" => "guardar", "class" => "btn-nuevo"]);
echo CHTML::link("Volver", ["clienteAPI"], ["class" => "btn-volver"]);
echo "</div>";

echo CHTML::finalizarForm();