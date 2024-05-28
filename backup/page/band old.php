<?php
	session_start ();
	if (!isset($_SESSION["status"]))
	{
		$_SESSION["username"] = "Utente";
		$_SESSION["status"] = false;
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Info band | Metal Inspected</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="CSS/stile.css" />
		<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
		<script src="jquery/include.js"></script>
		<script src="jquery/main.js"></script>
		<script src="javascript/indirizzo.js"></script>
		<style>
			td
			{
				width: 50%;
			}
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
		<?php
			function numero_album ($id)
			{
				$prec = array ($id[0]);
				foreach ($id as $v=> $k)
				{
					$corr = false;
					for ($x = 0; $x < count ($prec); $x ++)
					{
						if ($k == $prec[$x])
						{
							$corr = true;
						}
					}
					if (!$corr)
					{
						$prec[count($prec)] = $k;
						$corr = true;
						echo "corrispondenza";
					}
				}
				return count ($prec);
			}
		?>
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
			$band_id = $_GET["band_id"];
			$album_id = [];
			$nome_band;
			$nome_album = [];
			$nome_artisti = [];
			$nome_strumenti = [];
			$nome_genere;
			$n_canzoni = [];
			
			$cont = 0;
			$Cn=mysql_connect();
			$link=mysql_connect("localhost","root","");
			if(!$link)
					die("Non riesco a connettermi:".mysql_error());
			$db_selected=mysql_select_db("metal",$link);
			if(!$db_selected)
					die("Errore nella selezione del DB".mysql_error());
			mysql_select_db("metal");
			$Query="select BA.nome as BNome, AL.album_id as AID, AL.titolo as ALTitolo, AR.nome as ARNome, ST.nome as STNome, GE.nome as GENome, count(*) as NCanzoni
					from band as BA, album as AL, canzoni as CA, band_genere as BAGE, genere as GE, band_artisti as BAAR, artisti as AR, artisti_strumenti as ARST, strumenti as ST
					where BA.band_id = AL.band_id and
						  BA.band_id = CA.band_id and
						  AL.album_id = CA.album_id and
						  BA.band_id = BAGE.band_id and
						  BAGE.genere_id = GE.genere_id and
						  BA.band_id = BAAR.band_id and
						  BAAR.artista_id = AR.artista_id and
						  AR.artista_id = ARST.artista_id and
						  ARST.strumento_id = ST.strumento_id and
						  BA.band_id = $band_id
					group by STNome, ARNome
					order by ST.strumento_id";
			$result=mysql_query($Query);
			if(!$result) {
					die("Errore della query:".mysql_error());
			}
			while ($row = mysql_fetch_assoc($result)) {
					$album_id [$cont]= $row["AID"];
					$nome_band = $row["BNome"];
					$nome_album [$cont]= $row["ALTitolo"];
					$nome_artisti [$cont]= $row["ARNome"];
					$nome_strumenti [$cont]= $row["STNome"];
					$nome_genere = $row["GENome"];
					$n_canzoni [$cont] = $row["NCanzoni"];
					$prezzo [$cont] = number_format($n_canzoni[$cont] * 0.90, 2, '.', '');
					$cont ++;
				}
			mysql_free_result($result);
			mysql_close();
		?>
		<section id="banner" style="height: 20rem !important; min-height: 20rem;">
			<div class="inner">
				<h1 class="title">
					<?php
						echo $nome_band;
					?>
				</h1>
			</div>
		</section>
		<section class="spazio"  style="padding-top: 1em; padding-bottom: 0;">
			<div class="inner">
				<div class="card" style="margin-bottom: 0px">
					<table style="padding-left: 24px; margin-left: auto; margin-right: auto;">
						<caption>
							<header class="titolo">
							<h2>Genere: 
								<?php
									echo $nome_genere;
								?>
							</h2>
							<h2>Elenco album</h2>
							</header>
						</caption>
						<tbody>
<!--
	padding-left: 100px;
    padding-right: 100px;
-->
							<?php
								for ($out = 0; $out < numero_album($album_id); $out ++)
								{
									echo '<tr style="border: none; background-color: transparent;">';
									echo '<td style="padding-bottom: 20px; padding-right: 20px; padding-left: 20px;">'."\n";
									echo "\t".'<selection>'."\n";
									echo "\t\t".'<div class="contenitore">'."\n";
									echo "\t\t\t".'<header>'."\n";
									echo "\t\t\t\t".'<a href="album.php?album_id='.$album_id[$out].'">'."\n";
									
									echo "\t\t\t\t\t\t".'<img src="img/album_'.$album_id[$out].'.jpg" width="250px"/>'."\n";
									
									echo "\t\t\t\t".'</a>'."\n";
									echo "\t\t\t\t".'<h3><a href="band.php?band_id='.$album_id[$out].'">'.$nome_album[$out].'</a></h3>'."\n";
									echo "\t\t\t".'</header>'."\n";
									echo "\t\t\t".'<h3>'.$prezzo[$out].'€</h3>'."\n";
									echo "\t\t\t".'<h3 style="text-align: left;">Aggiungi album a:</h3>'."\n";
									echo "\t\t\t".'<table>'."\n";
									echo "\t\t\t\t".'<tbody>'."\n";
									echo "\t\t\t\t\t".'<tr style="border: none; background-color: transparent;">'."\n";
									echo "\t\t\t\t\t\t".'<td>'."\n";
									echo "\t\t\t\t\t\t\t".'<form method="post" style="margin-bottom: 0px;">'."\n";
									echo "\t\t\t\t\t\t\t\t".'<input type="hidden" name="lista" value="carrello"/>'."\n";
									echo "\t\t\t\t\t\t\t\t".'<input type="hidden" name="album_id" value="'.$album_id[$out].'"/>'."\n";
									echo "\t\t\t\t\t\t\t\t".'<input type="submit" value="Carrello" class="main margin_right"/>'."\n";
									echo "\t\t\t\t\t\t\t".'</form>'."\n";
									echo "\t\t\t\t\t\t".'</td>'."\n";
									echo "\t\t\t\t\t\t".'<td>'."\n";
									echo "\t\t\t\t\t\t\t".'<form method="post" style="margin-bottom: 0px;">'."\n";
									echo "\t\t\t\t\t\t\t\t".'<input type="hidden" name="lista" value="desideri"/>'."\n";
									echo "\t\t\t\t\t\t\t\t".'<input type="hidden" name="album_id" value="'.$album_id[$out].'"/>'."\n";
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

							?>
<!--							<tr style="border: none; background-color: transparent;">
								<td>
									<section>
										<div class="contenitore">
											<header>
												<a href="album.php">
													<img src="img/album_8.jpg" width="250px"/>
												</a>
												<h3>Alba</h3>
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
																<input type="submit" value="Carrello" class="main margin_2_r"/>
															</form>
														</td>
														<td>
															<form method="post" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="desideri"/>
																<input type="hidden" name="album_id" value="8"/>
																<input type="submit" value="Lista desideri" class="margin_2_l"/>
															</form>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</section>
								</td>
								
								
								
							</tr>-->
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2">
									<table style="padding-left: 24px; margin-left: auto; margin-right: auto;">
										<caption>
											<header class="titolo">
											<h2>Componenti</h2>
											</header>
										</caption>
										<thead>
											<tr style=" background-color: transparent; border-top: none;">
												<th>Nome</th>
												<th>Strumento</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Federica Lanna</td>
												<td>Voce</td>
											</tr>
											<tr>
												<td>Federico Truzzi</td>
												<td>Chitarra, Orchestra</td>
											</tr>
											<tr>
												<td>Lorenzo Costi</td>
												<td>Basso</td>
											</tr>
											<tr>
												<td>Francesco Zanarelli</td>
												<td>Batteria</td>
											</tr>
											<tr>
												<td>Fabrizio Incao</td>
												<td>Chitarra</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</section>
	</body>
</html>
<!--
	<td>
									<section>
										<div class="contenitore">
											<header>
												<a href="#">
													<img src="img/album_9.jpg" width="250px"/>
												</a>
											</header>
											<h3>Enlighten</h3>
											<h3>9.00€</h3>
											<h3 style="text-align: left;">Aggiungi album a:</h3>
											<table>
												<tbody>
													<tr style="border: none; background-color: transparent;">
														<td>
															<form method="post" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="carrello"/>
																<input type="hidden" name="album_id" value="2"/>
																<input type="submit" value="Carrello" class="main margin_2_r"/>
															</form>
														</td>
														<td>
															<form method="post" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="desideri"/>
																<input type="hidden" name="album_id" value="2"/>
																<input type="submit" value="Lista desideri" class="margin_2_l"/>
															</form>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</section>
								</td>
-->