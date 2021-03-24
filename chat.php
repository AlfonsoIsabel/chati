<?php

    session_start();

	if (!isset($_SESSION['idUsu'])) {
		header('Location: index.php');
	}
	
	require 'includes/conexion.inc.php';
	
	if ($_POST){
	    if (isset($_POST['mensaje']) && !empty($_POST['mensaje'])){
	        $sqlNuevoMensaje = "
	            INSERT INTO mensaje
	                VALUES (null, '".date('Y-m-d')."', '".date('H:i')."', 'Enviado','".$_POST['mensaje']."', ".$_SESSION['idUsu'].", ".$_GET['idAmigo'].");
	        ";
	        $queryNuevoMensaje = mysqli_query($conectar, $sqlNuevoMensaje);
	    }
	}

    if ($_GET){
        if (isset($_GET['idAmigo']) && !empty($_GET['idAmigo'])){
            $sqlConversacion = "
                SELECT mensaje.id_emisor AS emisor, mensaje.id_receptor AS receptor, mensaje.contenido_mensaje AS mensaje, mensaje.fecha_mensaje AS fecha, mensaje.hora_mensaje AS hora
                    FROM mensaje
                        JOIN usuario usu1 ON usu1.id_usuario = mensaje.id_emisor
                        JOIN usuario usu2 ON usu2.id_usuario = mensaje.id_receptor
                    WHERE (mensaje.id_emisor LIKE ".$_SESSION['idUsu']."
                        AND mensaje.id_receptor LIKE ".$_GET['idAmigo'].")
                        OR (mensaje.id_receptor LIKE ".$_SESSION['idUsu']."
                        AND mensaje.id_emisor LIKE ".$_GET['idAmigo'].")
                    ORDER BY mensaje.id_mensaje ASC;
            ";
            $queryConversacion = mysqli_query($conectar, $sqlConversacion);
        }else{
            header('Location: main.php');
        }
    }else{
        header('Location: main.php');
    }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<title></title>
</head>
<body style="margin: 0px; padding: 0px;">

	<div style="width: 100%; height: 100vh; font-family: 'Arial';">
		<nav style="width: 100%; height: 80px; background: #141414; display: flex; justify-content: flex-start; align-items: center; box-shadow: 0px 2px 8px -2px black; position: relative; z-index: 1;">
			<a href="main.php" style="color: white; text-decoration: none; font-size: 50px; margin: 30px;">
				<
			</a>
			<?php
			    $sqlAmigoChat = "
			        SELECT nombre_usuario, foto_usuario
			            FROM usuario
			            WHERE id_usuario LIKE ".$_GET['idAmigo'].";
			    ";
			    $queryAmigoChat = mysqli_query($conectar, $sqlAmigoChat);
			    while ($rowAmigoChat = mysqli_fetch_assoc($queryAmigoChat)){
			        ?>
			            <img src="<?php echo $rowAmigoChat['foto_usuario']; ?>" style="width: 60px; border-radius: 50%; margin: 10px;">
			            <h1 style="color: white; margin: 10px;">
			                <?php echo $rowAmigoChat['nombre_usuario']; ?>
			            </h1>
			       <?php
			    }
			?>
		</nav>
		<section style="width: 100%; height: calc(100vh - 160px); background: lightblue; overflow-x: hidden; overflow-y: scroll;">
		    <?php
		    
		    if (mysqli_num_rows($queryConversacion) < 1){
                echo "<div style='background: white; border-radius: 10px; padding: 10px; margin: 10px; width: 200px; text-align: center; position: relative; left: 50%; transform: translate(-50%); box-shadow: 0px 2px 6px -2px black;'>NO HAY MENSAJES</div>";
            }else{
                while ($rowConversacion = mysqli_fetch_assoc($queryConversacion)){
                    if ($rowConversacion['emisor'] == $_GET['idAmigo']){
                        ?>
                            <div class="suMensaje" style="background: #141414; color: #e2e2e2; max-width: 65%; margin: 10px; padding: 20px; border-radius: 10px; box-shadow: 2px 4px 8px -4px black; float: left;">
                				<?php echo $rowConversacion['mensaje']; ?>
                				<div style="text-align: right; color: #e2e2e2; font-size: 12px;">
                				    <?php echo $rowConversacion['fecha']." ".$rowConversacion['hora']; ?>
                				</div>
                			</div>
            			<div style="clear: both;"></div>
                        <?php
                    }else{
                        ?>
                            <div class="miMensaje" style="background: #e2e2e2; color: #141414; max-width: 65%; margin: 10px; padding: 20px; border-radius: 10px; box-shadow: 2px 4px 8px -4px black; float: right;">
                				<?php echo $rowConversacion['mensaje']; ?>
                				<div style="text-align: right; color: #141414; font-size: 12px;">
                				    <?php echo $rowConversacion['fecha']." ".$rowConversacion['hora']; ?>
                				</div>
                			</div>
            			<div style="clear: both;"></div>
                        <?php
                    }
                    //echo $rowConversacion['mensaje']." <br> ".$rowConversacion['fecha']." ".$rowConversacion['hora'];
                }
            }
            
		    
		    ?>
		    <!--
			<div class="suMensaje" style="background: #141414; color: #e2e2e2; max-width: 65%; margin: 10px; padding: 20px; border-radius: 10px; box-shadow: 2px 4px 8px -4px black; float: left;">
				eyyyyyy
			</div>
			<div style="clear: both;"></div>
			<div class="miMensaje" style="background: #e2e2e2; color: #141414; max-width: 65%; margin: 10px; padding: 20px; border-radius: 10px; box-shadow: 2px 4px 8px -4px black; float: right;">
				Si te aburres en tu casa, te pillas el Assassin y te lo pasas.
			</div>
			<div style="clear: both;"></div>
			-->
		</section>
		<footer style="width: 100%; height: 80px; background: #141414;">
			<form name="nuevoMensaje" action="" method="POST" style="width: 100%; display: flex; align-items: center; height: 100%;">
				<textarea style="resize: none; width: 90%; height: 50%; font-size: 20px; border: none; margin: 10px; border-radius: 50px; padding: 10px 30px; color: white; background: rgba(255, 255, 255, 0.2); font-family: 'Arial';" name="mensaje" placeholder="Mensaje..." required></textarea>
				<!-- <input type="file" name="archivo" value=""> -->
				<button type="submit" style="width: 65px; height: 65px; border-radius: 50%; background: rgba(255, 255, 255, 0.5); color: white; border: none; cursor: pointer;">
					<img src="https://koalatomato.com/chat/assets/rsc/img/paper-plane-solid.svg" style="filter: invert(100%); width: 60%;">
				</button>
			</form>
		</footer>
	</div>


<script>

    var alto = document.querySelector('section').scrollHeight;
    document.querySelector('section').scrollTo(0, alto);

</script>

</body>
</html>












