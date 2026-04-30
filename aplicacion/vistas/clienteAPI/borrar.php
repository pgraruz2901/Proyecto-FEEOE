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
   .panel-borrar{
        max-width:480px;
        margin:70px auto;
        padding:28px;
        border-radius:14px;
        background:#ffffff;
        font-family:Arial, sans-serif;
        box-shadow:0 8px 20px rgba(0,0,0,0.06);
        border:1px solid #eee;
    }

    .panel-borrar h1{
        text-align:center;
        font-size:22px;
        color:#f97316;
        margin-bottom:8px;
        font-weight:600;
    }

    .mensaje{
        text-align:center;
        margin:18px 0;
        color:#555;
        font-size:14px;
    }

    .dato{
        display:flex;
        justify-content:space-between;
        padding:10px 12px;
        font-size:14px;
        border-bottom:1px solid #f1f1f1;
        color:#333;
    }

    .dato strong{
        color:#111;
        font-weight:600;
    }

    input[type=submit]{
        width:100%;
        padding:11px;
        border:none;
        border-radius:10px;
        background:#f97316;
        color:#fff;
        font-weight:500;
        cursor:pointer;
        transition:0.2s;
        margin-top:12px;
    }

    input[type=submit]:hover{
        background:#fb923c;
        transform:scale(1.02);
    }

    .panel-borrar a{
        display:block;
        text-align:center;
        margin-top:14px;
        font-size:13px;
        color:#f97316;
        text-decoration:none;
    }

    .panel-borrar a:hover{
        color:#fb923c;
        text-decoration:underline;
    }
</style>
