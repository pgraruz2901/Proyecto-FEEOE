<?php

class inicialControlador extends CControlador
{
	public array $menuizq = [];
	public function __construct() {}
	public function accionIndex()
	{


		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			]
		];
		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			]
		];

		$direcciones = Sistema::app()->generaURL(["usuarios", "borrar"], ["id" => 12, "nombre" => "pepe"]);

		$cadena = "mi nombre";
		$entero = 12;

		$contenido = $this->dibujaVistaParcial(
			"index",
			["c" => $cadena, "n" => $entero],
			true
		);
		// echo $contenido;
		$this->dibujaVista("index", [], "contenido Pagina");
	}

	public function accionNuevo()
	{
		echo "Nueva pagina del sitio";
	}
	public function accionCaja()
	{
		$this->dibujaVista(
			"caja",
			[],
			"Caja"
		);
	}
}
