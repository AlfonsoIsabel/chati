<?php

session_start();

	if (!isset($_SESSION['idUsu'])) {
		header('Location: index.php');
	}
	require 'includes/conexion.inc.php';
	
?>




<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	
</body>
</html>