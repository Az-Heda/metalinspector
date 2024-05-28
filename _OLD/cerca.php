<?php
	session_start();
	if (!isset($_SESSION["status"]))
	{
		$_SESSION["username"] = "Utente";
		$_SESSION["status"] = false;
	}
?>
<!doctype html>
<html>
	<head>
		<title>Info band | Metal Inspected</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="CSS/stile.css" />
		<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
		<script src="jquery/include.js"></script>
		<script src="jquery/main.js"></script>
		<script src="jquery/cerca.js"></script>
		<script src="javascript/indirizzo.js"></script>
		<style>
			td
			{
				width: 50%;
			}
			#campi a {
				text-decoration: none;
				font-size: 18px;
			}
			#campi a:hover {
				text-decoration: underline;
			}
			#campi tr:hover {
				background-color: #666666;
				transition: background-color 0.2s ease-in-out;
			}
			#campi tr:hover a {
				color: #ffffff;
			}
			#campi tr td {
				padding-left: 10px;
			}
			input[type="submit"].logout {
				color: #ffffff !important;
				box-shadow: inset 0 0 0 1px #ffffff;
			}
		</style>
	</head>
	<body onload="document.getElementById('ricerca').focus(); indirizzo_2();">
		<header id="header">
			<nav style="width: 100%">
				<div style="padding-left: 10px; display: inline;" id="open_menu">&#9776;&nbsp;Menu</div>
				<div style="float: right; display: inline; padding-right: 10px; color: #ffffff; font-size: 1.25rem;"><?php
					echo '<div style="display: inline; padding-right: 20px;">'.$_SESSION["username"].'</div>';
					if ($_SESSION["status"])
					{
						echo '<form method="post" action="php/login.php" style="display: inline;">';
						echo '<input type="hidden" id="indirizzo_2" name="indirizzo"/>';
						echo '<input type="submit" value="Logout" class="logout" name="logout"/></form>';
					}
				?>
				</div>
			</nav>
			<nav id="menu">
				<ul class="link">
					<li><a href="index.php">Home</a></li>
					<li><a href="cerca.php" class="active">Cerca</a></li>
					<li><a href="login.php">Accedi / registrati</a></li>
					<li><a href="carrello.php">Carrello</a></li>
					<li><a href="desideri.php">Lista dei desideri</a></li>
				</ul>
			</nav>
		</header>
		<section id="banner" style="height: 20rem !important; min-height: 20rem;">
			<div class="inner">
				<h1 class="title">Cerca</h1>
			</div>
		</section>
		<section class="spazio"  style="padding-top: 1em; padding-bottom: 0;">
			<div class="inner">
				<div class="card" style="margin-bottom: 0px">
					<table style="padding-left: 24px; margin-left: auto; margin-right: auto; width: 80%">
						<caption>
							<header class="titolo">
							<input type="text" id="ricerca" class="centro" placeholder="Cerca" style="padding-left: 10px;"/>
							</header>
						</caption>
						<thead>
							<tr>
								<th>Band</th>
								<th>Album</th>
							</tr>
						</thead>
						<tbody id="campi">
							<tr>
								<td><a href="temp/band_id_3.php">Among Gods</a></td>
								<td><a href="temp/album_id_3.php">The Feeding Of Cruelty</a></td>
							</tr>
							<tr>
								<td><a href="temp/band_id_4.php">Insomnium</a></td>
								<td><a href="temp/album_id_4.php">Shadows Of The Dying Sun</a></td>
							</tr>
							<tr>
								<td><a href="temp/band_id_4.php">Insomnium</a></td>
								<td><a href="#">One For Sorrow</a></td>
							</tr>
							<tr>
								<td><a href="temp/band_id_6.php">Iwrestledabearonce</a></td>
								<td><a href="temp/album_id_6.php">Hail Mary</a></td>
							</tr>
							<tr>
								<td><a href="album.php">Sleeping Romance</a></td>
								<td><a href="album.php">Alba</a></td>
							</tr>
							<tr>
								<td><a href="album.php">Sleeping Romance</a></td>
								<td><a href="#">Enlighten</a></td>
							</tr>
							<tr>
								<td><a href="temp/band_id_12.php">Beyond The Black</a></td>
								<td><a href="#">Lost In Forever</a></td>
							</tr>
							<tr>
								<td><a href="temp/band_id_12.php">Beyond The Black</a></td>
								<td><a href="#">Songs Of Love And Death</a></td>
							</tr>
							<tr>
								<td><a href="temp/band_id_12.php">Beyond The Black</a></td>
								<td><a href="temp/album_id_12.php">Heart Of The Hurrincane</a></td>
							</tr>
							<tr>
								<td><a href="temp/band_id_13.php">Thy Art Is Murder</a></td>
								<td><a href="temp/album_id_13.php">Dear Desolation</a></td>
							</tr>
							<tr>
								<td><a href="temp/band_id_13.php">Thy Art Is Murder</a></td>
								<td><a href="#">Hate</a></td>
							</tr>
							<tr>
								<td><a href="temp/band_id_13.php">Thy Art Is Murder</a></td>
								<td><a href="#">Holy War</a></td>
							</tr>
							<tr>
								<td><a href="temp/band_id_13.php">Thy Art Is Murder</a></td>
								<td><a href="#">The Depression Session</a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</body>
</html>