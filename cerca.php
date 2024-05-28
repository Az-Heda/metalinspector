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
	<body onload="document.getElementById('ricerca').focus();">
		<?php
			include 'php/connect.php';
			include 'php/funzioni.php';
			require 'php/menu.php';
			$link_db = connessione_db();
			switch ($link_db)
			{
				case -1:
					die("Non riesco a connettermi:".mysql_error());
					break;
				case -2:
					die("Errore nella selezione del DB".mysql_error());
					break;
			}
			$album_id = [];
			$album_nome = [];
			$band_id = [];
			$band_nome = [];
			$cont = 0;
			$Query="select BID, BNome, AID, ATitolo from view_in_cerca";
			$result=mysql_query($Query);
			if(!$result) {
					die("Errore della query:".mysql_error());
			}
			while ($row = mysql_fetch_assoc($result)) {
					$band_id[$cont] = $row["BID"];
					$album_id[$cont] = $row["AID"];
					$band_nome[$cont] = $row["BNome"];
					$album_nome[$cont] = $row["ATitolo"];
					$cont ++;
				}
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
							</tr>
						</thead>
						<tbody id="campi">	
							<?php
								for ($search = 0; $search < count($band_id); $search ++)
								{
									echo '<tr>'."\n";
									echo "\t".'<td><a href="band.php?band_id='.$band_id[$search].'">'.$band_nome[$search].'</a></td>';
									echo "\t".'<td><a href="album.php?album_id='.$album_id[$search].'">'.$album_nome[$search].'</a></td>';
									echo '</tr>';
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
		<?php
			mysql_close($link_db);
		?>
	</body>
</html>