<?php
class DatosRegistro extends CActiveRecord
{
    protected function fijarNombre(): string
    {
        return 'DatosRegistro';
    }
    protected function fijarTabla(): string
    {
        return 'acl_usuarios';
    }
    protected function fijarId(): string
    {
        return 'cod_acl_usuario';
    }
    protected function fijarAtributos(): array
    {
        return array(
            "nick",
            "nombre",
            "contrasenia",
            "confirmar_contrasenia",
            "cod_acl_role",
            "borrado"
        );
    }

    protected function fijarDescripciones(): array
    {
        return array(
            "nick" => "Nick",
            "nombre" => "Nombre",
            "contrasenia" => "Contraseña",
            "cod_acl_role" => "Rol",
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
                    "ATRI" => "cod_acl_role",
                    "TIPO" => "ENTERO"
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
        $this->cod_acl_role = 8;
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
    protected function fijarSentenciaInsert(): string
    {
        $nick = CGeneral::addSlashes($this->nick);
        $nombre = CGeneral::addSlashes($this->nombre);
        $contrasenia = CGeneral::addSlashes($this->contrasenia);
        $cod_acl_role = intval($this->cod_acl_role);
        $borrado = intval($this->borrado);
        return "INSERT INTO acl_usuarios (nick, nombre, contrasenia, cod_acl_role, borrado)
                VALUES ('$nick', '$nombre', '$contrasenia', $cod_acl_role, $borrado)";
    }
}
