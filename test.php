<?php
	session_start();
	if (!isset($_SESSION["logged"]))
	{
		$_SESSION["username"] = " ";
		$_SESSION["logged"] = false;
	}
	include 'php/funzioni.php';
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
	<body>
		<?php
			require 'php/menu.php';
		?>
		<section id="banner" style="height: 20rem !important; min-height: 20rem">
			<div class="inner">
				<h1 class="title test">Entra nel sito</h1>
			</div>
		</section>
		<section class="spazio" style="padding-top: 10px;">
			<div class="spazio_tabella">
				<table class="main_table">
					<caption>
						<?php
							if (isset($_SESSION["login_error"]))
							{
								echo '<h1 style="font-size: 2rem;">Errore: <div style="font-size: 1.5rem; text-transform: uppercase;">'.$_SESSION["login_error"].'</div></h1>';
							}
						?>
					</caption>
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
															<?php
																if (isset($_SESSION["pagina_prec"]))
																{
																	//echo "Vieni dalla pagina: ".$_SESSION["pagina_prec"];
																	echo '<input type="hidden" value="'.$_SESSION["pagina_prec"].'" name="indirizzo"/>';
																	if (isset($_POST["album_id"]))
																	{
																		$_SESSION["album_id"] = $_POST["album_id"];
																	}
																	if (isset($_POST["lista"]))
																	{
																		$_SESSION["lista"] = $_POST["lista"];
																	}
																}
																else
																{
																	echo '<input type="hidden" value="../index.php" name="indirizzo"/>';
																}
															?>
															
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
										<form method="post" action="php/registrati.php">
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
															<input type="password" name="password1" id="password" placeholder="Password" />
														</td>
														<td>
															<input type="password" name="password2" id="password" placeholder="Conferma password" />
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