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
            "nif",
            "fecha_nacimiento",
            "provincia",
            "estado",
            "contrasenia",
            "confirmar_contrasenia"
        );
    }

    protected function fijarDescripciones(): array
    {
        return array(
            "nick" => "Nick",
            "nif" => "Nif",
            "fecha_nacimiento" => "Fecha De Nacimiento",
            "provincia" => "Provincia",
            "estado" => "Estado",
            "contrasenia" => "Contraseña",
            "confirmar_contrasenia" => "Confirmar Contraseña"
        );
    }

    protected function fijarRestricciones(): array
    {
        return
            array(
                array(
                    "ATRI" => "nick,nif",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "nick",
                    "TIPO" => "CADENA",
                    "TAMANIO" => 40
                ),
                array(
                    "ATRI" => "nif",
                    "TIPO" => "CADENA",
                    "TAMANIO" => 10
                ),
                array(
                    "ATRI" => "fecha_nacimiento",
                    "TIPO" => "FECHA"
                ),
                array(
                    "ATRI" => "fecha_nacimiento",
                    "TIPO" => "FUNCION",
                    "FUNCION" => "validaFechaNacimiento"
                ),
                array(
                    "ATRI" => "provincia",
                    "TIPO" => "CADENA",
                    "TAMANIO" => 30,
                    "DEFECTO" => "MALAGA"
                ),
                array(
                    "ATRI" => "estado",
                    "TIPO" => "RANGO",
                    "RANGO" => [0, 1, 2, 3, 4],
                    "DEFECTO" => 0
                ),
                array(
                    "ATRI" => "contrasenia,confirmar_contrasenia",
                    "TIPO" => "CADENA"
                ),
                array(
                    "ATRI" => "contrasenia,confirmar_contrasenia",
                    "TIPO" => "FUNCION",
                    "FUNCION" => "validaContrasenia"
                )
            );
    }

    protected function afterCreate(): void
    {
        $this->nick = "";
        $this->nif = "";
        $this->fecha_nacimiento = date('d/m/Y', strtotime("-18 years"));
        $this->provincia = "";
        $this->estado = "";
        $this->contrasenia = "";
        $this->confirmar_contrasenia = "";
    }

    public function validaFechaAlta()
    {
        $fechaHoy = new DateTime();
        $fecha1900 = DateTime::createFromFormat('d/m/Y', '01/01/1900');
        $fecha = DateTime::createFromFormat('d/m/Y', $this->fecha_nacimiento);
        if ($fecha < $fecha1900 || $fecha > $fechaHoy) {
            $this->setError(
                "fecha_nacimiento",
                "La fecha de nacimiento debe ser posterior al 01/01/1900 o anterior a hoy "
            );
        }
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

    public static function dameEstados($cod_estado = null)
    {
        $estado = array(
            0 => "no se sabe",
            1 => "estudiando",
            2 => "trabajando",
            3 => "en paro",
            4 => "jubilado"
        );

        if ($cod_estado === null)
            return $estado;
        else {
            if (isset($estado[$cod_estado]))
                return $estado[$cod_estado];

            else
                return false;
        }
    }
}
