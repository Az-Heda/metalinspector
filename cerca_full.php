<?php
	session_start();
	if (!isset($_SESSION["logged"]))
	{
		$_SESSION["username"] = " ";
		$_SESSION["logged"] = false;
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
				width: 33.3333333%;
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
					if ($_SESSION["logged"])
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
					<li><a href="album.php">Album</a></li>
					<li><a href="login.php">Accedi / registrati</a></li>
					<li><a href="carrello.php">Carrello</a></li>
					<li><a href="desideri.php">Lista dei desideri</a></li>
				</ul>
			</nav>
		</header>
		<?php
			$album_id = [];
			$album_nome = [];
			$band_id = [];
			$band_nome = [];
			$nome_canzone = [];
			$cont = 0;
			$Cn=mysql_connect();
			$link=mysql_connect("localhost","root","");
			if(!$link)
					die("Non riesco a connettermi:".mysql_error());
			$db_selected=mysql_select_db("metal",$link);
			if(!$db_selected)
					die("Errore nella selezione del DB".mysql_error());
			mysql_select_db("metal");
			$Query="select B.band_id as BID, B.nome as BNome, A.album_id as AID, A.titolo as ATitolo, C.titolo as CTitolo
					from band as B, album as A, canzoni as C
					where B.band_id = A.band_id and C.album_id = A.album_id
					order by B.nome, A.titolo, C.canzone_id";
			$result=mysql_query($Query);
			if(!$result) {
					die("Errore della query:".mysql_error());
			}
			while ($row = mysql_fetch_assoc($result)) {
					$band_id[$cont] = $row["BID"];
					$album_id[$cont] = $row["AID"];
					$band_nome[$cont] = $row["BNome"];
					$album_nome[$cont] = $row["ATitolo"];
					$nome_canzone[$cont] = $row["CTitolo"];
					$cont ++;
				}
			mysql_free_result($result);
			mysql_close();
		?>
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
								<th>Canzoni</th>
							</tr>
						</thead>
						<tbody id="campi">	
							<?php
								for ($search = 0; $search < count($band_id); $search ++)
								{
									echo '<tr>'."\n";
									echo "\t".'<td><a href="band.php?band_id='.$band_id[$search].'">'.$band_nome[$search].'</a></td>';
									echo "\t".'<td><a href="album.php?album_id='.$album_id[$search].'">'.$album_nome[$search].'</a></td>';
									echo "\t".'<td>'.$nome_canzone[$search].'</td>';
									echo '</tr>';
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</body>
</html>