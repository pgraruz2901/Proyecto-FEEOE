<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $titulo; ?></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="/estilos/principal.css" />

	<link rel="icon" type="image/png" href="/imagenes/favicon.png" />
	<?php
	if (isset($this->textoHead))
		echo $this->textoHead;
	?>
</head>

<body>
		<header>
			<div id="nombre">
			<div class="logo">
				<a href="/index.php"><img src="/imagenes/logo.png" width="50px" height="50px" /></a>
			</div>
			<div class="titulo">
				<a href="/index.php">
					<h2>PROYECTO FEEOE</h2>
				</a>
			</div>
			</div>
		
		<nav id="submenu">
			<ul><?php echo CHTML::link("Ver Productos", Sistema::app()->generaURL(["productos", "index"])); ?></ul>
			<ul><?php echo CHTML::link("Caja", Sistema::app()->generaURL(["inicial", "caja"])); ?></ul>
		</nav>
		<div id="login">
			<?php
			if (Sistema::app()->Acceso()->hayUsuario()) {
				echo CHTML::dibujaEtiqueta("p");
				echo "Usuario: " . Sistema::app()->Acceso()->getNombre();
				echo CHTML::dibujaEtiquetaCierre("p");
			} else {
				echo CHTML::dibujaEtiqueta("p");
				echo "No hay usuario conectado";
				echo CHTML::dibujaEtiquetaCierre("p");
			}
			?>
			<div>
				<?php
				if (Sistema::app()->Acceso()->hayUsuario()) {
				?>
					<button><?php echo CHTML::link("Unlogin", Sistema::app()->generaURL(["registro", "logout"])) ?></button>
				<?php
				} else {
				?>
					<button><?php echo CHTML::link("Login", Sistema::app()->generaURL(["registro", "login"])) ?></button>
					<button><?php echo CHTML::link("Registrarse", Sistema::app()->generaURL(["registro", "pedirDatosRegistro"])) ?></button>
				<?php
				}
				?>
			</div>
		</div>
		</header><!-- #header -->
	<div id="todo">

		<div class="barraMenu">
			<ul>
				<?php
				if (isset($this->menuhead)) {
					foreach ($this->menuhead as $opcion) {
						if ($opcion !== $this->menuhead[0]) {
							echo CHTML::dibujaEtiqueta("p");
							echo ">   ";
							echo " ";
							echo CHTML::dibujaEtiquetaCierre("p");
						}

						echo CHTML::dibujaEtiqueta(
							"li",
							array(),
							"",
							false
						);
						echo CHTML::css("padding", "40px");
						echo CHTML::link(
							$opcion["texto"],
							$opcion["enlace"]
						);
						echo CHTML::dibujaEtiquetaCierre("li");
						echo CHTML::dibujaEtiqueta("br") . "\r\n";
					}
				}

				?>
			</ul>
		</div>


		<div class="contenido">
			<aside>
				<ul>
					<?php
					if (isset($this->menuizq)) {
						foreach ($this->menuizq as $opcion) {
							echo CHTML::dibujaEtiqueta(
								"li",
								array(),
								"",
								false
							);
							echo CHTML::link(
								$opcion["texto"],
								$opcion["enlace"]
							);
							echo CHTML::dibujaEtiquetaCierre("li");
							echo CHTML::dibujaEtiqueta("br") . "\r\n";
						}
					}

					?>
				</ul>
			</aside>
			<article>
				<?php echo $contenido; ?>
			</article><!-- #content -->

		</div>
		<footer>
			<h2><span>Copyright:</span> <?php echo Sistema::app()->autor ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h2>
		</footer><!-- #footer -->

	</div><!-- #wrapper -->
</body>

</html>