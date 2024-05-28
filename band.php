<?php
	session_start ();
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
			include 'php/funzioni.php';
			include 'php/connect.php';
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
			$band_id = mysql_real_escape_string($_GET["band_id"]);
			$album_id = [];
			$nome_band;
			$nome_album = [];
			$nome_artisti = [];
			$nome_strumenti = [];
			$nome_genere = [];
			$genere_id = [];
			$n_canzoni = [];
			$cont1 = 0;
			$cont2 = 0;
			$cont3 = 0;
/*			$Query1 = "select B.nome as BNome, A.titolo as ATitolo, A.album_id as AID, count(*) as NCanzoni
						from band as B, album as A, canzoni as C
						where B.band_id = A.band_id and
							  B.band_id = C.band_id and
							  C.album_id = A.album_id and
							  B.band_id = $band_id
						group by ATitolo
						order by ATitolo;";*/
			$Query1 = "select BNome, AID, ATitolo, NCanzoni from view_album_ncanzoni where BID = $band_id order by ATitolo";
/*			$Query2 = "select GE.genere_id GID, GE.nome as GNome
						from band_genere as BG, genere as GE
						where BG.genere_id = GE.genere_id and
							  BG.band_id = $band_id
						order by GID;";*/
			$Query2 = "select GID, GNome from view_genere_band where BID = $band_id";
/*			$Query3 = "select A.nome as ANome, S.nome as SNome
						from artisti as A, strumenti as S, artisti_strumenti as ARST, band_artisti as BAAR
						where BAAR.artista_id = A.artista_id and
							  A.artista_id = ARST.artista_id and
							  ARST.strumento_id = S.strumento_id and
							  BAAR.band_id = $band_id
						order by S.strumento_id, A.Nome";*/
			$Query3 = "select ANome, SNome from view_artisti_strumenti where BID = $band_id";
			$result1=mysql_query($Query1);
			if(!$result1) {
					die("Errore della query:".mysql_error());
			}
			while ($row1 = mysql_fetch_assoc($result1)) {
					$nome_band = $row1["BNome"];
					$nome_album[$cont1] = $row1["ATitolo"];
					$album_id[$cont1] = $row1["AID"];
					$n_canzoni[$cont1] = $row1["NCanzoni"];
					$cont1 ++;
				}
			$result2=mysql_query($Query2);
			if(!$result2) {
					die("Errore della query:".mysql_error());
			}
			while ($row2 = mysql_fetch_assoc($result2)) {
					$genere_id[$cont2] = $row2["GID"];
					$nome_genere[$cont2] = $row2["GNome"];
					$cont2 ++;
				}
			$result3=mysql_query($Query3);
			if(!$result3) {
					die("Errore della query:".mysql_error());
			}
			while ($row3 = mysql_fetch_assoc($result3)) {
					$nome_artisti[$cont3] = $row3["ANome"];
					$nome_strumenti[$cont3] = $row3["SNome"];
					$cont3 ++;
				}
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
			<div class="inner" style="width: 90rem">
				<div class="card" style="margin-bottom: 0px">
					<table style="padding-left: 24px; margin-left: auto; margin-right: auto;">
						<caption>
							<header class="titolo">
							<h2>Genere: 
								<?php
									foreach ($nome_genere as $v=>$k)
									{
										echo $k;
									}
								?>
							</h2>
							<h2>Elenco album</h2>
							</header>
						</caption>
						<tbody>
							<?php
								$n_album = count ($album_id);
								$cont_album = 0;
								for ($x1 = 0; $x1 < righe($album_id); $x1 ++)
								{
									echo '<tr style="border: none; background-color: transparent;">';
									for ($out = 0; $out < max_album($album_id); $out ++)
									{
										if ($cont_album < $n_album)
										{
											if ($x1 == 0)
											{
												
											}
											switch ($x1)
											{
												case 0:
													$out_def = $out;
													break;
												case 1:
													$out_def = $out + 3;
													break;
												case 2:
													$out_def = $out + 6;
													break;
											}
											$prezzo = number_format($n_canzoni[$out_def]*0.90, 2, '.', '');
											if (count($album_id) == 1)
											{
												echo '<td style="padding-bottom: 20px; padding-right: 120px; padding-left: 120px;">'."\n";
											}
											else
											{
												echo '<td style="padding-bottom: 20px; padding-right: 20px; padding-left: 20px;">'."\n";
											}
										?>
										<section>
										<div class="contenitore" style="box-shadow: none;">
											<header>
												<?php echo '<a href="album.php?album_id='.$album_id[$out_def].'">';	?>
													<div class="container">
														<?php echo '<img src="img/album_'.$album_id[$out_def].'.jpg" width="250px"/>'; ?>
													</div>
												</a>
												<?php echo '<h3><a href="album.php?album_id='.$album_id[$out_def].'">'.$nome_album[$out_def].'</a></h3>'; ?>
											</header>
											<?php echo '<h3>'.$prezzo.'€</h3>'; ?>
											<h3 style="text-align: left;">Aggiungi album a:</h3>
											<table>
												<tbody>
													<tr style="border: none; background-color: transparent;">
														<td>
															<form method="post" action="php/aggiungi.php" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="carrello"/>
																<?php echo '<input type="hidden" name="album_id" value="'.$album_id[$out_def].'"/>' ?>
																<input type="submit" value="Carrello" class="main margin_right"/>
															</form>
														</td>
														<td>
															<form method="post" action="php/aggiungi.php" style="margin-bottom: 0px;">
																<input type="hidden" name="lista" value="desideri"/>
																<?php echo '<input type="hidden" name="album_id" value="'.$album_id[$out_def].'"/>'; ?>
																<input type="submit" value="Lista desideri" class="margin_left"/>
															</form>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</section>
										<?php
											echo '</td>'."\n";
										}
										$cont_album ++;
									}
									echo "</tr>";
								}
							?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="<?php
									$n_album = count ($album_id);
									if ($n_album == 2)
									{
										echo 2;
									}
									else
									{
										if ($n_album >= 3)
										{
											echo 3;
										}
									}
								?>">
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
											<?php
												for ($art = 0; $art < $cont3; $art ++)
												{
													echo "<tr>";
													echo "<td>".$nome_artisti[$art]."</td>";
													echo "<td>".$nome_strumenti[$art]."</td>";
													echo "</tr>";
												}
											?>
										</tbody>
									</table>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</section>
		<?php
			mysql_close($link_db);
		?>	
	</body>
</html>