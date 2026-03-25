<?php
echo CHTML::iniciarForm(atributosHTML: ["class" => "form-login"]);
echo CHTML::dibujaEtiqueta("h1", [], "Login de usuario");
echo CHTML::dibujaEtiquetaCierre("h1");


echo CHTML::modeloLabel($login, "nick",);
echo CHTML::modeloText($login, "nick", array("maxlength" => 40, "placeholder" => "Login de usuario", "size" => 31));
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

//Agregamos estilos para el formulario de login lo pongo aquí porque no se por qué no me funcionan si los pongo en el archivo principal 
?>
<style>
.form-login {
    max-width: 600px;
    margin: 4rem auto;
    padding: 2rem;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    text-align: center;
}

.form-login h1 {
    font-size: 1.8rem;
    color: #111827;
    margin-bottom: 2rem;
    font-weight: 600;
}

.form-login label {
    display: block;
    font-size: 0.85rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
    text-align: left;
}

.form-login input[type="text"],
.form-login input[type="password"] {
    width: 95%;
    padding: 0.8rem 1rem;
    margin-bottom: 1.2rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 0.95rem;
    transition: all 0.2s ease;
}

.form-login input:focus {
    outline: none;
    border-color: #f97316;
    box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
}

.form-login input::placeholder {
    color: #9ca3af;
}

.form-login .error {
    color: #dc2626;
    font-size: 0.75rem;
    margin-top: -0.5rem;
    margin-bottom: 0.8rem;
    text-align: left;
}

input[type="submit"] {
    padding: 0.75rem 1.5rem;
    background: #f97316;
    color: white;
    border: none;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.form-login input[type="submit"]:hover {
    background: #fb923c;
    transform: translateY(-1px);
}
</style>