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
		<section id="banner" style="height: 20rem !important; min-height: 20rem;">
			<div class="inner">
				<h1 class="title">Sleeping Romance</h1>
			</div>
		</section>
		<section class="spazio"  style="padding-top: 1em; padding-bottom: 0;">
			<div class="inner">
				<div class="card" style="margin-bottom: 0px">
					<table style="padding-left: 24px; margin-left: auto; margin-right: auto;">
						<caption>
							<header class="titolo">
							<h2>Genere: Symphonic metal</h2>
							<h2>Elenco album</h2>
							</header>
						</caption>
						<tbody>
							<tr style="border: none; background-color: transparent;">
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
							</tr>
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