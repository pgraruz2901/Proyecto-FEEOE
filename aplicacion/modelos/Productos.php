<?php
class Productos extends CActiveRecord
{
    protected function fijarNombre(): string
    {
        return 'Productos';
    }
    protected function fijarTabla(): string
    {
        return 'cons_Productos';
    }
    protected function fijarId(): string
    {
        return 'cod_producto';
    }

    protected function fijarAtributos(): array
    {
        return array(
            "cod_producto",
            "nombre",
            "cod_categoria",
            "fabricante",
            "fecha_alta",
            "unidades",
            "precio_base",
            "iva",
            "precio_iva",
            "precio_venta",
            "foto",
            "borrado",
            "categoria"
        );
    }

    protected function fijarDescripciones(): array
    {
        return array(
            "cod_producto" => "Codigo producto",
            "nombre" => "Nombre",
            "cod_categoria" => "Codigo Categoria",
            "fabricante" => "Fabricante",
            "fecha_alta" => "Fecha Alta",
            "unidades" => "Unidades",
            "precio_base" => "Precio Base",
            "iva" => "Iva",
            "precio_iva" => "Precio Iva",
            "precio_venta" => "Precio Venta",
            "foto" => "Foto",
            "borrado" => "Borrado",
            "categoria" => "Descripcion Categoria"
        );
    }

    protected function fijarRestricciones(): array
    {
        return
            array(
                array(
                    "ATRI" => "nombre,cod_categoria",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "cod_producto",
                    "TIPO" => "ENTERO"
                ),
                array(
                    "ATRI" => "nombre",
                    "TIPO" => "CADENA",
                    "TAMANIO" => 30
                ),
                array(
                    "ATRI" => "cod_categoria",
                    "TIPO" => "ENTERO"
                ),
                array(
                    "ATRI" => "cod_categoria",
                    "TIPO" => "FUNCION",
                    "FUNCION" => "validaCodCategoria"
                ),
                array(
                    "ATRI" => "fabricante",
                    "TIPO" => "CADENA",
                    "TAMANIO" => 30,
                    "DEFECTO" => ""
                ),
                array(
                    "ATRI" => "fecha_alta",
                    "TIPO" => "FECHA"
                ),
                array(
                    "ATRI" => "unidades",
                    "TIPO" => "ENTERO",
                    "DEFECTO" => 0
                ),
                array(
                    "ATRI" => "precio_base",
                    "TIPO" => "REAL",
                    "MIN" => 0,
                    "DEFECTO" => 0
                ),
                array(
                    "ATRI" => "iva",
                    "TIPO" => "RANGO",
                    "RANGO" => [4, 10, 21],
                    "DEFECTO" => 21
                ),
                array(
                    "ATRI" => "precio_iva",
                    "TIPO" => "REAL"
                ),
                array(
                    "ATRI" => "precio_venta",
                    "TIPO" => "REAL",
                ),
                array(
                    "ATRI" => "foto",
                    "TIPO" => "CADENA",
                    "TAMANIO" => 40,
                    "DEFECTO" => "base.png"
                ),
                array(
                    "ATRI" => "borrado",
                    "TIPO" => "RANGO",
                    "RANGO" => [0, 1]
                )
            );
    }

    protected function afterCreate(): void
{
    $this->fecha_alta = date("Y-m-d");

    $precio_base = floatval($this->precio_base);
    $iva = floatval($this->iva ?: 0); 

    $this->precio_iva = ($precio_base * $iva) / 100;
    $this->precio_venta = $precio_base + $this->precio_iva;
}

    public function validaCodCategoria()
{
    $codigo = intval($this->cod_categoria);

    if ($codigo <= 0) {
        $this->setError("cod_categoria", "Categoría no válida");
        return;
    }

    $cat = new Categorias();
    $num = $cat->buscarTodosNRegistros([
        "where" => "t.cod_categoria = $codigo"
    ]);

    if ($num == 0) {
        $this->setError("cod_categoria", "La categoría no existe");
    }
}
protected function fijarSentenciaInsert(): string
    {

        $cod_categoria = intval($this->cod_categoria);
        $nombre = CGeneral::addSlashes($this->nombre);
        $categoria = CGeneral::addSlashes($this->categoria);
        $fabricante = CGeneral::addSlashes($this->fabricante);
        $fecha_alta = CGeneral::fechaNormalAMysql($this->fecha_alta);
        $unidades = intval($this->unidades);
        $precio_base = floatval($this->precio_base);
        $iva = intval($this->iva);
        $precio_iva = floatval($this->precio_iva);
        $precio_venta = floatval($this->precio_venta);
        $foto = CGeneral::addSlashes($this->foto);
        $borrado = intval($this->borrado);

        return "INSERT INTO productos (" .
            "cod_categoria, nombre, fabricante, " .
            "fecha_alta, unidades, precio_base, iva, precio_iva, precio_venta, foto, borrado" .
            ") VALUES (" .
            "$cod_categoria, '$nombre', '$fabricante', " .
            "'$fecha_alta', $unidades, $precio_base, $iva, $precio_iva, $precio_venta, '$foto', $borrado" .
            ")";
    }

    protected function fijarSentenciaUpdate(): string
    {
        $cod_categoria = intval($this->cod_categoria);
        $nombre = CGeneral::addSlashes($this->nombre);
        $fabricante = CGeneral::addSlashes($this->fabricante);
        $fecha_alta = CGeneral::fechaNormalAMysql($this->fecha_alta);
        $unidades = intval($this->unidades);
        $precio_base = floatval($this->precio_base);
        $iva = intval($this->iva);
        $precio_iva = floatval($this->precio_iva);
        $precio_venta = floatval($this->precio_venta);
        $foto = CGeneral::addSlashes($this->foto);
        $borrado = intval($this->borrado);
        $cod_producto = intval($this->cod_producto);

        return "UPDATE productos SET " .
            "cod_categoria = $cod_categoria, " .
            "nombre = '$nombre', " .
            "fabricante = '$fabricante', " .
            "fecha_alta = '$fecha_alta', " .
            "unidades = $unidades, " .
            "precio_base = $precio_base, " .
            "iva = $iva, " .
            "precio_iva = $precio_iva, " .
            "precio_venta = $precio_venta, " .
            "foto = '$foto', " .
            "borrado = $borrado " .
            "WHERE cod_producto = $cod_producto";
    }

}
