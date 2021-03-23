<?php

	if (isset($_COOKIE['idUsuario'])) {
		require 'includes/conexion.inc.php';
		$sqlLogin = "
			SELECT *
				FROM usuario
				JOIN rol USING (id_rol)
				WHERE id_usuario LIKE ".$_COOKIE['idUsuario'].";
		";
		$queryLogin = mysqli_query($conectar, $sqlLogin);
		while ($rowLogin = mysqli_fetch_assoc($queryLogin)) {
			session_start();
			$_SESSION['idUsu'] = $rowLogin['id_usuario'];
			$_SESSION['nombreUsu'] = $rowLogin['nombre_usuario'];
			$_SESSION['correoUsu'] = $rowLogin['correo_usuario'];
			$_SESSION['estadoUsu'] = $rowLogin['estado_usuario'];
			$_SESSION['fotoUsu'] = $rowLogin['foto_usuario'];
			$_SESSION['rolUsu'] = $rowLogin['nombre_rol'];
			header('Location: main.php');
		}
	}

	if ($_POST) {
		

		// Comprobamos que lleguen bien los Datos
		if ((isset($_POST['correo']) && !empty($_POST['correo'])) && (isset($_POST['clave']) && !empty($_POST['clave']))) {
			$correo = $_POST['correo'];
			// Conectamos con la Base de Datos
			require 'includes/conexion.inc.php';
			$sqlLogin = "
				SELECT *
					FROM usuario
					JOIN rol USING (id_rol)
					WHERE correo_usuario LIKE '".$correo."';
			";
			$queryLogin = mysqli_query($conectar, $sqlLogin);
			if (mysqli_num_rows($queryLogin) < 1) {
				echo "Usuario y/o Contraseña incorrectos 1";
			}else{
				$clave = $_POST['clave'];
				while ($rowLogin = mysqli_fetch_assoc($queryLogin)) {
					if (password_verify($clave, $rowLogin['clave_usuario'])) {
						if ($rowLogin['validado_usuario'] == 1) {
							if ($rowLogin['activo_usuario'] == 1) {
								session_start();
								$_SESSION['idUsu'] = $rowLogin['id_usuario'];
								$_SESSION['nombreUsu'] = $rowLogin['nombre_usuario'];
								$_SESSION['correoUsu'] = $rowLogin['correo_usuario'];
								$_SESSION['estadoUsu'] = $rowLogin['estado_usuario'];
								$_SESSION['fotoUsu'] = $rowLogin['foto_usuario'];
								$_SESSION['rolUsu'] = $rowLogin['nombre_rol'];
								if (isset($_POST['recordar'])) {
									setcookie("idUsuario", $_SESSION['idUsu'], time()+63072000);
								}
								header('Location: main.php');
							}else{
								echo "Tu cuenta está desactivada. Por favor, reactívala";
							}
						}else{
							echo "Debes validar tu cuenta para poder acceder.";
						}

					}else{
						echo "Usuario y/o Contraseña incorrectos";
					}
				}
			}
		}else{
			echo "Debes rellenar todos los campos";
		}
		
	}


    if (isset($_GET['validado'])){
        echo "Gracias por validar tu cuenta. Disfruta de nuestro chat.";
    }


?>


<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="author" content="">
	<meta name="copyright" content="">
	<meta name="contact" content="">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="robots" content="NoIndex, NoFollow">
	<meta name="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, shrink-to-fit=no">

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<link rel="icon" type="icon/png" href="favicon.png">
	<title>Mi Web</title>
</head>
<body>
	
	<h1>Inicia sesión</h1>
	<form name="login" action="" method="POST">
		<input type="email" name="correo" value="" placeholder="Correo Electrónico" required>
		<input type="password" name="clave" value="" placeholder="Contraseña" required>
		<input type="checkbox" name="recordar" value="si" id="recordar"><label for="recordar">Recuérdame</label>
		<button type="submit" name="iniciar">Acceder</button>
	</form>
	<p>¿Aún no tienes cuenta? <a href="registro.php">Regístrate</a></p>

	<script type="text/javascript" src="assets/js/script.js"></script>
	<script type="text/javascript">
		
	</script>

</body>
</html>