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
		<link rel="stylesheet" href="CSS/filtro.css"/>
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
			$genere_id = [];
			$nome_genere = [];
			$str = []; //La uso per prendere gli id dei vari generi (generando stringhe che corrispondano a "id_X", al posto della x ci metto il numero del genere)
			$get_id = []; //La uso per prendere gli id dei generi selezionati dall'utente
			$cont = 0;
			$cont2 = 0;
			$n_album = 0;
			$n_generi = 0;
			$n = 0;
			$link_db = connessione_db();
			switch ($link_db)
			{
				case -1:
					die("Non riesco a collegarmi al database");
					break;
				case -2:
					die("Errore imprevisto con il database");
					break;
			}

			$Query="select GID, GNome, Contatore from view_genere_cont";
			$result=mysql_query($Query);	
			if(!$result) {
					die("Errore della query:".mysql_error());
			}
			while ($row = mysql_fetch_assoc($result)) {
				$genere_id[$cont2] = $row["GID"];
				$nome_genere[$cont2] = $row["GNome"];
				$cont_genere[$cont2] = $row["Contatore"];
				$cont2 ++;
			}
			$n_generi = $cont2;
			for ($x = 0; $x < count($genere_id); $x ++)
			{
				$str[$x] = "id_$x"; //Creo la stringa da mettere in $_GET[$str]; che sarà: "id_0", "id_1", "id_2","id_...", "id_n"
			}
			foreach ($str as $key => $value)
			{
				if (isset($_GET[$value]))
				{
					$get_id[$n] = $_GET[$value];
					$n ++;
				}
			}
			if (isset($_GET["album_id"]))
			{
				$album_id_get = mysql_real_escape_string($_GET["album_id"]);
			}
			else
			{
				$album_id_get = 0;
			}
			$ordine_array[0] = "TitoloAlfabetico";
			$ordine_array[1] = "TitoloNonAlfabetico";
			$ordine_array[2] = "PrezzoCresente";
			$ordine_array[3] = "PrezzoDecrescente";
			if (isset($_GET["ordine"]))
			{
				$ordine = $_GET["ordine"];
				switch ($ordine)
				{
					case $ordine_array[0]:
						$ord = "ATitolo asc";
						break;
					case $ordine_array[1]:
						$ord = "ATitolo desc";
						break;
					case $ordine_array[2]:
						$ord = "Prezzo asc";
						break;
					case $ordine_array[3]:
						$ord = "Prezzo desc";
						break;
					default:
						$ord = "ATitolo asc";
						break;
				}
			}
			else
			{
				$ord = "ATitolo asc";
			}
			if (count($get_id) == 0)
			{
				//Quando l'utente non vuole filtrare per il genere
				$Query="select BID, AID, BNome, ATitolo, Prezzo from view_elenco_album order by ".$ord;
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
			}
			else
			{
				$filtro = '(';
				for ($get = 0; $get < count($get_id); $get ++)
				{
					$controllo = $get + 1;
					if ($controllo == count($get_id))
					{
						$temp = $get_id[$get];
					}
					else
					{
						$temp = $get_id[$get].', ';
					}
					$filtro .= $temp;
				}
				$filtro .= ')';
				//Quando l'utente vuole filtrare x il genere
				$Query = "select AID, ATitolo, BID, BNome, GID, Gnome, Costo as Prezzo from view_elenco_album_w_genere where GID in ".$filtro." order by ".$ord;
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
		<?php
			if (isset($_GET["pagina"]))
			{
		?>
		
		<script>
			$(document).ready(function(){
				/*$("#apri_filtri").click(function(){
					$("#div_filtri").slideToggle(100);
				});*/
				$("#apri_filtri").click(function(){
					$("#menu1").attr("id", "open_menu1");
				});
				$("#open_menu1").mouseleave(setTimeout(function(){
					//$("#open_menu1").mouseleave(function() {
						$("#open_menu1").attr("id", "menu1");
					//});
				}), 3000);
			});
		</script>
		<div>
			<div class="copri"></div>
			<form method="get" action="album2.php" id="get">
				<nav id="menu1">
					<ul class="link">
						<li><h3>Generi</h3></li>
						<?php
							echo '<input type="hidden" name="pagina" value="'.$_GET["pagina"].'"/>';
							for ($genere = 0; $genere < count($genere_id); $genere ++)
							{
								if (isset($_GET[$str[$genere]]))
								{
									echo '<li><lable for="genere_'.$genere_id[$genere].'">'.$nome_genere[$genere].' ('.$cont_genere[$genere].')</lable>'."\n";
									echo '<input type="checkbox" name="id_'.$genere.'" value="'.$genere_id[$genere].'" 		checked/></li>';
								}
								else
								{
									echo '<li><lable for="genere_'.$genere_id[$genere].'">'.$nome_genere[$genere].' ('.$cont_genere[$genere].')</lable>'."\n";
									echo '<input type="checkbox" name="id_'.$genere.'" value="'.$genere_id[$genere].'"/></li>';
								}
							}
						?>
					
				<hr/>
				<h3>Ordina per</h3>
				<?php
					//a $ordinedesc assegno quello che mi serve nella parte per riordinare gli album.
					//Quello dentro "descrizione" è quello che l'utente vede nella parte apposita, mentre quello in value va a finire nell'url
					$tot_ord = 4; //da aumentare, è il numero delle voci da mostrare
					$ordinedesc = array(
						"descrizione" => array(),
						"value" => array()
					);
					$ordinedesc["descrizione"][0] = "Titolo [A-Z]";
					$ordinedesc["value"][0] = "TitoloAlfabetico";
					$ordinedesc["descrizione"][1] = "Titolo [Z-A]";
					$ordinedesc["value"][1] = "TitoloNonAlfabetico";
					$ordinedesc["descrizione"][2] = "Prezzo crescente";
					$ordinedesc["value"][2] = "PrezzoCresente";
					$ordinedesc["descrizione"][3] = "Prezzo decrescente";
					$ordinedesc["value"][3] = "PrezzoDecrescente";
					for ($ordi = 0; $ordi < $tot_ord; $ordi ++)
					{
						echo '<li><label for="ordine">'.$ordinedesc["descrizione"][$ordi].'</lable>';
						if (isset($_GET["ordine"]))
						{
							if ($_GET["ordine"] == $ordinedesc["value"][$ordi])
							{
								echo '<input type="radio" value="'.$ordinedesc["value"][$ordi].'" name="ordine" checked/></li>';
							}
							else
							{
								echo '<input type="radio" value="'.$ordinedesc["value"][$ordi].'" name="ordine"/></li>';
							}
						}
						else
						{
							if ($ordi == 0)
							{
								echo '<input type="radio" value="'.$ordinedesc["value"][$ordi].'" name="ordine" checked/></li>';
							}
							else
							{
								echo '<input type="radio" value="'.$ordinedesc["value"][$ordi].'" name="ordine"/></li>';
							}
						}
					}
				?>
				<input type="submit" value="Attiva filtri"/>
					</ul>
				</nav>
			</form>
		</div>
		<?php
			}
/*			foreach ($get_id as $k => $v)
			{
				echo '$get_id['.$k.'] = '.$v."<br/>\n";
			}*/
		?>
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
											echo "Pagina <b>".$_GET["pagina"]."</b> | <button id=\"apri_filtri\">Filtri</button>";
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
									if (!isset($_GET["pagina"]) or $_GET["pagina"] <= 0)
									{
										header ('Location: album2.php?pagina=1');
									}
									else
									{
										if ($_GET["pagina"] > n_pagine($n_album))
										{
											header ('Location: album_filtro.php?pagina='.n_pagine($n_album));
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
													<?php echo '<a href="album_filtro.php?album_id='.$album_id[$val].'">';	?>
														<div class="container">
															<?php echo '<img src="img/album_'.$album_id[$val].'.jpg" width="250px"/>'; ?>
														</div>
													</a>
													<?php echo '<h3><a href="album_filtro.php?album_id='.$album_id[$val].'">'.$album_name[$val].'</a><br/>'; ?>
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
											echo '<a href="album_filtro.php?pagina='.$num_pag.'">'.$num_pag.'</a>';
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
														echo '<a href="'.costruzione_link($genere_id, limite_pagine($precedente, 1, n_pagine($n_album))).'" class="pagine"><<</a>';
													?>
												</td>
												
													<?php
													$n_pag_filt = n_pagine(n_pagine_filtrate($genere_id, $cont_genere));
													$if = filtri_attivi($genere_id);
													//echo "Ci sono $n_pag_filt pagine filtrate<br/>";
													echo '<td><a href="'.costruzione_link($genere_id, 1).'" class="pagine">1</a></td>';
													echo '<td><a href="'.costruzione_link($genere_id, 2).'" class="pagine">2</a></td>';
													if (n_pagine($n_album) > 2)
													{
												?>	
												<td>
													<form method="get" id="select_pagine">
														<select name="pagina" onchange="document.getElementById('select_pagine').submit();" class="pagine">
															<?php
																if ($_GET["pagina"] == 1 or $_GET["pagina"] == 2)
																{
																	echo '<option selected>...</option>';
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
														<?php
															input_tag_hidden($str, $ordine_array);
														?>
													</form>
												</td>
													<?php
														}
														if (n_pagine($n_album) > 2)
														{
													?>
												<td>
													<?php
														echo '<a href="'.costruzione_link($genere_id, n_pagine($n_album)).'" class="pagine">'.n_pagine($n_album).'</a>';
													?>
												</td>
												<?php
													}
												?>
												<td>
													<?php
														echo '<a href="'.costruzione_link($genere_id, limite_pagine($prossima, 0, n_pagine($n_album))).'" class="pagine">>></a>';
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