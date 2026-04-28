<?php
include RUTA_BASE."/scripts/librerias/peticionesCURL.php";	 

class clienteAPIControlador extends CControlador
{
	public array $menuizq=[];

	private string $_urlAPIproductos="";

	public function __construct()
	{
		$this->_urlAPIproductos=$_SERVER["HTTP_HOST"]."/API/productos";
		
		$this->menuizq = [
			[
				"texto" => "Inicio", 
				"enlace" => ["inicial"]
			],
			[
				"texto" => "API productos", 
				"enlace" => ["clienteAPI","index"]
			],
		];		
	}

	public function accionIndex()
	{
		$url=$this->_urlAPIproductos;
		$parametros="";

		$res = petCURLGet($url,$parametros);

		if(!$res) 
        {
			Sistema::app()->paginaError(400, "Error al acceder a los datos");
			return;
		}

		$res=json_decode($res,true);

		if (!isset($res["correcto"]) || !$res["correcto"])
		{
			Sistema::app()->paginaError(500, "Error al acceder a los datos");
			return;
		}

		$filas=$res["datos"];

		foreach ($filas as $clave=>$fila)
		{
			$filas[$clave]["borr"]=CHTML::link(
				CHTML::imagen("/imagenes/24x24/borrar.png"),
				Sistema::app()->generaURL(["clienteAPI","borrar"],["id"=>$fila["cod_producto"]])
			);
			$filas[$clave]["modificar"]=CHTML::link(
				CHTML::imagen("/imagenes/24x24/modificar.png"),
				Sistema::app()->generaURL(["clienteAPI","editar"],["id"=>$fila["cod_producto"]])
			);
				
		}

		$cabecera=array(
			array("ETIQUETA"=>"NOMBRE","CAMPO"=>"nombre"),
			array("ETIQUETA"=>"PRECIO","CAMPO"=>"precio_base"),
			array("ETIQUETA"=>"UNIDADES","CAMPO"=>"unidades"),
			array("CAMPO"=>"borr","ETIQUETA"=>""),
			array("CAMPO"=>"modificar","ETIQUETA"=>"")

		);

		$this->dibujaVista("index",
			["fil"=>$filas,"cab"=>$cabecera],
			"Cliente API productos"
		);
	}
	public function accionCrear()
	{
		$url = $this->_urlAPIproductos;

		if (isset($_POST["crear"]))
		{
			$datos = [
				"nombre" => $_POST["nombre"] ?? "",
				"cod_categoria" => $_POST["cod_categoria"] ?? 1,
				"fabricante" => $_POST["fabricante"] ?? "",
				"unidades" => $_POST["unidades"] ?? 0,
				"precio_base" => $_POST["precio_base"] ?? 0,
				"iva" => $_POST["iva"] ?? 21,
				"foto" => $_POST["foto"] ?? "default.jpg"
			];

			$res = petCURLPost($url, $datos);

			if(!$res)
			{
				Sistema::app()->paginaError(400, "Error al acceder a la API");
				return;
			}

			$res = json_decode($res, true);

			if(!isset($res["correcto"]) || !$res["correcto"])
			{
				Sistema::app()->paginaError(400, "No se ha podido crear el producto");
				return;
			}

			Sistema::app()->irAPagina(["clienteAPI"]);
			return;
		}

		$this->dibujaVista("crear", [], "Crear producto");
	}
	public function accionEditar()
	{
		$url = $this->_urlAPIproductos;

		if (!isset($_REQUEST["id"]))
		{
			Sistema::app()->paginaError(400, "Falta ID");
			return;
		}

		$id = intval($_REQUEST["id"]);

		// =========================
		// GET del producto
		// =========================
		$res = petCURLGet($url, "id=$id");

		if(!$res)
		{
			Sistema::app()->paginaError(400, "Error API");
			return;
		}

		$res = json_decode($res, true);

		if(!$res["correcto"])
		{
			Sistema::app()->paginaError(400, "Producto no encontrado");
			return;
		}

		$producto = $res["datos"];

		// =========================
		// SI ENVÍA FORMULARIO → PUT
		// =========================
		if (isset($_POST["guardar"]))
		{
			
			$datos = [
				"id" => $id,
				"nombre" => $_POST["nombre"] ?? "",
				"precio_base" => $_POST["precio_base"] ?? 0,
				"unidades" => $_POST["unidades"] ?? 0,
			    "fecha_alta" => date("d/m/Y", strtotime($_POST["fecha_alta"]))   
			];

			$res = petCURLPut($url, http_build_query($datos));
			
			if(!$res)
			{
				Sistema::app()->paginaError(400, "Error API");
				return;
			}
			var_dump($res);

			$res = json_decode($res, true);

			echo var_dump($res);
			if(!$res["correcto"])
			{
				Sistema::app()->paginaError(400, "No se ha podido modificar");
				return;
			}

			Sistema::app()->irAPagina(["clienteAPI"]);
			return;
		}

		$this->dibujaVista("modificar", ["prod" => $producto], "Editar producto");
	}

	public function accionBorrar()
	{
		$url=$this->_urlAPIproductos;
		$parametros="";

		if (!isset($_REQUEST["id"]))
		{
			Sistema::app()->paginaError(400, "No se ha indicado producto");
			return;
		}

		$id=intval($_REQUEST["id"]);
		$parametros="id=$id";

		$res = petCURLGet($url,$parametros);

		if(!$res) 
        {
			Sistema::app()->paginaError(400, "Error al acceder a los datos");
			return;
		}

		$res=json_decode($res,true);

		if (!isset($res["correcto"]))
		{
			Sistema::app()->paginaError(400, "Error al acceder a los datos");
			return;
		}

		if (!$res["correcto"])
		{
			Sistema::app()->paginaError(400, $res["datos"]);
			return;
		}

		$producto=$res["datos"];

		if (isset($_POST["borrar"]))
		{
			$res = petCURLDelete($url,$parametros);

			if(!$res) 
			{
				Sistema::app()->paginaError(400, "Error al acceder a los datos");
				return;
			}

			$res=json_decode($res,true);

			if (!isset($res["correcto"]))
			{
				Sistema::app()->paginaError(400, "Error al acceder a los datos");
				return;
			}

			if (!$res["correcto"])
			{
				Sistema::app()->paginaError(400, "No se ha podido borrar el producto");
				return;
			}

			Sistema::app()->irAPagina(["clienteAPI"]);
			return;
		}

		$this->dibujaVista("borrar",["prod"=>$producto],"Borrar producto");
	}	
}