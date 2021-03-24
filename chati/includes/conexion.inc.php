<?php

	$servidorBD = "motoraidermad.com.mysql";
	$usuarioBD = "motoraidermad_com_chati_db";
	$claveBD = "1234.Aa";
	$nombreBD = "motoraidermad_com_chati_db";

	$conectar = mysqli_connect($servidorBD, $usuarioBD, $claveBD, $nombreBD);

	mysqli_set_charset($conectar, 'utf8mb4');

	if (!$conectar) {
		die("Error al conectar con la Base de Datos");
	}

?>