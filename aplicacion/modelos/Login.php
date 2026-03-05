<?php

class Login extends CActiveRecord
{
    protected function fijarNombre(): string
    {
        return 'Login';
    }

    protected function fijarAtributos(): array
    {
        return array(
            "nick",
            "contrasenia",
            "nombre",
            "permisos"
        );
    }

    protected function fijarDescripciones(): array
    {
        return array(
            "nick" => "Nick de usuario",
            "contrasenia" => "Contraseña",
            "nombre" => "Este es el nombre",
            "permisos" => "Estos son los permisos"
        );
    }

    protected function fijarRestricciones(): array
    {
        return
            array(
                array(
                    "ATRI" => "nick,contrasenia",
                    "TIPO" => "REQUERIDO"
                ),
                array(
                    "ATRI" => "nick,contrasenia",
                    "TIPO" => "CADENA",
                    "TAMANIO" => 20
                ),
                array(
                    "ATRI" => "contrasenia",
                    "TIPO" => "FUNCION",
                    "FUNCION" => "validaContrasenia"
                )
            );
    }

    public function validaContrasenia()
    {
        $pass1 = $this->contrasenia;
        $nick = $this->nick;

        if (!Sistema::app()->Acl()->esValido($nick, $pass1)) {
            $this->setError(
                "contrasenia",
                "El nick o contraseña incorrectas"
            );
            return;
        }
        $codUsu = Sistema::app()->Acl()->getCodUsuario($nick);
        $this->nombre = Sistema::app()->Acl()->getNombre($codUsu);
        $this->permisos = Sistema::app()->Acl()->getPermisos($codUsu);
    }
    public function autenticar()
    {
        $Acceso = Sistema::app()->Acceso();
        $Acceso->registrarUsuario($this->nick, $this->nombre, $this->permisos);
    }
}
