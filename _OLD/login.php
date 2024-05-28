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
		<title>Metal Inspected</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="CSS/stile.css" />
		<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
		<script src="jquery/include.js"></script>
		<script src="jquery/main.js"></script>
		<script src="javascript/indirizzo.js"></script>
		<style>
			.main_table {
				width: 60%;
				margin-right: auto;
				margin-left: auto;
			}
			.spazio_tabella {
				padding-top: 100px;
			}
			.sfumatura_leggera {
				box-shadow: 0px 0px 4px 1px rgba(0, 0, 0, 0.025);
			}
			input[type="text"], input[type="password"] {
				padding-left: 5px;
			}
			input[type="submit"].logout {
				    color: #ffffff !important;
					box-shadow: inset 0 0 0 1px #ffffff;
			}
		</style>
	</head>
	<body onload="all_address()" style="overflow-y:hidden;">
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
					<li><a href="login.php" class="active">Accedi / registrati</a></li>
					<li><a href="carrello.php">Carrello</a></li>
					<li><a href="desideri.php">Lista dei desideri</a></li>
				</ul>
			</nav>
		</header>
		<section id="banner" style="height: 20rem !important; min-height: 20rem">
			<div class="inner">
				<h1 class="title">Entra nel sito</h1>
			</div>
		</section>
		<section class="spazio" style="padding-top: 10px;">
			<div class="spazio_tabella">
				<table class="main_table">
					<tbody>
						<tr style="border: none; background-color: transparent;">
							<td class="sfumatura_leggera">
								<section style="width: 50%; margin 0 auto;">
									<div class="contenitore">
										<form method="post" action="php/login.php">
											<table>
												<caption><h1 style="font-size: 2rem;">Accedi</h1></caption>
												<tbody>
													<tr style="border: none; background-color: transparent;">
														<td>
															<input type="text" name="username" id="username" placeholder="Username"/>
														</td>
														<td>
															<input type="password" name="password" id="password" placeholder="Password"/>
														</td>
													</tr>
													<tr style="border: none; background-color: transparent;">
														<td colspan="2" style="text-align: center;">
															<input type="hidden" id="indirizzo_1" name="indirizzo"/>
															<input type="submit" value="Accedi" class="main"/>
															<input type="reset" value="Cancella"/>
														</td>
													</tr>
												</tbody>
											</table>
										</form>
									</div>
								</section>
							</td>
							<td class="sfumatura_leggera">
								<section style="width: 50%; margin 0 auto;">
									<div class="contenitore">
										<form method="post">
											<table>
												<caption><h1 style="font-size: 2rem;">Registrati</h1></caption>
												<tbody>
													<tr style="border: none; background-color: transparent;">
														<td colspan="2">
															<input type="text" name="username" id="username" placeholder="Username" style="width: 100%"/>
														</td>
													</tr>
													<tr style="border: none; background-color: transparent;">
														<td>
															<input type="password" name="password" id="password" placeholder="Password" />
														</td>
														<td>
															<input type="password" name="password" id="password" placeholder="Conferma password" />
														</td>
													</tr>
													<tr style="border: none; background-color: transparent;">
														<td colspan="2" style="text-align: center;">
															<input type="submit" value="Registrati" class="main"/>
															<input type="reset" value="Cancella"/>
														</td>
													</tr>
												</tbody>
											</table>
										</form>
									</div>
								</section>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</section>
	</body>
</html>