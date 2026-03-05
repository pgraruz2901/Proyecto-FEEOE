<?php

class Categorias extends CActiveRecord
{
    protected function fijarNombre(): string
    {
        return 'Categorias';
    }
    protected function fijarTabla(): string
    {
        return 'Categorias';
    }
    protected function fijarAtributos(): array
    {
        return array(
            "cod_categoria",
            "descripcion"
        );
    }

    protected function fijarDescripciones(): array
    {
        return array(
            "cod_categoria" => "Codigo de categoria",
            "descripcion" => "Descripcion"
        );
    }

    protected function fijarRestricciones(): array
    {
        return
            array(
                array(
                    "ATRI" => "cod_categoria,descripcion",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_categoria,descripcion",
                    "TIPO" => "CADENA",
                    "TAMANIO" => 40
                )
            );
    }

    public static function dameCategorias($codigo = null)
{
    $cat = new Categorias();
    $filas = $cat->buscarTodos([
        "select" => "cod_categoria, descripcion",
        "order" => "cod_categoria"
    ]);

    $categorias = [];

    foreach ($filas as $fila) {
        $categorias[$fila["cod_categoria"]] = $fila["descripcion"];
    }

    if ($codigo === null)
        return $categorias;

    return $categorias[$codigo] ?? false;
}

}
