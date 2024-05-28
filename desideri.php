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
		<title>Lista dei desideri | Metal Inspected</title>
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
				<h1 class="title">Lista dei desideri</h1>
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
				$carrello_id = [];
				$costo = [];
				$cont = 0;
				/*$Query="select D.carrello_id as CID, A.album_id as AID, B.nome as band_name, A.titolo as album_name, U.username as utente, count(*)*0.90 as prezzo
				from carrello as D, utenti as U, album_carrello as AC, album as A, band as B, canzoni as C
				where D.desideri = 's' and
					  U.utente_id = D.utente_id and
					  AC.carrello_id = D.carrello_id and
					  AC.album_id = A.album_id and
					  B.band_id = A.band_id and
					  C.album_id = A.album_id and
					  B.band_id = A.band_id and
					  D.attivo = 's' and
					  U.utente_Id = ".$_SESSION["id"]."
				group by AID";*/
				$Query = "select BNome, AID, ATitolo, CID, Prezzo from view_desideri where UID = $utente_id";
				$result=mysql_query($Query);
				if(!$result) {
						die("Errore della query:".mysql_error());
				}
				while ($row = mysql_fetch_assoc($result)) {
						$band_name[$cont] = $row["BNome"];
						$album_id [$cont] = $row["AID"];
						$carrello_id [$cont] = $row["CID"];
						$album_name [$cont] = $row["ATitolo"];
						$costo [$cont] = $row["Prezzo"];
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
									<th>Prezzo<br/>unitario</th>
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
										echo '<tr id="riga_'.$num_1.'" style=" background-color: transparent;">'."\n";
										echo "\t".'<td><img src="img/album_'.$album_id[$x].'.jpg"/></td>'."\n";
									?>
							<td><?php echo $band_name[$x] ?></td>
							<td><?php echo $album_name[$x] ?></td>
											</select>
										</td>
											<td><?php echo $costo[$x].'€' ?></td>
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
																<input type="hidden" value="desideri" name="lista"/>
																<?php
																	echo '<input type="hidden" value="'.$album_id[$x].'" name="album_id"/>'."\n";
																	echo '<input type="hidden" value="'.$carrello_id[$x].'" name="carrello_id"/>';
																?>
																<input type="submit" value="Rimuovi" class="main"/>
															</form>
														</td>
														<td>
															<form method="post" action="php/aggiungi.php">
																<input type="hidden" value="desideri" name="lista"/>
																<?php
																	echo '<input type="hidden" value="'.$album_id[$x].'" name="album_id"/>'."\n";
																	echo '<input type="hidden" value="'.$carrello_id[$x].'" name="carrello_id"/>';
																?>
																<input type="submit" value="Sposta nel carrello" name="sposta"/>
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
								<td colspan="2"></td>
								<td>
									<form method="post" action="php/aggiungi.php">
										<input type="hidden" name="valore" value="all"/>
										<input type="submit" value="Sposta tutto nel carrello" name="all" class="main right"/>
									</form>
								</td>
								<td style="vertical-align: middle;">
									<?php
										if ($_SESSION["logged"])
										{
											$tot = 0;
											foreach($costo as $v)
											{
												$tot += $v;
											}
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