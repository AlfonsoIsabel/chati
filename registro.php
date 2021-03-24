<?php

	if ($_POST) {
		/*
		echo $_POST['nombre'];
		echo "<br>";
		echo $_POST['correo'];
		echo "<br>";
		echo $_POST['clave'];
		echo "<br>";
		echo $_POST['reclave'];
		echo "<br>";
		echo $_POST['fdn'];
		*/
		$nombre = $_POST['nombre'];
		$correo = $_POST['correo'];
		$clave = $_POST['clave'];
		$reclave = $_POST['reclave'];
		$fdn = $_POST['fdn'];
		$sexo = $_POST['sexo'];

		if ((isset($correo) && !empty($correo)) && (isset($nombre) && !empty($nombre)) && (isset($clave) && !empty($clave)) && (isset($reclave) && !empty($reclave)) && (isset($fdn) && !empty($fdn))) {
			if ($clave == $reclave) {
				require 'includes/conexion.inc.php';
				$sqlExisteCorreo = "
					SELECT correo_usuario
						FROM usuario
						WHERE correo_usuario LIKE '".$correo."';
				";
				$queryExisteCorreo = mysqli_query($conectar, $sqlExisteCorreo);
				if (mysqli_num_rows($queryExisteCorreo) > 0) {
					echo "Ese correo ya está registrado. Utilice otro";
				}else{
					$sqlNuevoUsuario = "
						INSERT INTO usuario
							VALUES (null, '".$nombre."', '".$correo."', '".password_hash($clave, PASSWORD_DEFAULT)."', 'https://i.pinimg.com/originals/2f/a8/9a/2fa89a127b2ac70c76120da902d3c4a7.jpg', '".$fdn."', '', '', NOW(), '".$sexo."', 1, 0, 0, 2);
					";
					$queryNuevoUsuario = mysqli_query($conectar, $sqlNuevoUsuario);
					if (!$queryNuevoUsuario) {
						echo "Ocurrió un error inesperado. Inténtelo más tarde";
					}else{
					    $sqlRecienRegistrado = "
					        SELECT id_usuario
					            FROM usuario
					            WHERE correo_usuario LIKE '".$correo."';
					    ";
					    $queryRecienRegistrado = mysqli_query($conectar, $sqlRecienRegistrado);
					    while ($rowRecienRegistrado = mysqli_fetch_assoc($queryRecienRegistrado)){
					        $ruta = "users/".$rowRecienRegistrado['id_usuario'];
					        mkdir($ruta);
					        mkdir($ruta."/archivos");
					        mkdir($ruta."/profile");
					        $receptor = $correo;
					        $asunto = "Valida tu cuenta";
					        $mensaje = "Bienvenid@ al chat de KOALATOMATO.COM.<br> Para validar tu cuenta pulsa <a href='https://koalatomato.com/chat/validar.php?idUsuario=".$rowRecienRegistrado['id_usuario']."' target='blank'>aquí</a>";
					        $cabecera = "MIME-Version: 1.0" . "\r\n";
					        $cabecera .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					        $cabecera .= 'From: Koala Colorao | Info <info@koalatomato.com>' . "\r\n";
					        mail($receptor, $asunto, $mensaje, $cabecera);
					    }
						echo "Usuario registrado correctamente. Revise su correo electrónico.";
					}
				}
			}else{
				echo "Las contraseñas no coinciden";
			}
		}else {
			echo "Debes rellenar todos los campos";
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body style="background: skyblue;">

	<div class="container d-flex flex-column">
		<div class="row">
			<div class="col-6">
				<h1>Registro</h1>
			</div>
		</div>

		<div class="row mt-3">			
			<div class="col-4">
				<form name="registro" action="" method="POST">
					
					<div class="mb-3">
						<input type="text" name="nombre" value="" required placeholder="Nombre" class="form-control">
					</div>
					<div class="mb-3">
						<input type="email" name="correo" value="" required placeholder="Correo Electrónico" class="form-control">
					</div>
					<div class="mb-3">
						<input type="password" name="clave" value="" required placeholder="Contraseña" class="form-control">
					</div>
					<div class="mb-3">
						<input type="password" name="reclave" value="" required placeholder="Repite Contraseña" class="form-control">
					</div>
					<div class="mb-3">
						<input type="date" name="fdn" value="" required class="form-control">
					</div>
					<div class="mb-3">
						<select name="sexo" required class="form-control">
						    <option value="">-- Sexo</option>
						    <option value="Mujer">Mujer</option>
						    <option value="Hombre">Hombre</option>
						    <option value="Otro">Otro</option>
						</select>
					</div>
					<button type="submit" class="btn btn-primary">Regístrame</button>
				</form>

				<p class="mt-3">Ya tengo cuenta. <a href="index.php">Iniciar Sesión</a></p>
			</div>
		</div>
	</div>



	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>


</body>
</html>