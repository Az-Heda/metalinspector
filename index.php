<?php
	session_start();
	if (!isset($_SESSION["logged"]))
	{
		$_SESSION["username"] = " ";
		$_SESSION["logged"] = false;
	}
	if (isset($_SESSION["pagina_prec"]))
	{
		unset($_SESSION["pagina_prec"]);
	}
	if (isset($_SESSION["login_error"]))
	{
		unset($_SESSION["login_error"]);
	}
?>
<!doctype html>
<html>
	<head>
		<title>Metal Inspector</title>
		<meta charset="utf-8" />
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
	<body>
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
		?>
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
								<h2>Album che ti consigliamo</h2>
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
								$Query="select BID, AID, BNome, ATitolo, Prezzo from view_album_in_index order by ATitolo;";
								$result=mysql_query($Query);
								if(!$result) {
										die("Errore della query:".mysql_error());
								}
								while ($row = mysql_fetch_assoc($result)) {
										$band_id[$cont] = $row["BID"];
										$album_id[$cont] = $row["AID"];
										$band_name[$cont] = $row["BNome"];
										$album_name[$cont] = $row["ATitolo"];
										$prezzo[$cont] = $row["Prezzo"];
										$cont++;
									}
									$n_album = $cont;
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
							?>
							<tr style="border: none; background-color: transparent;">
								<?php
									for ($y = 0; $y < 3; $y ++)
									{
										$val = $xy + $y;
										$val_x1 = $xy + $y + 1;
								?>
										
										<td style="padding-bottom: 20px; padding-right: 20px; padding-left: 20px;">
											<section>
												<div class="contenitore">
													<header>
														<?php
															echo '<a href="album.php?album_id='.$album_id[$val].'">';
														?>
															<div class="container">
															<?php
																echo '<img src="img/album_'.$album_id[$val].'.jpg" width="250px" id="img_'.$val_x1.'"/>'."\n";
																echo '<div class="center_'.$val_x1.'">'.$album_name[$val].'</div>';
															?>
																
															</div>
														</a>
														<?php
															echo '<h3><a href="band.php?band_id='.$band_id[$val].'">'.$band_name[$val].'</a></h3>';
														?>
													</header>
													<?php
														echo '<h3>'.$prezzo[$val].'€</h3>';
													?>
													<h3 style="text-align: left;">Aggiungi album a:</h3>
													<table>
														<tbody>
															<tr style="border: none; background-color: transparent;">
																<td>
																	<form method="post" action="php/aggiungi.php" style="margin-bottom: 0px;">
																		<input type="hidden" name="lista" value="carrello"/>
																		<?php
																			echo '<input type="hidden" name="album_id" value="'.$album_id[$val].'"/>'
																		?>
																		<input type="submit" value="Carrello" class="main margin_right"/>
																	</form>
																</td>
																<td>
																	<form method="post" action="php/aggiungi.php" style="margin-bottom: 0px;">
																		<input type="hidden" name="lista" value="desideri"/>
																		<?php
																			echo '<input type="hidden" name="album_id" value="'.$album_id[$val].'"/>';
																		?>
																		<input type="submit" value="Lista desideri" class="margin_left"/>
																	</form>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</section>
										</td>
								<?php
									}
								?>
									</tr>
							<?php
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
							$Query="select AID, BID, ATitolo, BNome, Contatore from view_like;";
							$result=mysql_query($Query);
							if(!$result) {
									die("Errore della query:".mysql_error());
							}
							while ($row = mysql_fetch_assoc($result)) {
									$band_id_2[$cont_2] = $row["BID"];
									$album_id_2[$cont_2] = $row["AID"];
									$band_name_2[$cont_2] = $row["BNome"];
									$album_name_2[$cont_2] = $row["ATitolo"];
									$like_2[$cont_2] = $row["Contatore"];
									$cont_2 ++;
								}
						?>
						<thead class="vertical">
							<tr>
								<th>Copertina</th>
								<th>Band</th>
								<th>Album</th>
								<th>Like</th>
							</tr>
						</thead>
						<tbody class="vertical">
						<?php
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
		<?php
			mysql_close($link_db);
		?>
	</body>
</html>