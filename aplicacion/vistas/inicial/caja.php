<?php
$caja = new CCaja("Caja 1", "hola", ["style" => "margin-bottom: 20px;"]);
// echo $caja->dibujate();

echo $caja->dibujaApertura();
echo CHTML::campoLabel("nombre", "nombre", ["style" => "padding-left: 10px; padding-right: 10px;"]);
echo CHTML::campoText("nombre", Sistema::app()->Acceso()->getNombre());
echo $caja::requisitos();
echo $caja->dibujaFin();
