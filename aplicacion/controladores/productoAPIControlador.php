<?php

include RUTA_BASE . "/scripts/librerias/peticionesCURL.php";

class productoAPIControlador extends CControlador
{
    public array $menuizq = [];
    public array $menuhead = [];

    // URL base de la API de bebidas
    private string $_urlAPI = "";

    public function __construct()
    {
        // API de bebidas que usaremps (TheCocktailDB)
        $this->_urlAPI = "https://www.thecocktaildb.com/api/json/v1/1/search.php?s=";

        //Menus
        $this->menuizq = [
            [
                "texto" => "Inicio",
                "enlace" => ["productos"]
            ],
            [
                "texto" => "Bebidas API",
                "enlace" => ["productoAPI", "index"]
            ]
        ];

        $this->menuhead = [
            [
                "texto" => "Inicio",
                "enlace" => ["productos"]
            ],
            [
                "texto" => "Bebidas API",
                "enlace" => ["productoAPI", "index"]
            ]
        ];
    }

    public function accionIndex()
    {
        // Ejemplo bebida haciendo la peticion a la api
        $res = petCURLGet($this->_urlAPI . "margarita");

        // Si la respuesta es falsa, mostramos un error
        if (!$res) {
            Sistema::app()->paginaError(500, "Error accediendo a la API de bebidas");
            return;
        }

        //Convertimos la respuesta de la api de json a array
        $data = json_decode($res, true);

        // Si no hay bebidas en la respuesta, mostramos un error
        if (!isset($data["drinks"])) {
            Sistema::app()->paginaError(500, "No se encontraron bebidas");
            return;
        }

        // Obtenemos el array de bebidas de la respuesta
        $bebidas = $data["drinks"];

        // Dibujamos la vista index de productoAPI, pasándole el array de bebidas de la api
        $this->dibujaVista(
            "index",
            [
                "productos" => $bebidas
            ],
            "Catálogo de Bebidas"
        );
    }
}