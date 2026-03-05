<?php

class registroControlador extends CControlador
{
    public array $menuizq = [];
    public array $menuhead = [];
    public function __construct() {}

    public function accionIndex()
    {
        $this->menuhead = [
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
        $this->dibujaVista(
            "index",
            [],
            "Index"
        );
    }
    public function accionPedirDatosRegistro()
    {
        $this->menuhead = [
            [
                "texto" => "Inicio",
                "enlace" => ["inicial"]
            ],
            [
                "texto" => "Registro",
                "enlace" => ["registro/PedirDatosRegistro"]
            ]
        ];
        $this->menuizq = [
            [
                "texto" => "Inicio",
                "enlace" => ["inicial"]
            ],
            [
                "texto" => "Registro",
                "enlace" => ["registro/PedirDatosRegistro"]
            ]
        ];
        $modelo = new DatosRegistro();

        $nombre = $modelo->getNombre();

        if (isset($_POST[$nombre])) {

            $modelo->setValores($_POST[$nombre]);

            if ($modelo->validar()) {

                $this->dibujaVista("datosUsuario", ["modelo" => $modelo], "Datos del usuario");
                exit;
            } else {
                $this->dibujaVista(
                    "registros",
                    array("modelo" => $modelo),
                    "Crear nuevo usuario"
                );
                exit;
            }
        }
        $this->dibujaVista(
            "registros",
            ["modelo" => $modelo],
            "Registrar Usuario"
        );
    }
    public function accionLogin()
    {
        $this->menuhead = [
            [
                "texto" => "Inicio",
                "enlace" => ["inicial"]
            ],
            [
                "texto" => "Login",
                "enlace" => ["registro/login"]
            ]
        ];
        $this->menuizq = [
            [
                "texto" => "Inicio",
                "enlace" => ["inicial"]
            ],
            [
                "texto" => "login",
                "enlace" => ["registro/login"]
            ]
        ];
        $login = new Login();

        $nombre = $login->getNombre();

        if (isset($_POST[$nombre])) {

            $login->setValores($_POST[$nombre]);

            if ($login->validar()) {
                $login->autenticar();
                Sistema::app()->irAPagina(["inicial", "index"]);
            }
        }
        $this->dibujaVista(
            "login",
            ["login" => $login],
            "logear Usuario"
        );
    }
    public function accionLogout()
    {
        Sistema::app()->Acceso()->quitarRegistroUsuario();
        Sistema::app()->irAPagina(["inicial", "index"]);
    }
}
