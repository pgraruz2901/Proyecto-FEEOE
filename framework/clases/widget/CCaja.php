<?php
class CCaja extends CWidget
{
    private string $titulo;
    private string $contenido;
    private array $atributosHTML;

    public function __construct($titulo, $contenido = "", $atributosHTML = [])
    {
        $this->titulo = $titulo;
        $this->contenido = $contenido;
        $atributosHTML["class"] = isset($atributosHTML["class"]) ? "caja " . $atributosHTML["class"] : "caja";
        $this->atributosHTML = $atributosHTML;
    }
    public function dibujate(): string
    {
        $caja = "";
        $caja .= CHTML::dibujaEtiqueta("div", $this->atributosHTML, "", false);
        $caja .= CHTML::dibujaEtiqueta("div", ["class" => "titulo"], $this->titulo, false);
        $caja .= self::dibujaBoton();
        $caja .= CHTML::dibujaEtiquetaCierre("div");
        $caja .= CHTML::dibujaEtiqueta("div", ["class" => "cuerpo", "id" => "div2", "style" => "display: block;"], $this->contenido);
        $caja .= CHTML::dibujaEtiquetaCierre("div");
        return $caja;
    }
    public function dibujaApertura(): string
    {
        $caja = "";
        $caja .= CHTML::dibujaEtiqueta("div", $this->atributosHTML, "", false);
        $caja .= CHTML::dibujaEtiqueta("div", ["class" => "titulo"], $this->titulo, false);
        $caja .= self::dibujaBoton();
        $caja .= CHTML::dibujaEtiquetaCierre("div");
        $caja .= CHTML::dibujaEtiqueta("div", ["class" => "cuerpo", "id" => "div2", "style" => "display: block;"], $this->contenido, false);
        return $caja;
    }
    public function dibujaFin(): string
    {
        $caja = "";
        $caja .= CHTML::dibujaEtiquetaCierre("div");
        $caja .= CHTML::dibujaEtiquetaCierre("div");
        return $caja;
    }
    public static function dibujaBoton(): string
    {
        $atributos = [
            "type" => "button",
            "onclick" => "ocultaCaja(this);",
            "id" => "btnOcultar",
            "style" => "margin-left: 55px;"
        ];
        return CHTML::boton("Ocultar", $atributos);
    }
    public static function requisitos(): string
    {
        $codigo = <<<EOF
        function ocultaCaja() {
            let btn = document.getElementById("btnOcultar");
            let div2 = document.getElementById("div2");
            if (div2.style.display == "block") {
                div2.style.display = "none";
            } else {
                div2.style.display = "block";
            }
        }
        EOF;

        return CHTML::script($codigo);
    }
}
