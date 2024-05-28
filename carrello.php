<?php
	session_start();
	if (!isset($_SESSION["logged"]))
	{
		$_SESSION["username"] = " ";
		$_SESSION["logged"] = false;
	}
	if (!$_SESSION["logged"])
	{
		$_SESSION["pagina_prec"] = $_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"];
		header('Location: login.php');
	}
?>
<!doctype html>
<html>
	<head>
		<title>Carrello | Metal Inspected</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="CSS/stile.css" />
		<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
		<script src="jquery/include.js"></script>
		<script src="jquery/main.js"></script>
		<script src="javascript/indirizzo.js"></script>
		<style>
			table.button {
				width: 50%;
				box-shadow: none;
			}
			.right {
				float: right;
			}
			table tbody tr td, table thead tr th, table, tfoot tr td {
				text-align: center;
			}
			input[type="submit"].logout {
				color: #ffffff !important;
				box-shadow: inset 0 0 0 1px #ffffff;
			}
			option:focus
			{
				background-color: #000000;
				color: #ffffff;
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
		<section id="banner" style="height: 20rem !important; min-height: 20rem">
			<div class="inner">
				<h1 class="title">Carrello</h1>
			</div>
		</section>
		<?php
			if ($_SESSION["logged"])
			{
				$utente_id = $_SESSION["id"];
				$band_id = [];
				$band_name = [];
				$album_id = [];
				$album_name = [];
				$costo = [];
				$quantita = [];
				$n_pezzi = [];
				$cont = 0;
				$Query = "select CID, AID, BID, BNome, ATitolo, Prezzo, Quantita, QuantitaMax from view_carrello where UID = $utente_id order by Bnome, ATitolo, CID asc;";
				$result=mysql_query($Query);
				if(!$result) {
						die("Errore della query:".mysql_error());
				}
				while ($row = mysql_fetch_assoc($result))
				{
					$band_name[$cont] = $row["BNome"];
					$album_id [$cont] = $row["AID"];
					$carrello_id [$cont] = $row["CID"];
					$album_name [$cont] = $row["ATitolo"];
					$costo [$cont] = $row["Prezzo"];
					$quantita [$cont] = $row["Quantita"];
					$n_pezzi [$cont] = $row["QuantitaMax"];
					$cont ++;
				}
			}
		?>
		<section id="main" class="spazio">
			<div class="inner">
				<div class="spazio_tabella">
					<table class="table_color">
						<?php
							if ($_SESSION["logged"])
							{
								if ($cont > 0)
								{
						?>
						<thead class="vertical">
							<tr>
								<th>Copertina</th>
								<th>Band</th>
								<th>Album</th>
								<th>Quantità</th>
								<th>Costo<br/>unitario</th>
								<th>Costo<br/>totale</th>
							</tr>
						</thead>
						<?php
								}
							}
						?>
						<tbody class="vertical" id="cursor">
						<?php
							if ($_SESSION["logged"])
							{
								$n_elementi = 0;
								for ($x = 0; $x < $cont; $x ++)
								{
									$num = $cont + 1;
									$num_1 = $x + 1;
									$n_elementi ++;
									$corr = false;
										echo '<tr id="riga_'.$num_1.'" style=" background-color: transparent;">'."\n";
										echo "\t".'<td><img src="img/album_'.$album_id[$x].'.jpg"/></td>'."\n";
									?>
							<td><?php echo $band_name[$x] ?></td>
							<td><?php echo $album_name[$x] ?></td>
							<td>
								
							<?php
								echo '<form method="post" action="php/modifica_quantita.php" id="modifica_quantita_'.$num_1.'">';
								echo '<input type="hidden" name="album_id" value="'.$album_id[$x].'"/>';
								echo "\t".''.'<select name="quantita" id="quantita_'.$num_1.'" style="font-weight: bold; width: 40%;" onchange="document.getElementById(\'modifica_quantita_'.$num_1.'\').submit();">'."\n";
								for ($option = 0; $option < $n_pezzi[$x]; $option ++)
								{
									$pezzi = $option + 1;
									if ($quantita[$x] == $pezzi)
									{
										echo "\t\t".'<option value="'.$pezzi.'" selected>'.$pezzi.'</option>'."\n";
									}
									else
									{
										echo "\t\t".'<option value="'.$pezzi.'">'.$pezzi.'</option>'."\n";
									}									
								}
							?>
											</select>
							</form>
										</td>
											<td><?php echo number_format($costo[$x], 2, '.', '').'€' ?></td>
											<td><?php echo number_format($costo[$x] * $quantita[$x], 2, '.', '').'€' ?></td>
										</tr>
										<?php
											echo '<tr id="img_'.$num_1.'_n" style="border: none; background-color: transparent;">';
										?>
											<td colspan="4">
											<table class="button">
												<tbody>
													<tr  style="border: none; background-color: transparent;">
														<td>
															<form method="post" action="php/rimuovi.php">
																<input type="hidden" value="carrello" name="lista"/>
																<?php
																	echo '<input type="hidden" value="'.$album_id[$x].'" name="album_id"/>'."\n";
																	echo '<input type="hidden" value="'.$carrello_id[$x].'" name="carrello_id"/>';
																?>
																<input type="submit" value="Rimuovi" class="main"/>
															</form>
														</td>
														<td>
															<form method="post" action="php/aggiungi.php">
																<input type="hidden" value="carrello" name="lista"/>
																<?php
																	echo '<input type="hidden" value="'.$album_id[$x].'" name="album_id"/>'."\n";
																	echo '<input type="hidden" value="'.$carrello_id[$x].'" name="carrello_id"/>';
																?>
																<input type="submit" value="Aggiungi alla lista dei desideri" name="sposta"/>
															</form>
														</td>
													</tr>
												</tbody>
											</table>
										</td>
							<?php
										echo "\t".'<script>'."\n";
										echo "\t\t".'$(function(){'."\n";
										echo "\t\t\t".'$("#img_'.$num_1.'_n").slideUp(0);'."\n";
										echo "\t\t".'});'."\n";
										echo "\t".'</script>'."\n";
										echo '</tr>'."\n";
									}
								}
							?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="4"></td>
								<td>
									<form method="post" action="php/compra.php">
										<input type="hidden" name="all" value="all"/>
										<input type="submit" value="Compra tutto" class="main right" name="compra"/>
									</form>
								</td>
								<td style="vertical-align: middle;">
									<?php
										if ($_SESSION["logged"])
										{
											$tot = 0;
											for ($v = 0; $v < count($costo); $v ++)
											{
												$tot += $costo[$v] * $quantita[$v];
											}
											/*foreach($costo as $v)
											{
												$tot += $v;
											}*/
											$test = number_format($tot, 2, '.', '');
											echo $test.'€';
										}
									?>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</section>
		<script>
			<?php
				echo '$(document).ready(function(){'."\n";
				for ($script = 0; $script < $cont; $script ++)
				{
					$posizione = $script + 1;
					echo '$("#quantita_'.$posizione.'").click(function(){'."\n";
					echo '$("#img_'.$posizione.'_n").slideToggle(0);'."\n";
					echo '});'."\n";
					echo '$("#riga_'.$posizione.'").click(function(){'."\n";
					echo '$("#img_'.$posizione.'_n").slideToggle(0);'."\n";
					echo '});'."\n";
				}
				echo '});'."\n";
			?>
		</script>
		<?php
			mysql_close($link_db);
		?>
	</body>
</html>