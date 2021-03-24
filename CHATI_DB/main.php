<?php

session_start();

	if (!isset($_SESSION['idUsu'])) {
		header('Location: index.php');
	}
	require 'includes/conexion.inc.php';
	
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="estilo.css">
	<title>Document</title>
</head>
<body>
	<div id="container">
  <aside>
    <header>
      <input type="text" placeholder="search">
    </header>
    <ul>
      <li>
        <img src="img/asno.jpg" alt="">
        <div>
          <h2>Nombre</h2>
          <h3>
            <span class="status orange"></span>
            offline
          </h3>
        </div>
      </li>
      <li>
        <img src="img/bob.jpg" alt="">
        <div>
          <h2>Nombre</h2>
          <h3>
            <span class="status green"></span>
            online
          </h3>
        </div>
      </li>
      <li>
        <img src="img/mafalda.jpg" alt="">
        <div>
          <h2>Nombre</h2>
          <h3>
            <span class="status orange"></span>
            offline
          </h3>
        </div>
      </li>
      <li>
        <img src="img/bob.jpg" alt="">
        <div>
          <h2>Nombre</h2>
          <h3>
            <span class="status green"></span>
            online
          </h3>
        </div>
      </li>
      <li>
        <img src="img/pegui.jpg" alt="">
        <div>
          <h2>Nombre</h2>
          <h3>
            <span class="status orange"></span>
            offline
          </h3>
        </div>
      </li>
      <li>
        <img src="img/shrek.png" alt="">
        <div>
          <h2>Nombre</h2>
          <h3>
            <span class="status green"></span>
            online
          </h3>
        </div>
      </li>
      <li>
        <img src="img/asno.jpg" alt="">
        <div>
          <h2>Nombre</h2>
          <h3>
            <span class="status green"></span>
            online
          </h3>
        </div>
      </li>
      <li>
        <img src="img/bob.jpg" alt="">
        <div>
          <h2>Nombre</h2>
          <h3>
            <span class="status green"></span>
            online
          </h3>
        </div>
      </li>
      <li>
        <img src="img/mafalda.jpg" alt="">
        <div>
          <h2>Nombre</h2>
          <h3>
            <span class="status green"></span>
            online
          </h3>
        </div>
      </li>
      <li>
        <img src="img/bob.jpg" alt="">
        <div>
          <h2>Nombre</h2>
          <h3>
            <span class="status orange"></span>
            offline
          </h3>
        </div>
      </li>
    </ul>
  </aside>
  <main>
    <header>
      <img src="img/bob.jpg" alt="">
      <div>
        <h2>Chat with Vincent Porter</h2>
        <h3>already 1902 messages</h3>
      </div>
      <img src="img/asno.jpg" alt="">
    </header>
    <ul id="chat">
      <li class="you">
        <div class="entete">
          <span class="status green"></span>
          <h2>Vincent</h2>
          <h3>10:12AM, Today</h3>
        </div>
        <div class="triangle"></div>
        <div class="message">
          Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
        </div>
      </li>
      <li class="me">
        <div class="entete">
          <h3>10:12AM, Today</h3>
          <h2>Vincent</h2>
          <span class="status blue"></span>
        </div>
        <div class="triangle"></div>
        <div class="message">
          Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
        </div>
      </li>
      <li class="me">
        <div class="entete">
          <h3>10:12AM, Today</h3>
          <h2>Vincent</h2>
          <span class="status blue"></span>
        </div>
        <div class="triangle"></div>
        <div class="message">
          OK
        </div>
      </li>
      <li class="you">
        <div class="entete">
          <span class="status green"></span>
          <h2>Vincent</h2>
          <h3>10:12AM, Today</h3>
        </div>
        <div class="triangle"></div>
        <div class="message">
          Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
        </div>
      </li>
      <li class="me">
        <div class="entete">
          <h3>10:12AM, Today</h3>
          <h2>Vincent</h2>
          <span class="status blue"></span>
        </div>
        <div class="triangle"></div>
        <div class="message">
          Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
        </div>
      </li>
      <li class="me">
        <div class="entete">
          <h3>10:12AM, Today</h3>
          <h2>Vincent</h2>
          <span class="status blue"></span>
        </div>
        <div class="triangle"></div>
        <div class="message">
          OK
        </div>
      </li>
    </ul>
    <footer>
      <textarea placeholder="Type your message"></textarea>
      <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/ico_picture.png" alt="">
      <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/ico_file.png" alt="">
      <a href="#">Send</a>
    </footer>
  </main>
</div>	
</body>
</html>
