<?php

echo CHTML::dibujaEtiqueta("h1", [], "NUEVO PRODUCTO");
echo "<br>";

echo CHTML::iniciarForm("", "post");

echo "<div class='tabla-consulta'>";

// Nombre
echo "<div>";
echo "Nombre:<br>";
echo CHTML::campoText("nombre", "", ["maxlength" => 100]);
echo "</div><br>";

// Categoría
echo "<div>";
echo "Categoría:<br>";
echo CHTML::campoText("cod_categoria", 1);
echo "</div><br>";

// Fabricante
echo "<div>";
echo "Fabricante:<br>";
echo CHTML::campoText("fabricante", "");
echo "</div><br>";

// Unidades
echo "<div>";
echo "Unidades:<br>";
echo CHTML::campoText("unidades", 0);
echo "</div><br>";

// Precio
echo "<div>";
echo "Precio base:<br>";
echo CHTML::campoText("precio_base", 0);
echo "</div><br>";

// IVA
echo "<div>";
echo "IVA:<br>";
echo CHTML::campoText("iva", 21);
echo "</div><br>";

// Foto
echo "<div>";
echo "Foto:<br>";
echo CHTML::campoText("foto", "default.jpg");
echo "</div><br>";

echo "</div>";

echo "<div class='botones-accion'>";
echo CHTML::campoBotonSubmit("crear", ["name" => "crear", "class" => "btn-nuevo"]);
echo CHTML::link("Volver", ["clienteAPI"], ["class" => "btn-volver"]);
echo "</div>";

echo CHTML::finalizarForm();