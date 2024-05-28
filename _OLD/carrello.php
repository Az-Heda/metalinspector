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
		<section id="main" class="spazio">
			<div class="inner">
				<div class="spazio_tabella">
					<table class="table_color">
						<thead class="vertical">
							<tr>
								<th>Copertina</th>
								<th>Album</th>
								<th>Band</th>
								<th>Costo</th>
							</tr>
						</thead>
						<tbody class="vertical" id="cursor">
							<tr id="riga_1" style="background-color: transparent;">
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
							</tr>
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
								<td style="vertical-align: middle;">54.00€</td>
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