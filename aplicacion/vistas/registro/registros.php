<?php
echo CHTML::iniciarForm();
echo CHTML::dibujaEtiqueta("h1", [], "Registro de nuevo usuario");
echo CHTML::dibujaEtiquetaCierre("h1");

echo CHTML::modeloLabel($modelo, "nick",);
echo CHTML::modeloText($modelo, "nick", array("maxlength" => 40, "placeholder" => "Marta Campos"));
echo CHTML::modeloError($modelo, "nick");

echo CHTML::dibujaEtiqueta("br");
echo CHTML::modeloLabel($modelo, "nif");
echo CHTML::modeloText(
    $modelo,
    "nif",
    array("maxlength" => 10, "placeholder" => "12345678X")
);
echo CHTML::modeloError($modelo, "nif");
echo CHTML::dibujaEtiqueta("br");

echo CHTML::modeloLabel($modelo, "fecha_nacimiento");
echo CHTML::modeloText(
    $modelo,
    "fecha_nacimiento",
    array("maxlength" => 10,)
);
echo CHTML::modeloError($modelo, "fecha_nacimiento");
echo CHTML::dibujaEtiqueta("br");

echo CHTML::modeloLabel($modelo, "provincia");
echo CHTML::modeloText(
    $modelo,
    "provincia",
    array("maxlength" => 30, "size" => 31)
);
echo CHTML::modeloError($modelo, "provincia");
echo CHTML::dibujaEtiqueta("br");

echo CHTML::modeloLabel($modelo, "estado");
echo CHTML::modeloListaDropDown(
    $modelo,
    "estado",
    DatosRegistro::dameEstados(null),
    array("linea" => false)
);
echo CHTML::modeloError($modelo, "estado");
echo CHTML::dibujaEtiqueta("br");

echo CHTML::modeloLabel($modelo, "contrasenia");
echo CHTML::modeloPassword(
    $modelo,
    "contrasenia",
    array("maxlength" => 30, "size" => 31)
);
echo CHTML::modeloError($modelo, "contrasenia");
echo CHTML::dibujaEtiqueta("br");

echo CHTML::modeloLabel($modelo, "confirmar_contrasenia");
echo CHTML::modeloPassword(
    $modelo,
    "confirmar_contrasenia",
    array("maxlength" => 30, "size" => 31)
);
echo CHTML::modeloError($modelo, "confirmar_contrasenia");
echo CHTML::dibujaEtiqueta("br");



echo CHTML::campoBotonSubmit("Crear");
echo CHTML::finalizarForm();
