<?php
echo CHTML::iniciarForm(atributosHTML: ["class" => "form-login"]);
echo CHTML::dibujaEtiqueta("h1", [], "Login de usuario");
echo CHTML::dibujaEtiquetaCierre("h1");


echo CHTML::modeloLabel($login, "nick",);
echo CHTML::modeloText($login, "nick", array("maxlength" => 40, "placeholder" => "Marta Campos"));
echo CHTML::modeloError($login, "nick");

echo CHTML::dibujaEtiqueta("br");
echo CHTML::modeloLabel($login, "contrasenia");
echo CHTML::modeloPassword(
    $login,
    "contrasenia",
    array("maxlength" => 30, "size" => 31)
);
echo CHTML::modeloError($login, "contrasenia");
echo CHTML::dibujaEtiqueta("br");
echo CHTML::campoBotonSubmit("Crear");
echo CHTML::finalizarForm();