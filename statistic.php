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
		<title>Statistiche | Metal Inspected</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="CSS/stile.css" />
		<link rel="stylesheet" href="CSS/statistic.css"/>
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
			#barra {
			  height: 30px;
			  text-align: center;
			  line-height: 30px;
			  color: white;
			  background-color: rgba(206,27,40,0.8);
			}
		</style>
		<?php
		//http://php.net/manual/en/function.mysql-query.php
			include 'php/funzioni.php';
			include 'php/connect.php';
			$genere_id = [];
			$nome_genere = [];
			$n_genere = [];
			$cont = 0;
			$n_album;
			$link_db = connessione_db();
			if (isset($_GET["album_id"]))
			{
				$album_id_get = mysql_real_escape_string($_GET["album_id"]);
			}
			else
			{
				$album_id_get = 0;
			}
			$Query="select GID, GNome, N from view_generi_comprati order by N desc, GNome limit 5";
			$result=mysql_query($Query);	
			if(!$result) {
					die("Errore della query:".mysql_error());
			}
			while ($row = mysql_fetch_assoc($result)) {
				$genere_id[$cont] = $row["GID"];
				$nome_genere[$cont] = $row["GNome"];
				$n_genere[$cont] = $row["N"];
				$cont ++;
			}
		?>
	</head>
	<body onload="myFunction();">
		<?php
				require 'php/menu.php';
		?>
		<section id="banner" style="height: 20rem !important; min-height: 20rem">
			<div class="inner">
				<h1 class="title">Statistiche Metalinspector</h1>
			</div>
		</section>
		<div id="loader"></div>
		<section class="spazio" style="padding-top: 10px;" id="myDiv" style="display: none;">
			<div class="spazio_tabella">
				<table class="main_table">
					<caption>
						<h1 style="font-size: 2rem;">I Generi più venduti</h1>
					</caption>
					<tbody>
						<tr style="border: none; background-color: transparent;">
							
							<td class="sfumatura_leggera">
								<section style="width: 100%; margin 0 auto;">
									<table>
										<tbody>
											<?php
												$tot_generi = 0;
												foreach ($n_genere as $v)
												{
													$tot_generi += $v;
												}
												foreach ($n_genere as $k=>$v)
												{
											?>
											<tr style="border: none; background-color: transparent;">
												<td style="width: 50%;">
													<div style="display: inline"><?php echo $nome_genere[$k] ?></div>
												</td>
												<td>
													<div id="Myprogress" style="width: 100%; background-color: #aaa;">
														<?php
															$valore = percentuale ($v, $tot_generi);
															echo '<div id="barra" style="width: '.$valore.'%;">'.$valore.'%</div>'."\n";
														?>
													</div>
												</td>
											</tr>
											<?php
												}
											?>
										</tbody>
									</table>
								</section>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</section>
		<script>
			//Codice copiato da w3school: https://www.w3schools.com/howto/howto_css_loader.asp
			var myVar;
			
			function myFunction() {
			  myVar = setTimeout(showPage, 1000);
			}
			
			function showPage() {
			  document.getElementById("loader").style.display = "none";
			  document.getElementById("myDiv").style.display = "block";
			}
		</script>
	</body>
</html>