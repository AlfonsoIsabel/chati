<?php

	session_start();

	if (!isset($_SESSION['idUsu'])) {
		header('Location: index.php');
	}

	require 'includes/conexion.inc.php';

    if (isset($_GET['desactivar'])){
        ?>
            <script>
                var confirmar = confirm('Seguro que quieres desactivar tu cuenta?');
                if (confirmar){
                    console.log('Se va a borrar la cuenta');
                }else{
                    console.log('Falsa alarma...');
                }
            </script>
        <?php
    }
    
    
    if ($_POST){
        if (isset($_POST['cambiaDatos'])){
            if ((isset($_POST['nombre']) && !empty($_POST['nombre'])) && (isset($_POST['correo']) && !empty($_POST['correo']))){
                $sqlActualizarDatos = "
                    UPDATE usuario
                        SET nombre_usuario = '".$_POST['nombre']."',
                            correo_usuario = '".$_POST['correo']."',
                        WHERE id_usuario LIKE ".$_SESSION['idUsu'].";
                ";
                $queryActualizarDatos = mysqli_query($conectar, $sqlActualizarDatos);
                if ($queryActualizarDatos){
                    $_SESSION['nombreUsu'] = $_POST['nombre'];
                    $_SESSION['correoUsu'] = $_POST['correo'];
                }
                echo "Datos actualizados";
            }else{
                echo "Debes rellenar todos los campos";
            }
        }elseif (isset($_POST['cambiaClave'])){
            if ((isset($_POST['clave']) && !empty($_POST['clave'])) && (isset($_POST['reclave']) && !empty($_POST['reclave']))) {
                if ($_POST['clave'] == $_POST['reclave']){
                    $sqlActualizarDatos = "
                        UPDATE usuario
                            SET clave_usuario = '".password_hash($_POST['clave'], PASSWORD_DEFAULT)."'
                            WHERE id_usuario LIKE ".$_SESSION['idUsu'].";
                    ";
                    $queryActualizarDatos = mysqli_query($conectar, $sqlActualizarDatos);
                    header('Location: cerrar.php');
                }else{
                    echo "Las contraseñas no coinciden";
                }
            }else{
                echo "Debes rellenar todos los campos";
            }
        }elseif (isset($_POST['cambiaFoto'])){
            if ($_FILES['foto']['type'] == "image/jpeg" || $_FILES['foto']['type'] == "image/png"){
                if ($_FILES['foto']['size'] <= 1048576){
                    $fotoFinal = "users/".$_SESSION['idUsu']."/profile/".$_FILES['foto']['name'];
                    move_uploaded_file($_FILES['foto']['tmp_name'], $fotoFinal);
                    $sqlActualizaFoto = "
                        UPDATE usuario
                            SET foto_usuario = '".$fotoFinal."'
                            WHERE id_usuario LIKE ".$_SESSION['idUsu'].";
                    ";
                    $queryActualizaFoto = mysqli_query($conectar, $sqlActualizaFoto);
                    $_SESSION['fotoUsu'] = $fotoFinal;
                }else{
                    echo "El archivo es demasiado grande, reduce su tamaño";
                }
            }else{
                echo "Solo puede subir .JPG ó .PNG";
            }
        }
    }
    
    
    
    

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
    
    <a href="main.php">Volver</a>
    <h1>Edita tu perfil - <a href="#"><?php echo $_SESSION['nombreUsu']; ?></a></h1>
	<a href="cerrar.php">Cerrar Sesión</a>
	<hr>
	
	<form name="cambiarDatos" action="" method="POST">
	    <fieldset>
	        <legend>Cambiar datos del perfil</legend>
	        <input type="text" name="nombre" placeholder="Nombre" value="<?php echo $_SESSION['nombreUsu']; ?>" required>
	        <input type="email" name="correo" placeholder="Correo Electrónico" value="<?php echo $_SESSION['correoUsu']; ?>" required>
	        <button type="submit" name="cambiaDatos">Guardar</button>
	    </fieldset>
	</form>
	
	<br><br>
	
	<form name="cambiarClave" action="" method="POST">
	    <fieldset>
	        <legend>Cambiar de Contraseña</legend>
	        <input type="password" name="clave" value="" required placeholder="Nueva Contraseña">
	        <input type="password" name="reclave" value="" required placeholder="Repite Contraseña">
    	    <button type="submit" name="cambiaClave">Cambiar</button>
	    </fieldset>
	</form>
	
	<br><br>
	
	<form name="cambiarFoto" action="" method="POST" enctype="multipart/form-data">
	    <fieldset>
	        <legend>Cambiar Foto Perfil</legend>
	        <label>
	            Foto Actual:
	            <br>
	            <img src="<?php echo $_SESSION['fotoUsu']; ?>" alt="Mi Foto de Perfil" style="width: 150px;">
	        </label>
	        <br><br>
	        <label>Cambiar Foto por:</label>
	        <input type="file" name="foto" value="" required>
	        <button type="submit" name="cambiaFoto">Aplicar</button>
	    </fieldset>
	</form>
	
	<br><br>
	
	<a href="?desactivar">Desactivar mi cuenta</a>
	
</body>
</html>