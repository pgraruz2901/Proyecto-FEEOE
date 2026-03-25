<?php
class DatosRegistro extends CActiveRecord
{
    protected function fijarNombre(): string
    {
        return 'DatosRegistro';
    }

    protected function fijarAtributos(): array
    {
        return array(
            "nick",
            "nombre",
            "contrasenia",
            "confirmar_contrasenia",
            "borrado"
        );
    }

    protected function fijarDescripciones(): array
    {
        return array(
            "nick" => "Nick",
            "nombre" => "Nombre",
            "contrasenia" => "Contraseña",
            "confirmar_contrasenia" => "Confirmar Contraseña"
        );
    }

    protected function fijarRestricciones(): array
    {
        return
            array(
                array(
                    "ATRI" => "nick,nombre,contrasenia,confirmar_contrasenia",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "nick",
                    "TIPO" => "CADENA",
                    "TAMANIO" => 40
                ),
                array(
                    "ATRI" => "nombre",
                    "TIPO" => "CADENA",
                    "TAMANIO" => 40
                ),
                array(
                    "ATRI" => "contrasenia,confirmar_contrasenia",
                    "TIPO" => "CADENA"
                ),
                array(
                    "ATRI" => "contrasenia,confirmar_contrasenia",
                    "TIPO" => "FUNCION",
                    "FUNCION" => "validaContrasenia"
                ),
            array(
                "ATRI" => "borrado",
                "TIPO" => "ENTERO",
                "DEFECTO" => 0
            )
            );
    }

    protected function afterCreate(): void
    {
        $this->nick = "";
        $this->nombre = "";
        $this->contrasenia = "";
        $this->confirmar_contrasenia = "";
        $this->borrado = 0;
    }

    public function validaContrasenia()
    {
        $contrasenia = $this->contrasenia;
        $confContrasenia = $this->confirmar_contrasenia;
        if ($contrasenia !== $confContrasenia) {
            $this->setError(
                "contrasenia",
                "Las contraseñas no coinciden"
            );
            $this->setError(
                "confirmar_contrasenia",
                "Las contraseñas no coinciden"
            );
        }
        if ($contrasenia == "") {
            $this->setError(
                "contrasenia",
                "Tienes que introducir una contraseña"
            );
        }
        if ($confContrasenia == "") {
            $this->setError(
                "confirmar_contrasenia",
                "Tienes que introducir una confirmarion de contraseña"
            );
        }
    }
}
