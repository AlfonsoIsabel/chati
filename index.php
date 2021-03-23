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
			$_SESSION['fdnUsu'] = $rowLogin['fdn_usuario'];
			$_SESSION['fotoUsu'] = $rowLogin['foto_usuario'];
			$_SESSION['rolUsu'] = $rowLogin['nombre_rol'];
			header('Location: main.php');
		}
	}

	if ($_POST) {
		/*
		echo $_POST['correo'];
		echo "<br>";
		echo $_POST['clave'];
		echo "<br>";
		if (isset($_POST['recordar'])) {
			echo $_POST['recordar'];
		}
		*/

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
				echo "Usuario y/o Contraseña incorrectos";
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
								$_SESSION['fdnUsu'] = $rowLogin['fdn_usuario'];
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
<html>
<head>
	<meta charset="utf-8">

	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.11.2/css/all.css">

	<title></title>
</head>
<body>


	<i class="fas fa-acorn"></i>

	<br>


	<h1>Inicia sesión</h1>
	<form name="login" action="" method="POST">
		<input type="email" name="correo" value="" placeholder="Correo Electrónico" required>
		<input type="password" name="clave" value="" placeholder="Contraseña" required>
		<input type="checkbox" name="recordar" value="si" id="recordar"> <label for="recordar">Recuérdame</label>
		<button type="submit" name="iniciar">Acceder</button>
	</form>

	<p>¿Aún no tienes cuenta? <a href="registro.php">Regístrate</a></p>


</body>
</html>