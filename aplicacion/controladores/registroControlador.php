<?php

class registroControlador extends CControlador
{
    public array $menuizq = [];
    public array $menuhead = [];
    public function __construct() {}

    //Accion Index
    public function accionIndex()
    {
        //Menus
        $this->menuhead = [
            [
                "texto" => "Inicio",
                "enlace" => ["productos"]
            ]
        ];
        $this->menuizq = [
            [
                "texto" => "Inicio",
                "enlace" => ["productos"]
            ]
        ];
        //Dibujamos la vista
        $this->dibujaVista(
            "index",
            [],
            "Index"
        );
    }
    //Accion PedirDatosRegistro
    public function accionPedirDatosRegistro()
    {
        //Menus
        $this->menuhead = [
            [
                "texto" => "Inicio",
                "enlace" => ["productos"]
            ],
            [
                "texto" => "Registro",
                "enlace" => ["registro/PedirDatosRegistro"]
            ]
        ];
        $this->menuizq = [
            [
                "texto" => "Inicio",
                "enlace" => ["productos"]
            ],
            [
                "texto" => "Registro",
                "enlace" => ["registro/PedirDatosRegistro"]
            ]
        ];
        $modelo = new DatosRegistro();

        //Obtenemos el nombre del registro
        $nombre = $modelo->getNombre();


        if (isset($_POST[$nombre])) {

            $modelo->setValores($_POST[$nombre]);

            //Si el modelo es valido se muestra la vista de datos del usuario sino se vuelve a mostrar la vista de registro
            if ($modelo->validar()) {
                //hasheamos la contraseña
                $hash = hash('sha1', $modelo->contrasenia);
                $modelo->contrasenia = $hash;                
                // Guardamos en la base de datos
                if ($modelo->guardar()) {
                    Sistema::app()->irAPagina(["registro", "login"]); // redirige al login
                } else {
                    echo "Error al guardar el usuario";
                }
            } else {
                $this->dibujaVista(
                    "registros",
                    array("modelo" => $modelo),
                    "Crear nuevo usuario"
                );
                exit;
            }
        }
        //Dibujamos la vista de registro con los datos del modelo
        $this->dibujaVista(
            "registros",
            ["modelo" => $modelo],
            "Registrar Usuario"
        );
    }
    //Accion Login
    public function accionLogin()
    {
        //Menus
        $this->menuhead = [
            [
                "texto" => "Inicio",
                "enlace" => ["productos"]
            ],
            [
                "texto" => "Login",
                "enlace" => ["login"]
            ]
        ];
        $this->menuizq = [
            [
                "texto" => "Inicio",
                "enlace" => ["productos"]
            ],
            [
                "texto" => "login",
                "enlace" => ["login"]
            ]
        ];
        $login = new Login();

        //Obtenemos el nombre del login
        $nombre = $login->getNombre();

        if (isset($_POST[$nombre])) {

        //Si el login es valido se autentica el usuario y se redirige a la pagina de inicio sino se vuelve a mostrar la vista de login
            $login->setValores($_POST[$nombre]);

            if ($login->validar()) {
                $login->autenticar();
                Sistema::app()->irAPagina(["productos", "index"]);
            }
        }
        //Dibujamos la vista de login con los datos del login
        $this->dibujaVista(
            "login",
            ["login" => $login],
            "logear Usuario"
        );
    }
    //Accion Logout
    public function accionLogout()
    {
        //Quitamos el registro del usuario y redirigimos a la pagina de inicio
        Sistema::app()->Acceso()->quitarRegistroUsuario();
        Sistema::app()->irAPagina(["productos", "index"]);
    }
}
