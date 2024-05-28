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
		<meta charset="utf-8" />
		<link rel="stylesheet" href="CSS/stile.css" />
		<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
		<script src="jquery/include.js"></script>
		<script src="jquery/main.js"></script>
		<script src="javascript/indirizzo.js"></script>
		<?php
		//http://php.net/manual/en/function.mysql-query.php
			include 'php/funzioni.php';
			include 'php/connect.php';
			$band_id = [];
			$album_id = [];
			$band_name = [];
			$album_name = [];
			$prezzo = [];
			$cont = 0;
			$n_album = 0;
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
			if (isset($_GET["album_id"]))
			{
				echo '<title>'.$band_name[$key].': '.$album_name[$key].' | Metal Inspector</title>';
			}
			else
			{
				echo '<title>Elenco album | Metal Inspector</title>';
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
			a.pagine, select.pagine {
				border: #aaaaaa 1px solid;
				margin-right: 5px;
				margin-left: 5px;
				padding-left: 5px;
				padding-right: 5px;
				display: inline;
			}
		</style>
	</head>
	<body>
		<?php 
			require 'php/menu.php';
		 ?>
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
											//echo 'Trovati '.$n_album.' album';
											echo "Pagina <b>".$_GET["pagina"]."</b>";
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
									$lyrics = [];
									$cont_canzoni = 0;
									//$Query="select CTitolo from view_canzoni where AID = $album_id_get;";
									/*$Query="select C.titolo as CTitolo, C.canzone_id as CID, A.titolo as ATitolo, A.album_id as AID, C.lyrics as Lyrics
											from canzoni_test as C, album as A
											where C.album_id = A.album_id and
												  A.album_id = $album_id_get
											order by C.canzone_id asc";*/
									$Query="select CTitolo, CID, ATitolo, AID, Lyrics
											from view_canzoni
											where AID = $album_id_get
											order by CID";
									$result=mysql_query($Query);
									if(!$result) {
											die("Errore della query:".mysql_error());
									}
									while ($row = mysql_fetch_assoc($result)) {
										$canzoni[$cont_canzoni] = $row["CTitolo"];
										$lyrics[$cont_canzoni] = $row["Lyrics"];
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
														for ($v = 0; $v < count($canzoni); $v ++)
														{
															if ($lyrics[$v] == '')
															{
																echo '<li>'.$canzoni[$v].'</li>'."\n";
															}
															else
															{
																echo '<li><a href="'.$lyrics[$v].'" target="_blank">'.$canzoni[$v].'</a></li>'."\n";
															}
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
									if (!isset($_GET["pagina"]) or $_GET["pagina"] <= 0)
									{
										header ('Location: album.php?pagina=1');
									}
									else
									{
										if ($_GET["pagina"] > n_pagine($n_album))
										{
											header ('Location: album.php?pagina='.n_pagine($n_album));
										}
										$pag = $_GET["pagina"];
										$album_fine = ($pag * 9) - 1;
										$album_inizio = ($pag - 1) * 9;
										//echo "Gli album vanno da $album_inizio a $album_fine<br/>";
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
										$cont_album = $album_inizio;
										$divisione = round($album_fine/3);
										$max = $divisione * $pag;
										//echo "Divisione. $divisione<br/>";
										$val = $album_inizio -1 ;
										//echo "N_ALBUM: ".count($album_id)."<br/>";
										for ($x = $album_inizio; $x < val_album_max($album_inizio, abs(count($album_id)-$album_fine)+$album_inizio+2); $x ++)
										{
											echo '<tr style="border: none; background-color: transparent;">'."\n";
											
											for ($y = 0; $y < 3; $y ++)
											{
												$test = $cont_album;
												//echo "--> if (".$test." < ".count($album_id).")<br/>";
												if ($cont_album < count($album_id))
												{

														$val +=1;
														//echo "CONT_ALBUM: $cont_album, VAL: $val<br/>";
										
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
									}
								?>
						</tbody>
						<?php
							if(!isset($_GET["album_id"]))
							{
						?>
						<tfoot>
							<tr>
								<td colspan="2">
								<td style="text-align: center">
									<?php
										/*for ($pag = 0; $pag < n_pagine($n_album); $pag++)
										{
											$num_pag = $pag + 1;
											echo '<a href="album.php?pagina='.$num_pag.'">'.$num_pag.'</a>';
										}*/
										$pag_attuale = $_GET["pagina"];
										$prossima = $pag_attuale + 1;
										$precedente = $pag_attuale - 1;
									?>
									<table style="width: 70%; margin-left: auto; margin-right: auto">
										<tbody>
											<tr style="border: none; background-color: transparent;">
												<td>
													<?php
														echo '<a href="album.php?pagina='.limite_pagine($precedente, 1, n_pagine($n_album)).'" class="pagine"><<</a>';
													?>
												</td>
												<td>
													<a href="album.php?pagina=1" class="pagine">1</a>
												</td>
												<td>
													<a href="album.php?pagina=2" class="pagine">2</a>
												</td>
												<td>
													<form method="get" id="select_pagine">
														<select name="pagina" onchange="document.getElementById('select_pagine').submit();" class="pagine">
															<?php
																if ($_GET["pagina"] == 1 or $_GET["pagina"] == 2)
																{
																	echo '<option>...</option>';
																}
																else
																{
																	if ($_GET["pagina"] == n_pagine($n_album))
																	{
																		echo '<option selected>...</option>';
																	}
																}
																for ($ciclo = 3; $ciclo < n_pagine($n_album); $ciclo ++)
																{
																	if ($_GET["pagina"] == $ciclo)
																	{
																		echo '<option value="'.$ciclo.'" selected>'.$ciclo.'</option>'."\t";
																	}
																	else
																	{
																		echo '<option value="'.$ciclo.'">'.$ciclo.'</option>';
																	}
																}
															?>
														</select>
													</form>
												</td>
												<td>
													<?php
														echo '<a href="album.php?pagina='.n_pagine($n_album).'" class="pagine">'.n_pagine($n_album).'</a>';
													?>
												</td>
												<td>
													<?php
														echo '<a href="album.php?pagina='.limite_pagine($prossima, 0, n_pagine($n_album)).'" class="pagine">>></a>';
													?>
												</td>
											</tr>
										</tbody>
									</table>
								</td>	
							</tr>
						</tfoot>
						<?php
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