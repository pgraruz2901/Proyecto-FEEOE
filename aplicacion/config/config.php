<?php

$config = array(
	"CONTROLADOR" => array("inicial"),
	"RUTAS_INCLUDE" => array("aplicacion/modelos", "aplicacion/clases"),
	"URL_AMIGABLES" => true,
	"VARIABLES" => array(
		"autor" => "Pablo Gabriel Granados Ruz",
		"direccion" => "C/ Carrera - Madre Carmen, 12",
		"grupo" => "2daw"
	),
	"BD" => array(
		"hay" => true,
		"servidor" => "localhost",
		"usuario" => "root",
		"contra" => "",
		"basedatos" => "proyecto"
	),
	"sesion" => array("controlAutomatico" => true),
	"ACL" => array("controlAutomatico" => true)
);
