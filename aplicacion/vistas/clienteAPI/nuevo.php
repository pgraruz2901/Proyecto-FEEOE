<?php

//Formulario de nuevo cliente
echo CHTML::dibujaEtiqueta("h1", [], "NUEVO CLIENTE");
echo "<br>";

echo CHTML::iniciarForm("", "post");

echo "<div class='tabla-consulta'>";

//nombre
echo "<div>";
echo "Nombre:<br>";
echo CHTML::campoText("nombre", "");
echo "</div><br>";

//apellidos
echo "<div>";
echo "Apellidos:<br>";
echo CHTML::campoText("apellidos", "");
echo "</div><br>";
//email
echo "<div>";
echo "Email:<br>";
echo CHTML::campoText("email", "");
echo "</div><br>";

//telefono  
echo "<div>";
echo "Teléfono:<br>";
echo CHTML::campoText("telefono", "");
echo "</div><br>";

//fecha alta
echo "<div>";
echo "Fecha alta:<br>";
echo CHTML::campoText("fecha_alta", date("Y-m-d"));
echo "</div><br>";

//saldo
echo "<div>";
echo "Saldo:<br>";
echo CHTML::campoText("saldo", "0");
echo "</div><br>";

//activo
echo "<div>";
echo "Activo (1/0):<br>";
echo CHTML::campoText("activo", "1");
echo "</div><br>";

echo "</div>";

//boton para guardar cambios y volver a la lista de clientes
echo "<div class='botones-accion'>";

echo CHTML::campoBotonSubmit("crear", [
    "name" => "crear",
    "class" => "btn-nuevo"
]);

echo CHTML::link(
    "Volver",
    ["clienteAPI"],
    ["class" => "btn-volver"]
);

echo "</div>";

echo CHTML::finalizarForm();

?>
<!-- Estilos específicos para el formulario de nuevo cliente -->
<style>
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

    h1 {
        text-align: center;
        color: #ea580c;
        font-size: 1.8rem;
        margin-bottom: 10px;
    }

    .tabla-consulta div {
        margin-bottom: 15px;
    }

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

    .botones-accion {
        text-align: center;
        margin-top: 20px;
    }

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