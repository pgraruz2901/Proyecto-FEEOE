<?php
    
echo "<div class='panel-borrar'>";
// Mostrar datos del cliente a borrar
echo CHTML::dibujaEtiqueta("H1", [], "BORRADO DE CLIENTE");
echo "<br>";

echo CHTML::iniciarForm();

echo "<div class='dato'><strong>ID:</strong> " . $prod["cod_cliente"] . "</div>";
echo "<div class='dato'><strong>Nombre:</strong> " . $prod["nombre"] . "</div>";

//Seguro que quieres borrar este cliente?
echo "<div class='mensaje'>¿Seguro que quieres borrar este cliente?</div>";

// Botón de confirmación de borrado
echo CHTML::campoBotonSubmit("borrar", [
    "name" => "borrar"
]);

echo CHTML::finalizarForm();

// Enlace para volver a la lista de clientes
echo CHTML::link("Volver", ["clienteAPI"]);

echo "</div>";

?>

<style>
    .panel-borrar {
        max-width: 500px;
        margin: 40px auto;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #ddd;
        background: white;
        font-family: Arial, sans-serif;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .panel-borrar h1 {
        text-align: center;
        color: #f97316;
        margin-bottom: 20px;
    }

    .panel-borrar .dato {
        margin: 8px 0;
        font-size: 15px;
        padding-left: 88px;
    }

    .panel-borrar .dato strong {
        display: inline-block;
        width: 90px;
        color: #333;
    }

    .panel-borrar .mensaje {
        margin: 20px 0;
        text-align: center;
        font-weight: bold;
        color: #444;
    }

    .panel-borrar input[type=submit] {
        background: #f97316;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        width: 100%;
    }

    .panel-borrar input[type=submit]:hover {
        background: #fb923c;
    }
    

    .panel-borrar a {
        display: block;
        text-align: center;
        margin-top: 15px;
        color: #007bff;
        text-decoration: none;
    }

    .panel-borrar a:hover {
        text-decoration: underline;
    }
</style>
