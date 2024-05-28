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
		<style>	
			a {
				text-decoration: none;
			}
			a:hover {
				text-decoration: underline;
			}
		</style>
	</head>
	<body>
		<header id="header">
			<nav>
				<div style="padding-left: 10px;" id="open_menu">&#9776;&nbsp;Menu</div>
			</nav>
			<nav id="menu">
			<ul class="link">
				<li><a href="index.php" class="active">Home</a></li>
				<li><a href="cerca.html">Cerca</a></li>
				<li><a href="login.php">Accedi / registrati</a></li>
				<li><a href="carrello.html">Carrello</a></li>
				<li><a href="desideri.html">Lista dei desideri</a></li>
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
							<!--<tr style="border: none; background-color: transparent;">
								<td>
									<section>
										<div class="contenitore">
											<header>
												<a href="album.html">
													<div class="container">
														<img src="img/album_8.jpg" width="250px" id="img_1"/>
														<div class="center_1">Alba</div>
													</div>
												</a>
												<h3><a href="band.html">Sleeping Romance</a></h3>
											</header>
											<h3>9.00€</h3>
											<h3 style="text-align: left;">Aggiungi album a:</h3>
											<table>
												<tbody>
													<tr style="border: none; background-color: transparent;">
														<td>
															<form method="post" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="carrello"/>
																<input type="hidden" name="album_id" value="8"/>
																<input type="submit" value="Carrello" class="main margin_right"/>
															</form>
														</td>
														<td>
															<form method="post" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="desideri"/>
																<input type="hidden" name="album_id" value="8"/>
																<input type="submit" value="Lista desideri" class="margin_left"/>
															</form>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</section>
								</td>
								<td>
									<section>
										<div class="contenitore">
											<header>
												<a href="temp/album_id_12.html">
													<div class="container">
														<img src="img/album_12.jpg" width="250px" id="img_2"/>
														<div class="center_2">Heart Of The Hurricane</div>
													</div>
												</a>
												<h3><a href="temp/band_id_12.html">Beyond The Black</a></h3>
											</header>
											<h3>14.40€</h3>
											<h3 style="text-align: left;">Aggiungi album a:</h3>
											<table>
												<tbody>
													<tr style="border: none; background-color: transparent;">
														<td>
															<form method="post" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="carrello"/>
																<input type="hidden" name="album_id" value="2"/>
																<input type="submit" value="Carrello" class="main margin_right"/>
															</form>
														</td>
														<td>
															<form method="post" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="desideri"/>
																<input type="hidden" name="album_id" value="2"/>
																<input type="submit" value="Lista desideri" class="margin_left"/>
															</form>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</section>
								</td>
								<td>
									<section>
										<div class="contenitore">
											<header>
												<a href="temp/album_id_6.html">
													<div class="container">
														<img src="img/album_6.jpg" width="250px" id="img_3"/>
														<div class="center_3">Hail Mary</div>
													</div>
												</a>
												<h3><a href="temp/band_id_6.html">Iwrestledabearonce</a></h3>
											</header>
											<h3>12.60€</h3>
											<h3 style="text-align: left;">Aggiungi album a:</h3>
											<table>
												<tbody>
													<tr style="border: none; background-color: transparent;">
														<td>
															<form method="post" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="carrello"/>
																<input type="hidden" name="album_id" value="6"/>
																<input type="submit" value="Carrello" class="main margin_right"/>
															</form>
														</td>
														<td>
															<form method="post" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="desideri"/>
																<input type="hidden" name="album_id" value="6"/>
																<input type="submit" value="Lista desideri" class="margin_left"/>
															</form>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</section>
								</td>
							</tr>
							<tr style="border: none; background-color: transparent;">
								<td>
									<section>
										<div class="contenitore">
											<header>
												<a href="temp/album_id_3.html">
													<div class="container">
														<img src="img/album_3.jpg" width="250px" id="img_4"/>
														<div class="center_4">The Feeding Of Cruelty</div>
													</div>
												</a>
												<h3><a href="temp/band_id_3.html">Among Gods</a></h3>
											</header>
											<h3>9.00€</h3>
											<h3 style="text-align: left;">Aggiungi album a:</h3>
											<table>
												<tbody>
													<tr style="border: none; background-color: transparent;">
														<td>
															<form method="post" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="carrello"/>
																<input type="hidden" name="album_id" value="3"/>
																<input type="submit" value="Carrello" class="main margin_right"/>
															</form>
														</td>
														<td>
															<form method="post" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="desideri"/>
																<input type="hidden" name="album_id" value="3"/>
																<input type="submit" value="Lista desideri" class="margin_left"/>
															</form>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</section>
								</td>
								<td>
									<section>
										<div class="contenitore">
											<header>
												<a href="temp/album_id_4.html">
													<div class="container">
														<img src="img/album_4.jpg" width="250px" id="img_5"/>
														<div class="center_5">Shadows Of The Dying Sun</div>
													</div>
												</a>
												<h3><a href="temp/band_id_4.html">Insomnium</a></h3>
											</header>
											<h3>9.00€</h3>
											<h3 style="text-align: left;">Aggiungi album a:</h3>
											<table>
												<tbody>
													<tr style="border: none; background-color: transparent;">
														<td>
															<form method="post" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="carrello"/>
																<input type="hidden" name="album_id" value="4"/>
																<input type="submit" value="Carrello" class="main margin_right"/>
															</form>
														</td>
														<td>
															<form method="post" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="desideri"/>
																<input type="hidden" name="album_id" value="4"/>
																<input type="submit" value="Lista desideri" class="margin_left"/>
															</form>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</section>
								</td>
								<td>
									<section style="height: 100%">
										<div class="contenitore">
											<header>
												<a href="temp/album_id_13.html">
													<div class="container">
														<img src="img/album_13.jpeg" width="250px;" id="img_6"/>
														<div class="center_6">Dear Desolation</div>
													</div>
												</a>
												<h3><a href="temp/band_id_13.html">Thy Art Is Murder</a></h3>
											</header>
											<h3>9.00€</h3>
											<h3 style="text-align: left;">Aggiungi album a:</h3>
											<table>
												<tbody>
													<tr style="border: none; background-color: transparent;">
														<td>
															<form method="post" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="carrello"/>
																<input type="hidden" name="album_id" value="1"/>
																<input type="submit" value="Carrello" class="main margin_right"/>
															</form>
														</td>
														<td>
															<form method="post" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="desideri"/>
																<input type="hidden" name="album_id" value="1"/>
																<input type="submit" value="Lista desideri" class="margin_left"/>
															</form>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</section>
								</td>
							</tr>-->
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
									//Qui
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
	echo "\t\t\t\t\t\t\t\t".'<input type="submit" value="Carrello" class="primary margin_2_r"/>'."\n";
	echo "\t\t\t\t\t\t\t".'</form>'."\n";
	echo "\t\t\t\t\t\t".'</td>'."\n";
	echo "\t\t\t\t\t\t".'<td>'."\n";
	echo "\t\t\t\t\t\t\t".'<form method="post" style="margin-bottom: 0px;">'."\n";
	echo "\t\t\t\t\t\t\t\t".'<input type="hidden" name="lista" value="desideri"/>'."\n";
	echo "\t\t\t\t\t\t\t\t".'<input type="hidden" name="album_id" value="'.$album_id[$val].'"/>'."\n";
	echo "\t\t\t\t\t\t\t\t".'<input type="submit" value="Lista desideri" class="margin_2_l"/>'."\n";
	echo "\t\t\t\t\t\t\t".'</form>'."\n";
	echo "\t\t\t\t\t\t".'</td>'."\n";
	echo "\t\t\t\t\t".'</tr>'."\n";
	echo "\t\t\t\t".'</tbody>'."\n";
	echo "\t\t\t".'</table>'."\n";
	echo "\t\t".'</div>'."\n";
	echo "\t".'</section>'."\n";
	echo '</td>'."\n";
}
									//Qui
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
						<thead class="vertical">
							<tr>
								<th>Copertina</th>
								<th>Band</th>
								<th>Album</th>
								<th>Like</th>
							</tr>
						</thead>
						<tbody class="vertical">
							<tr>
								<td><img src="img/album_8.jpg"/></td>
								<td><a href="band.html">Sleeping Romance</a></td>
								<td><a href="album.html">Alba</a></td>
								<td>22</td>
							</tr>
							<tr >
								<td><img src="img/album_12.jpg"/></td>
								<td><a href="temp/band_id_12.html">Beyond The Black</a></td>
								<td><a href="temp/album_id_12.html">Heart Of The Hurricane</a></td>
								<td>19</td>
							</tr>
							<tr>
								<td><img src="img/album_3.jpg"/></td>
								<td><a href="temp/band_id_13.html">Among Gods</a></td>
								<td><a href="temp/album_id_13.html">The Feeding Of Cruelty</a></td>
								<td>17</td>
							</tr>
							<tr>
								<td><img src="img/album_4.jpg"/></td>
								<td><a href="temp/band_id_4.html">Insomnium</a></td>
								<td><a href="temp/album_id_4.html">Shadows Of The Dying Sun</a></td>
								<td>14</td>
							</tr>
							<tr>
								<td><img src="img/album_6.jpg"/></td>
								<td><a href="temp/band_id_6.html">Iwrestledabearonce</a></td>
								<td><a href="temp/album_id_6.html">Hail Mary</a></td>
								<td>13</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</body>
</html>