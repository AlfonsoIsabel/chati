<?php

	session_start();

	if (!isset($_SESSION['idUsu'])) {
		header('Location: index.php');
	}

	require 'includes/conexion.inc.php';
	
	$id = $_SESSION['idUsu'];
	$nombre = $_SESSION['nombreUsu'];

	$sqlActualizaEstado = "
		UPDATE usuario
			SET estado_usuario = 1,
			    fuc_usuario = '".date('Y-m-d H:i')."'
			WHERE id_usuario LIKE ".$id.";
	";
	$queryActualizaEstado = mysqli_query($conectar, $sqlActualizaEstado);


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>

	<h1>Bienvenid@ a tu Chat - <a href="editarPerfil.php"><?php echo $nombre; ?></a></h1>
	<a href="cerrar.php">Cerrar Sesión</a>
	<hr>
	<div style="width: 100%;">
		<ul style="list-style-type: none; font-size: 24px; font-family: 'Calibri';">
			<!--
			<li>
				<img src="https://img.favpng.com/16/2/3/koala-bear-clip-art-png-favpng-e9SK7y5GVZm012JrLSbkRVZ71.jpg" style="width: 30px; border-radius: 50%; margin-right: 5px;">
				Pepe
			</li>
			-->
			<?php
				$sqlUsuarios = "
					SELECT *
						FROM usuario
					    WHERE id_usuario NOT LIKE ".$id."
					        AND activo_usuario LIKE 1;
				";
				$queryUsuarios = mysqli_query($conectar, $sqlUsuarios);
				while ($rowUsuarios = mysqli_fetch_assoc($queryUsuarios)) {
					?>
						<li>
						    <a href="chat.php?idAmigo=<?php echo $rowUsuarios['id_usuario']; ?>">
    							<img src="<?php echo $rowUsuarios['foto_usuario']; ?>" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 5px; object-fit: cover;">
    							<?php echo $rowUsuarios['nombre_usuario']; ?>
							</a>
						</li>
					<?php
				}
			?>
		</ul>
	</div>


</body>
</html>