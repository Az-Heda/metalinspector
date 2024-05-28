<?php
	session_start();
	if (!isset($_SESSION["status"]))
	{
		$_SESSION["username"] = " ";
		$_SESSION["status"] = false;
	}
?>
<!doctype html>
<html>
	<head>
		<title>Info album | Metal Inspected</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="CSS/stile.css" />
		<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
		<script src="jquery/include.js"></script>
		<script src="jquery/main.js"></script>
		<script src="javascript/indirizzo.js"></script>
		<style>
			a.band {
				text-decoration: none;
			}
			a.band:hover {
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
					<li><a href="index.php">Home</a></li>
					<li><a href="cerca.php">Cerca</a></li>
					<li><a href="login.php">Accedi / registrati</a></li>
					<li><a href="carrello.php">Carrello</a></li>
					<li><a href="desideri.php">Lista dei desideri</a></li>
				</ul>
			</nav>
		</header>
		<?php
			if (!isset($_GET["album_id"]))
			{
				header ('Location: album_all.php');
			}
			$album_id = $_GET["album_id"];
			$nome_band;
			$nome_album;
			$band_id;
			$canzoni = [];
			$cont = 0;
			$Cn=mysql_connect();
			$link=mysql_connect("localhost","root","");
			if(!$link)
					die("Non riesco a connettermi:".mysql_error());
			$db_selected=mysql_select_db("metal",$link);
			if(!$db_selected)
					die("Errore nella selezione del DB".mysql_error());
			mysql_select_db("metal");
			$Query="select A.titolo as ATitolo, B.band_Id as BID, B.nome as BNome, C.titolo as CTitolo
					from album as A, band as B, canzoni as C
					where A.album_id = C.album_id and
						  C.band_id = B.band_id and
						  B.band_id = A.band_id and
						  A.album_id = $album_id
					order by C.canzone_id asc";
			$result=mysql_query($Query);
			if(!$result) {
					die("Errore della query:".mysql_error());
			}
			while ($row = mysql_fetch_assoc($result)) {
					$band_id = $row["BID"];
					$nome_band = $row["BNome"];
					$nome_album = $row["ATitolo"];
					$canzoni [$cont] = $row["CTitolo"];
					$cont ++;
				}
			$prezzo = $cont * 0.90;
			mysql_free_result($result);
			mysql_close();
		?>
		<section id="banner" style="height: 20rem !important; min-height: 20rem">
			<div class="inner">
				<h1 class="title">
					<?php
						echo $nome_album;
					?>
				</h1>
			</div>
		</section>
		<section class="spazio" style="padding-top: 1em">
			<div class="inner">
				<div class="card">
					<table style="padding-left: 24px; margin-left: auto; margin-right: auto;">
						<caption>
							<header class="titolo">
							<h2>
								<?php
									echo '<a href="band.php?band_id='.$band_id.'" class="band">'.$nome_band.'</a>'."\n";
								?>
							</h2>
<!--							<h3>
								<a href="band.php" class="band">Sleeping Romance</a>
							</h3>-->
							</header>
						</caption>
						<tbody>
							<tr style="border: none; background-color: transparent;">
								<td id="get">
									<section>
										<div class="contenitore" style="box-shadow: none;">
											<header>
												<?php
													echo '<img src="img/album_'.$album_id.'.jpg" width="250px"/>'."\n";
												?>
											</header>
											<h3>
												<?php
													echo number_format($prezzo, 2, '.', '').'€';
												?>
											</h3>
											<h3 style="text-align: left;">Aggiungi album a:</h3>
											<table>
												<tbody>
													<tr style="border: none; background-color: transparent;">
														<td> 
															<form method="post" action="php/aggiungi.php" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="carrello"/>
																<?php
																	echo '<input type="hidden" name="album_id" value="'.$album_id.'"/>'."\n";
																?>
																<input type="submit" value="Carrello" class="main"/>
															</form>
														</td>
														<td>
															<form method="post" action="php/aggiungi.php" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="desideri"/>
																<?php
																	echo '<input type="hidden" name="album_id" value="'.$album_id.'"/>'."\n";
																?>
																<input type="submit" value="Lista desideri">
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
														<td >
															<form method="post" style="margin-bottom: 0px; width: 301px;">
																<input type="hidden" name="lista" value="carrello"/>
																<input type="hidden" name="album_id" value="8"/>
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
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</body>
</html>
</html>