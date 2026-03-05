<?php
echo  "Nick: " . $modelo->nick . " Nif: " . $modelo->nif . " fecha-Nacimiento: " . $modelo->fecha_nacimiento;
header('Content-Disposition: attachment; filename="datosUsuario.txt"');
header('Content-Type: text/plain; charset=utf-8');
