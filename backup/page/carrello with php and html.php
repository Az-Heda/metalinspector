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
					<li><a href="carrello.php" class="active">Carrello</a></li>
					<li><a href="desideri.php">Lista dei desideri</a></li>
				</ul>
			</nav>
		</header>
		<section id="banner" style="height: 20rem !important; min-height: 20rem">
			<div class="inner">
				<h1 class="title">Carrello</h1>
			</div>
		</section>
		<?php
			$band_id = [];
			$band_name = [];
			$album_id = [];
			$album_name = [];
			$costo = [];
			$cont = 0;
			$Cn=mysql_connect();
			$link=mysql_connect("localhost","root","");
			if(!$link)
					die("Non riesco a connettermi:".mysql_error());
			$db_selected=mysql_select_db("metal",$link);
			if(!$db_selected)
					die("Errore nella selezione del DB".mysql_error());
			mysql_select_db("metal");
			$Query="select A.album_id as AID, B.nome as band_name, A.titolo as album_name, U.username as utente, count(*)*0.90 as prezzo
			from carrello as D, utenti as U, album_carrello as AC, album as A, band as B, canzoni as C
			where D.desideri = 'n' and
				  U.utente_id = D.utente_id and
				  AC.carrello_id = D.carrello_id and
				  AC.album_id = A.album_id and
				  B.band_id = A.band_id and
				  C.album_id = A.album_id and
				  B.band_id = A.band_id and
				  U.utente_Id = ".$_SESSION["id"]."
			group by AID";
			$result=mysql_query($Query);
			if(!$result) {
					die("Errore della query:".mysql_error());
			}
			while ($row = mysql_fetch_assoc($result)) {
					$band_name[$cont] = $row["band_name"];
					$album_id [$cont] = $row["AID"];
					$album_name [$cont] = $row["album_name"];
					$costo [$cont] = $row["prezzo"];
					$cont ++;
				}
			mysql_free_result($result);
			mysql_close();
		?>
		<section id="main" class="spazio">
			<div class="inner">
				<div class="spazio_tabella">
					<table class="table_color">
						<?php
							if ($cont > 0)
							{
								echo '<thead class="vertical">'."\n";
								echo "\t".'<tr>'."\n";
								echo "\t".'<th>Copertina</th>'."\n";
								echo "\t\t".'<th>Album</th>'."\n";
								echo "\t\t".'<th>Band</th>'."\n";
								echo "\t\t".'<th>Costo</th>'."\n";
								echo "\t".'</tr>'."\n";
								echo '</thead>'."\n";
							}
						?>
						<!--<thead class="vertical">
							<tr>
								<th>Copertina</th>
								<th>Album</th>
								<th>Band</th>
								<th>Costo</th>
							</tr>
						</thead>-->
						
						<tbody class="vertical" id="cursor">
							<?php
								$n_elementi = 0;
								for ($x = 0; $x < $cont; $x ++)
								{
									$num = $cont + 1;
									$num_1 = $x + 1;
									$n_elementi ++;
									echo '<tr id="riga_'.$num_1.'" style=" background-color: transparent;">'."\n";
									echo "\t".'<td><img src="img/album_'.$album_id[$x].'.jpg"/></td>'."\n";
									echo "\t".'<td>'.$band_name[$x].'</td>'."\n";
									echo "\t".'<td>'.$album_name[$x].'</td>'."\n";
									echo "\t".'<td>'.$costo[$x].'€</td>'."\n";
									echo '</tr>'."\n";
									echo '<tr id="img_'.$num_1.'_n" style="border: none; background-color: transparent;">'."\n";
									echo "\t".'<td colspan="3">'."\n";
									echo "\t\t".'<table class="button">'."\n";
									echo "\t\t\t".'<tbody>'."\n";
									echo "\t\t\t\t".'<tr  style="border: none; background-color: transparent;">'."\n";
									echo "\t\t\t\t\t".'<td>'."\n";
									echo "\t\t\t\t\t\t".'<form method="post">'."\n";
									echo "\t\t\t\t\t\t\t".'<input type="hidden" value="'.$album_id[$x].'" name="album_id"/>'."\n";
									echo "\t\t\t\t\t\t\t".'<input type="submit" value="Compra" class="main"/>'."\n";
									echo "\t\t\t\t\t\t".'</form>'."\n";
									echo "\t\t\t\t\t".'</td>'."\n";
									echo "\t\t\t\t".'<td>'."\n";
									echo "\t\t\t\t\t".'<form method="post">'."\n";
									echo "\t\t\t\t\t\t".'<input type="hidden" value="'.$album_id[$x].'" name="album_id"/>'."\n";
									echo "\t\t\t\t\t\t\t".'<input type="submit" value="Rimuovi"/>'."\n";
									echo "\t\t\t\t\t\t".'</form>'."\n";
									echo "\t\t\t\t\t".'</td>'."\n";
									echo "\t\t\t\t".'</tr>'."\n";
									echo "\t\t\t".'</tbody>'."\n";
									echo "\t\t".'</table>'."\n";
									echo "\t".'</td>'."\n";
									echo "\t".'<script>'."\n";
									echo "\t\t".'$(function(){'."\n";
									echo "\t\t\t".'$("#img_'.$num_1.'_n").slideUp(0);'."\n";
									echo "\t\t".'});'."\n";
									echo "\t".'</script>'."\n";
									echo '</tr>'."\n";
								}
							?>
							<!--<tr id="riga_1" style="background-color: transparent;">
								<td><img src="img/album_8.jpg"/></td>
								<td>Sleeping Romance</td>
								<td>Alba</td>
								<td>9.00€</td>
							</tr>
							<tr id="img_1_n" style="border: none; background-color: transparent;">
								<td colspan="3">
									<table class="button">
										<tbody>
											<tr  style="border: none; background-color: transparent;">
												<td>
													<form method="post">
														<input type="hidden" value="8" name="album_id"/>
														<input type="submit" value="Compra" class="main"/>
													</form>
												</td>
												<td>
													<form method="post">
														<input type="hidden" value="8" name="album_id"/>
														<input type="submit" value="Elimina"/>
													</form>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
								<script>
									$(function(){
										$("#img_1_n").slideUp(0);
									});
								</script>
							</tr>
							<tr id="riga_2" style="background-color: rgba(0, 0, 0, 0.075);">
								<td><img src="img/album_12.jpg"/></td>
								<td>Beyond The Black</td>
								<td>Heart Of The Hurricane</td>
								<td>14.40€</td>
							</tr>
							<tr id="img_2_n" style="border: none; background-color: rgba(0, 0, 0, 0.075);">
								<td colspan="3">
									<table class="button">
										<tbody>
											<tr  style="border: none; background-color: transparent;">
												<td>
													<form method="get">
														<input type="hidden" value="12" name="album_id"/>
														<input type="submit" value="Compra" class="main"/>
													</form>
												</td>
												<td>
													<form method="get">
														<input type="hidden" value="12" name="album_id"/>
														<input type="submit" value="Elimina"/>
													</form>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
								<script>
									$(function(){
										$("#img_2_n").slideUp(0);
									});
								</script>
							</tr>
							<tr id="riga_3" style="background-color: transparent;">
								<td><img src="img/album_3.jpg"/></td>
								<td>Among Gods</td>
								<td>The Feeding Of Cruelty</td>
								<td>9.00€</td>
							</tr>
							<tr id="img_3_n" style="border: none; background-color: transparent;">
								<td colspan="3">
									<table class="button">
										<tbody>
											<tr  style="border: none; background-color: transparent;">
												<td>
													<form method="post">
														<input type="hidden" value="3" name="album_id"/>
														<input type="submit" value="Compra" class="main"/>
													</form>
												</td>
												<td>
													<form method="post">
														<input type="hidden" value="3" name="album_id"/>
														<input type="submit" value="Elimina"/>
													</form>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
								<script>
									$(function(){
										$("#img_3_n").slideUp(0);
									});
								</script>
							</tr>
							<tr id="riga_4">
								<td><img src="img/album_4.jpg"/></td>
								<td>Insomnium</td>
								<td>Shadows Of The Dying Sun</td>
								<td>9.00€</td>
							</tr>
							<tr id="img_4_n" style="border: none; background-color: rgba(0, 0, 0, 0.075);">
								<td colspan="3">
									<table class="button">
										<tbody>
											<tr  style="border: none; background-color: transparent;">
												<td>
													<form method="post">
														<input type="hidden" value="4" name="album_id"/>
														<input type="submit" value="Compra" class="main"/>
													</form>
												</td>
												<td>
													<form method="post">
														<input type="hidden" value="4" name="album_id"/>
														<input type="submit" value="Elimina"/>
													</form>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
								<script>
									$(function(){
										$("#img_4_n").slideUp(0);
									});
								</script>
							</tr>
							<tr id="riga_5" style="background-color: transparent;">
								<td><img src="img/album_6.jpg"/></td>
								<td>Iwrestledabearonce</td>
								<td>Hail Mary</td>
								<td>12.60€</td>
							</tr>
							<tr id="img_5_n" style="border: none; background-color: transparent;">
								<td colspan="3">
									<table class="button">
										<tbody>
											<tr  style="border: none; background-color: transparent;">
												<td>
													<form method="post">
														<input type="hidden" value="6" name="album_id"/>
														<input type="submit" value="Compra" class="main"/>
													</form>
												</td>
												<td>
													<form method="post">
														<input type="hidden" value="6" name="album_id"/>
														<input type="submit" value="Elimina"/>
													</form>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
								<script>
									$(function(){
										$("#img_5_n").slideUp(0);
									});
								</script>
							</tr>-->
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2"></td>
								<td>
									<form method="post">
										<input type="hidden" name="valore" value="all"/>
										<input type="submit" value="Compra tutto" class="main right"/>
									</form>
								</td>
								<td style="vertical-align: middle;">
									<?php
										$tot = 0;
										foreach($costo as $v)
										{
											$tot += $v;
										}
										$test = number_format($tot, 2, '.', '');
										echo $test.'€';
									?>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</section>
		<script>
			$(document).ready(function(){
				$("#riga_1").click(function(){
					$("#img_1_n").slideToggle(0);
				});
				$("#riga_2").click(function(){
					$("#img_2_n").slideToggle(0);
				});
				$("#riga_3").click(function(){
					$("#img_3_n").slideToggle(0);
				});
				$("#riga_4").click(function(){
					$("#img_4_n").slideToggle(0);
				});
				$("#riga_5").click(function(){
					$("#img_5_n").slideToggle(0);
				});
			});
		</script>
	</body>
</html>