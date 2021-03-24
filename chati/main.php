<?php

session_start();

	if (!isset($_SESSION['idUsu'])) {
		header('Location: index.php');
	}
	require 'includes/conexion.inc.php';
	
        if ($_GET){
                if (isset($_GET['idAmigo']) && !empty($_GET['idAmigo'])){
                    $sqlConversacion = "
                        SELECT mensaje.id_emisor AS emisor, mensaje.id_receptor AS receptor, mensaje.contenido_mensaje AS mensaje, mensaje.fecha_mensaje AS fecha, mensaje.hora_mensaje AS hora
                            FROM mensaje
                                JOIN usuario usu1 ON usu1.id_usuario = mensaje.id_emisor
                                JOIN usuario usu2 ON usu2.id_usuario = mensaje.id_receptor
        
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
<html lang="es">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chati | Conversación</title>
	<link rel="stylesheet" href="assets/css/style.css">
	<title>Document</title>
</head>
<body>
	<div id="container">
  <aside>
    <header>
      <input type="text" placeholder="search">
    </header>
    <ul>
        <?php
        $sqlUsuarios ="
        SELECT *
        FROM usuario
        WHERE id_usuario NOT LIKE ".$_SESSION['idUsu'].";
        ";
        $queryUsuarios = mysqli_query($conectar, $sqlUsuarios);
        
        while($rowUsuarios = mysqli_fetch_assoc($queryUsuarios)){
        ?>
        <li>
        <a href="main.php?idAmigo=<?php echo $rowUsuarios['id_usuario'];?>">
        <img src="<?php echo $rowUsuarios['foto_usuario'];?>" alt="">
        <div>
          <h2><?php echo $rowUsuarios['nombre_usuario'];?></h2>
        </div>
        </a>
        </li>
        <?php
        }
        ?>
      
    </ul>
  </aside>
  <main>
    <header>
    <?php
        $sqlAmigo ="
        SELECT *
        FROM usuario
        WHERE id_usuario LIKE ".$_GET['idAmigo'].";
        ";
        $queryAmigo = mysqli_query($conectar, $sqlAmigo);
        
        $fotoAmigo = null;
        $nombreAmigo = null;
        
        while($rowAmigo = mysqli_fetch_assoc($queryAmigo)){
        $fotoAmigo = $rowAmigo['foto_usuario'];
        $nombreAmigo = $rowAmigo['nombre_usuario'];
        }
        ?>

      <img src="<?php echo $_SESSION['fotoUsu'];?>" alt="">
      <div>
        <h2>Chat con <?php echo $nombreAmigo;?></h2>
        <h3>already 1902 messages</h3>
      </div>
      <img src="<?php echo $fotoAmigo;?>" alt="">
    </header>
    <ul id="chat">
      <li class="you">
        <div class="entete">
          <span class="status green"></span>
          <h2><?php echo $nombreAmigo;?></h2>
          <h3><?php "hora y fecha de mensaje"?></h3>
        </div>
        <div class="triangle"></div>
        <div class="message">
          Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
        </div>
      </li>
      <li class="me">
        <div class="entete">
          <h3>10:12AM, Today</h3>
          <h2><?php echo $_SESSION['nombreUsu'];?></h2>
          <span class="status blue"></span>
        </div>
        <div class="triangle"></div>
        <div class="message">
          Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
        </div>
      </li>
    </ul>
    <footer>
      <textarea placeholder="Type your message"></textarea>
      <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/ico_picture.png" alt="">
      <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/ico_file.png" alt="">
      <a href="#">Enviar</a>
    </footer>
  </main>
</div>	
</body>
</html>

