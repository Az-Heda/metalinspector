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
		<title>Metal Inspector</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="CSS/stile.css" />
		<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
		<script src="jquery/include.js"></script>
		<script src="jquery/main.js"></script>
		<script src="jquery/titoli_album.js"></script>
		<script src="javascript/indirizzo.js"></script>
		<style>	
			a {
				text-decoration: none;
			}
			a:hover {
				text-decoration: underline;
			}
			input[type="submit"].logout {
				color: #ffffff !important;
				box-shadow: inset 0 0 0 1px #ffffff;
			}
		</style>
	</head>
	<body onload="indirizzo_2();">
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
				<li><a href="index.php" class="active">Home</a></li>
				<li><a href="cerca.php">Cerca</a></li>
				<li><a href="login.php">Accedi / registrati</a></li>
				<li><a href="carrello.php">Carrello</a></li>
				<li><a href="desideri.php">Lista dei desideri</a></li>
			</ul>
			</nav>
		</header>
<!--		<section id="banner">
			<div class="inner">
				<h1 class="title">Metal Inspector</h1>
				<p>Metal inspector, il sito per gli amanti del metallo</p>
			</div>
		</section>-->
		<section id="banner" style="height: 20rem !important; min-height: 20rem">
			<div class="inner">
				<h1 class="title">Metal Inspector</h1>
				<p>Metal Inspector, Il sito per gli amanti del metallo</p>
			</div>
		</section>
		<section class="spazio"  style="padding-top: 1em">
			<div class="inner no-width">
				<div class="card">
					<table style="padding-left: 24px; margin-left: auto; margin-right: auto;">
						<caption>
							<header class="titolo">
								<h2>Novità</h2>
							</header>
						</caption>
						<tbody>
							<?php
							//http://php.net/manual/en/function.mysql-query.php
								$band_id = [];
								$album_id = [];
								$band_name = [];
								$album_name = [];
								$prezzo = [];
								$cont = 0;
								$n_album;
								
								$Cn=mysql_connect();
								$link=mysql_connect("localhost","root","");
								if(!$link)
										die("Non riesco a connettermi:".mysql_error());
								$db_selected=mysql_select_db("metal",$link);
								if(!$db_selected)
										die("Errore nella selezione del DB".mysql_error());
								mysql_select_db("metal");
								$Query="select B.band_id as Band_Id, B.nome as Band_nome, A.album_id as Album_Id, A.titolo as Album_titolo, count(*)*0.90 as Prezzo
										from album as A, canzoni as C, band as B
										where A.album_id = C.album_id and B.band_id = A.band_id
										group by Album_Id
										ORDER BY A.Album_Id DESC limit 6;";
								$result=mysql_query($Query);
								if(!$result) {
										die("Errore della query:".mysql_error());
								}
								while ($row = mysql_fetch_assoc($result)) {
										$band_id[$cont] = $row["Band_Id"];
										$album_id[$cont] = $row["Album_Id"];
										$band_name[$cont] = $row["Band_nome"];
										$album_name[$cont] = $row["Album_titolo"];
										$prezzo[$cont] = $row["Prezzo"];
										$cont ++;
										/*
												4-Insomnium-4-One For Sorrow-9.00
												4-Insomnium-3-Shadows Of The Dying Sun-9.00
												2-Arch Enemy-2-Will To Power-10.80
												3-Iwrestledabearonce-1-Hail Mary-12.60
										*/
									}
									$n_album = $cont;
								mysql_free_result($result);
								mysql_close();
								
								if ($n_album <= 3)
								{
									$val_1 = 1;
								}
								else
								{
									$val_1 = 2;
								}
								$val_2 = 6 - $n_album;
								for ($x = 0; $x < 2; $x ++)
								{
									if ($x == 0)
									{
										$xy = 0;
									}
									if ($x == 1)
									{
										$xy = 3;
									}
									echo '<tr style="border: none; background-color: transparent;">'."\n";
									for ($y = 0; $y < 3; $y ++)
									{
										$val = $xy + $y;
										$val_x1 = $xy + $y + 1;
										echo '<td style="padding-bottom: 20px; padding-right: 20px; padding-left: 20px;">'."\n";
										echo "\t".'<selection>'."\n";
										echo "\t\t".'<div class="contenitore">'."\n";
										echo "\t\t\t".'<header>'."\n";
										echo "\t\t\t\t".'<a href="album.php?album_id='.$album_id[$val].'">'."\n";
										echo "\t\t\t\t\t".'<div class="container">'."\n";
										echo "\t\t\t\t\t\t".'<img src="img/album_'.$album_id[$val].'.jpg" width="250px" id="img_'.$val_x1.'"/>'."\n";
										echo "\t\t\t\t\t\t".'<div class="center_'.$val_x1.'">'.$album_name[$val].'</div>'."\n";
										echo "\t\t\t\t\t".'</div>'."\n";
										echo "\t\t\t\t".'</a>'."\n";
										echo "\t\t\t\t".'<h3><a href="band.php?band_id='.$band_id[$val].'">'.$band_name[$val].'</a></h3>'."\n";
										echo "\t\t\t".'</header>'."\n";
										echo "\t\t\t".'<h3>'.$prezzo[$val].'€</h3>'."\n";
										echo "\t\t\t".'<h3 style="text-align: left;">Aggiungi album a:</h3>'."\n";
										echo "\t\t\t".'<table>'."\n";
										echo "\t\t\t\t".'<tbody>'."\n";
										echo "\t\t\t\t\t".'<tr style="border: none; background-color: transparent;">'."\n";
										echo "\t\t\t\t\t\t".'<td>'."\n";
										echo "\t\t\t\t\t\t\t".'<form method="post" style="margin-bottom: 0px;">'."\n";
										echo "\t\t\t\t\t\t\t\t".'<input type="hidden" name="lista" value="carrello"/>'."\n";
										echo "\t\t\t\t\t\t\t\t".'<input type="hidden" name="album_id" value="'.$album_id[$val].'"/>'."\n";
										echo "\t\t\t\t\t\t\t\t".'<input type="submit" value="Carrello" class="main margin_right"/>'."\n";
										echo "\t\t\t\t\t\t\t".'</form>'."\n";
										echo "\t\t\t\t\t\t".'</td>'."\n";
										echo "\t\t\t\t\t\t".'<td>'."\n";
										echo "\t\t\t\t\t\t\t".'<form method="post" style="margin-bottom: 0px;">'."\n";
										echo "\t\t\t\t\t\t\t\t".'<input type="hidden" name="lista" value="desideri"/>'."\n";
										echo "\t\t\t\t\t\t\t\t".'<input type="hidden" name="album_id" value="'.$album_id[$val].'"/>'."\n";
										echo "\t\t\t\t\t\t\t\t".'<input type="submit" value="Lista desideri" class="margin_left"/>'."\n";
										echo "\t\t\t\t\t\t\t".'</form>'."\n";
										echo "\t\t\t\t\t\t".'</td>'."\n";
										echo "\t\t\t\t\t".'</tr>'."\n";
										echo "\t\t\t\t".'</tbody>'."\n";
										echo "\t\t\t".'</table>'."\n";
										echo "\t\t".'</div>'."\n";
										echo "\t".'</section>'."\n";
										echo '</td>'."\n";
									}
									echo '</tr>';
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
		<section id="banner" style="height: 20rem !important; min-height: 20rem">
			<div class="inner">
				<h1 class="title">Gli album migliori</h1>
			</div>
		</section>
		<section id="main" class="spazio">
			<div class="inner">
				<div class="spazio_tabella">
					<table>
						<?php
							
							$band_id_2 = [];
							$album_id_2 = [];
							$band_name_2 = [];
							$album_name_2 = [];
							$like_2 = [];
							$cont_2 = 0;
							
							$Cn=mysql_connect();
							$link=mysql_connect("localhost","root","");
							if(!$link)
									die("Non riesco a connettermi:".mysql_error());
							$db_selected=mysql_select_db("metal",$link);
							if(!$db_selected)
									die("Errore nella selezione del DB".mysql_error());
							mysql_select_db("metal");
							$Query="select A.album_id as AID, A.titolo as ATitolo, B.band_id as BID, B.nome as BNome, count(*) as MiPiace
									from like_table as LT, album as A, band as B
									where LT.attivo = 's' and
										  A.album_id = LT.album_id and
										  B.band_id = A.band_id
									group by LT.album_id
									order by MiPiace desc
									limit 5;";
							$result_2=mysql_query($Query);
							if(!$result_2) {
									die("Errore della query:".mysql_error());
							}
							while ($row_2 = mysql_fetch_assoc($result_2)) {
									$band_id_2[$cont_2] = $row_2["BID"];
									$album_id_2[$cont_2] = $row_2["AID"];
									$band_name_2[$cont_2] = $row_2["BNome"];
									$album_name_2[$cont_2] = $row_2["ATitolo"];
									$like_2[$cont_2] = $row_2["MiPiace"];
									$cont_2 ++;
								}
							mysql_close();
							
							echo '<thead class="vertical">'."\n";
							echo "\t".'<tr>'."\n";
							echo "\t\t".'<th>Copertina</th>'."\n";
							echo "\t\t".'<th>Album</th>'."\n";
							echo "\t\t".'<th>Band</th>'."\n";
							echo "\t\t".'<th>Like</th>'."\n";
							echo "\t".'</tr>'."\n";
							echo '</thead>'."\n";
							echo '<tbody class="vertical">'."\n";
							for ($ciclo_like = 0; $ciclo_like < 5; $ciclo_like ++)
							{
								echo "\t".'<tr>'."\n";
								echo "\t\t".'<td><img src="img/album_'.$album_id_2[$ciclo_like].'.jpg"/></td>'."\n";
								echo "\t\t".'<td><a href="band.php?band_id='.$band_id_2[$ciclo_like].'">'.$band_name_2[$ciclo_like].'</a></td>'."\n";
								echo "\t\t".'<td><a href="album.php?album_id='.$album_id_2[$ciclo_like].'">'.$album_name_2[$ciclo_like].'</a></td>'."\n";
								echo "\t\t".'<td>'.$like_2[$ciclo_like].'</td>'."\n";
								echo "\t".'</tr>'."\n";
							}
						?>
					</table>
				</div>
			</div>
		</section>
	</body>
</html>