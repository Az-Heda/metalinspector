<?php
	$band = false;
	$pag = nome_pagina($_SERVER["PHP_SELF"]);
	$id_menu = "";
	switch ($pag)
	{
		case "index.php":
			$id_menu = "home";
			break;
		case "cerca.php":
			$id_menu = "cerca";
			break;
		case "album.php":
			$id_menu = "album";
			break;
		case "statistic.php":
			$id_menu = "statistic";
			break;
		case "login.php":
			$id_menu = "login";
			break;
		case "carrello.php":
			$id_menu = "carrello";
			break;
		case "desideri.php":
			$id_menu = "desideri";
			break;
		case "band.php":
			$band = true;
			$id_menu = "band";
			break;
	}
	$indirizzo = $_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"];
?>


<header id="header">
	<nav style="width: 100%">
		<div style="padding-left: 10px; display: inline;" id="open_menu">&#9776;&nbsp;Menu</div>
		<div style="float: right; display: inline; padding-right: 10px; color: #ffffff; font-size: 1.25rem;">
		<?php
			echo '<div style="display: inline; padding-right: 20px;">'.CrossSiteScripting($_SESSION["username"]).'</div>';
			if ($_SESSION["logged"])
			{
			?>
				<form method="post" action="php/login.php" style="display: inline;">
				<?php
					echo '<input type="hidden" name="indirizzo" value="'.$indirizzo.'"/>'."\n";
				?>
				<input type="submit" value="Logout" class="logout" name="logout"/></form>
			<?php
			}
		?>
		</div>
	</nav>

	<nav id="menu">
		<ul class="link">
			<li><a href="./" id="home">Home</a></li>
			<li><a href="cerca.php" id="cerca">Cerca</a></li>
			<li><a href="album.php" id="album">Album</a></li>
			<li><a href="statistic.php" id="statistic">Statistiche</a></li>
			<li><a href="login.php" id="login">Accedi / registrati</a></li>
			<li class="block"><a href="carrello.php" id="carrello">Carrello</a></li>
			<li><a href="desideri.php" id="desideri">Lista dei desideri</a></li>
			<?php
				if ($band)
				{
					echo '<li><a href="'.$pag.'?band_id='.$_GET["band_id"].'" id="band">Info band</a></li>';
				}
			?>
		</ul>
			
	</nav>
</header>
<script>
	$(document).ready(function(){
		<?php
			echo '$("li a#'.$id_menu.'").attr("class", "active");'."\n";
		?>
	});
</script>