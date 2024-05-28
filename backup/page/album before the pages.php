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
		<title>Album | Metal Inspector</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="CSS/stile.css" />
		<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
		<script src="jquery/include.js"></script>
		<script src="jquery/main.js"></script>
		<script src="javascript/indirizzo.js"></script>
		<?php
		//http://php.net/manual/en/function.mysql-query.php
			include 'php/connect.php';
			$band_id = [];
			$album_id = [];
			$band_name = [];
			$album_name = [];
			$prezzo = [];
			$cont = 0;
			$n_album;
			$link_db = connessione_db();
			if (isset($_GET["album_id"]))
			{
				$album_id_get = mysql_real_escape_string($_GET["album_id"]);
			}
			else
			{
				$album_id_get = 0;
			}
			$Query="select BID, AID, BNome, ATitolo, Prezzo from view_elenco_album order by ATitolo";
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
				$cont ++;
			}
			$n_album = $cont;
			$key;
			$corrispondenza = false;
			foreach ($album_id as $k=>$v)
			{
				if ($album_id_get != 0)
				{
					if ($v == $album_id_get)
					{
						$corrispondenza = true;
						$key = $k;
					}
				}
			}
		?>
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
		<?php
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
		<header id="header">
			<nav style="width: 100%">
				<div style="padding-left: 10px; display: inline;" id="open_menu">&#9776;&nbsp;Menu</div>
				<div style="float: right; display: inline; padding-right: 10px; color: #ffffff; font-size: 1.25rem;">
				<?php
					echo '<div style="display: inline; padding-right: 20px;">'.$_SESSION["username"].'</div>';
					if ($_SESSION["logged"])
					{
					?>
						<form method="post" action="php/login.php" style="display: inline;">
						<input type="hidden" id="indirizzo_2" name="indirizzo"/>
						<input type="submit" value="Logout" class="logout" name="logout"/></form>
					<?php
					}
				?>
				</div>
			</nav>
			<nav id="menu">
			<ul class="link">
				<li><a href="index.php">Home</a></li>
				<li><a href="cerca.php">Cerca</a></li>
				<li><a href="album.php" class="active">Album</a></li>
				<li><a href="login.php">Accedi / registrati</a></li>
				<li><a href="carrello.php">Carrello</a></li>
				<li><a href="desideri.php">Lista dei desideri</a></li>
			</ul>
			</nav>
		</header>
		<section id="banner" style="height: 20rem !important; min-height: 20rem">
			<div class="inner">
				<h1 class="title">
					<?php
						if ($corrispondenza)
						{
							echo $album_name[$key]."\n";
						}
						else
						{
							echo "Elenco album";
						}
					?>
				</h1>
			</div>
		</section>
		<section class="spazio"  style="padding-top: 1em">
			<div class="inner no-width">
				<div class="card">
					<table style="padding-left: 24px; margin-left: auto; margin-right: auto;">
						<caption>
							<header class="titolo">
								<h2>
									<?php
										if ($corrispondenza)
										{
											echo '<a href="band.php?band_id='.$band_id[$key].'" class="band">'.$band_name[$key].'</a>'."\n";
										}
										else
										{
											echo 'Trovati '.$n_album.' album';
										}
									?>
								</h2>
							</header>
						</caption>
						<tbody>
							<?php
								if ($corrispondenza)
								{
									$canzoni = [];
									$cont_canzoni = 0;
									$Query="select CTitolo from view_canzoni where AID = $album_id_get;";
									$result=mysql_query($Query);
									if(!$result) {
											die("Errore della query:".mysql_error());
									}
									while ($row = mysql_fetch_assoc($result)) {
										$canzoni[$cont_canzoni] = $row["CTitolo"];
										$cont_canzoni ++;
									}
							?>
							<tr style="border: none; background-color: transparent;">
								<td style="padding-bottom: 20px; padding-right: 20px; padding-left: 20px;">
									<section>
										<div class="contenitore" style="box-shadow: none;">
											<header>
												<div class="container">
													<?php echo '<img src="img/album_'.$album_id[$key].'.jpg" width="250px"/>'; ?>
												</div>
												<?php echo '<h3><a href="band.php?band_id='.$band_id[$key].'">'.$band_name[$key].'</a></h3>'; ?>
											</header>
											<?php echo '<h3>'.$prezzo[$key].'€</h3>'; ?>
											<h3 style="text-align: left;">Aggiungi album a:</h3>
											<table>
												<tbody>
													<tr style="border: none; background-color: transparent;">
														<td>
															<form method="post" action="php/aggiungi.php" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="carrello"/>
																<?php echo '<input type="hidden" name="album_id" value="'.$album_id[$key].'"/>' ?>
																<input type="submit" value="Carrello" class="main margin_right"/>
															</form>
														</td>
														<td>
															<form method="post" action="php/aggiungi.php" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="desideri"/>
																<?php echo '<input type="hidden" name="album_id" value="'.$album_id[$key].'"/>'; ?>
																<input type="submit" value="Lista desideri" class="margin_left"/>
															</form>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</section>
								</td>
								<td style="width: 421px; vertical-align: top;">
									<section>
										<div class="contenitore" style="box-shadow: none;">
											<header>
												<h2>Lista canzoni</h2>
												<ol class="uppercase" style="width: 100%; list-style-position: outside; list-style-type: decimal;">
													<?php
														foreach ($canzoni as $v)
														{
															echo '<li>'.$v.'</li>'."\n";
														}
													?>
												</ol>
											</header>
											<table>
												<tbody>
													<tr style="border: none; background-color: transparent;">
														<td>
															<form method="post" style="margin-bottom: 0px; width: 301px;">
																<input type="hidden" name="lista" value="carrello"/>
																<input type="hidden" name="album_id" value="0"/>
																<input type="hidden" value="Carrello" class="main"/>
															</form>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</section>
								</td>
							</tr>
								<?php
								}
								else
								{
									/*if (!isset($_GET["pagina"]))
									{
										header ('Location: album.php?pagina=1');
									}*/
									if ($n_album <= 3)
									{
										$val_1 = 1;
									}
									else
									{
										$val_1 = 2;
									}
									$val_2 = 6 - $n_album;
									$n_album_x_ciclo = round ($n_album / 3) + 1;
									// Funzione ROUND: http://php.net/manual/en/function.round.php
									$cont_album = 0;
									for ($x = 0; $x < $n_album_x_ciclo; $x ++)
									{
										$xy = $x * 3;
										echo '<tr style="border: none; background-color: transparent;">'."\n";
										for ($y = 0; $y < 3; $y ++)
										{
											if ($cont_album < $n_album)
											{
												$val = $xy + $y;
												$val_x1 = $xy + $y + 1;
												?>
								<td style="padding-bottom: 20px; padding-right: 20px; padding-left: 20px;">
									<section>
										<div class="contenitore" style="box-shadow: none;">
											<header>
												<?php echo '<a href="album.php?album_id='.$album_id[$val].'">';	?>
													<div class="container">
														<?php echo '<img src="img/album_'.$album_id[$val].'.jpg" width="250px"/>'; ?>
													</div>
												</a>
												<?php echo '<h3><a href="album.php?album_id='.$album_id[$val].'">'.$album_name[$val].'</a><br/>'; ?>
												<?php echo '<a href="band.php?band_id='.$band_id[$val].'">'.$band_name[$val].'</a></h3>'; ?>
											</header>
											<?php echo '<h3>'.$prezzo[$val].'€</h3>'; ?>
											<h3 style="text-align: left;">Aggiungi album a:</h3>
											<table>
												<tbody>
													<tr style="border: none; background-color: transparent;">
														<td>
															<form method="post" action="php/aggiungi.php" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="carrello"/>
																<?php echo '<input type="hidden" name="album_id" value="'.$album_id[$val].'"/>' ?>
																<input type="submit" value="Carrello" class="main margin_right"/>
															</form>
														</td>
														<td>
															<form method="post" action="php/aggiungi.php" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="desideri"/>
																<?php echo '<input type="hidden" name="album_id" value="'.$album_id[$val].'"/>'; ?>
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
										$cont_album ++;
											}
										}
								?>
							</tr>
								<?php
									}
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