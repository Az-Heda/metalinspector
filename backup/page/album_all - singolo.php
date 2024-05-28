<?php
	session_start();
	if (!isset($_SESSION["status"]))
	{
		$_SESSION["username"] = " ";
		$_SESSION["status"] = false;
	}
?>
<!doctype html>
<html>
	<head>
		<title>Ricerca completa | Metal Inspector</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="CSS/stile.css" />
		<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
		<script src="jquery/include.js"></script>
		<script src="jquery/main.js"></script>
		<script src="javascript/indirizzo.js"></script>
		<?php
		//http://php.net/manual/en/function.mysql-query.php
			$band_id = [];
			$album_id = [];
			$band_name = [];
			$album_name = [];
			$prezzo = [];
			$cont = 0;
			$n_album;
			
			$Cn=mysql_connect();
			$link=mysql_connect("localhost","root","");
			if(!$link)
					die("Non riesco a connettermi:".mysql_error());
			$db_selected=mysql_select_db("metal",$link);
			if(!$db_selected)
					die("Errore nella selezione del DB".mysql_error());
			mysql_select_db("metal");
			$Query="select B.band_id as Band_Id, B.nome as Band_nome, A.album_id as Album_Id, A.titolo as Album_titolo, count(*)*0.90 as Prezzo
					from album as A, canzoni as C, band as B
					where A.album_id = C.album_id and B.band_id = A.band_id
					group by Album_Id
					ORDER BY A.Album_Id DESC";
			$result=mysql_query($Query);
			if(!$result) {
					die("Errore della query:".mysql_error());
			}
			while ($row = mysql_fetch_assoc($result)) {
					$band_id[$cont] = $row["Band_Id"];
					$album_id[$cont] = $row["Album_Id"];
					$band_name[$cont] = $row["Band_nome"];
					$album_name[$cont] = $row["Album_titolo"];
					$prezzo[$cont] = $row["Prezzo"];
					$cont ++;
				}
				$n_album = $cont;
			mysql_free_result($result);
			mysql_close();
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
			<?php
				
			//.center_1, .center_2, .center_3, .center_4, .center_5, .center_6 {
				for ($css = 0; $css < $n_album; $css ++)
				{
					$stile = $css + 1;
					if ($stile == $n_album)
					{
						echo '.center_'.$stile." {\n";
					}
					else
					{
						echo '.center_'.$stile.', ';
					}
				}
				echo "position: absolute;"."\n";
				echo "top: 50%;"."\n";
				echo "left: 50%;"."\n";
				echo "background-color: #222222;"."\n";
				echo "width: 250px;"."\n";
				echo "line-height:75px;"."\n";
				echo "height: 75px;"."\n";
				echo "color: #ffffff;"."\n";
				echo "transform: translate(-50%, -50%);"."\n";
				echo "display: block;"."\n";
				echo "opacity: 0;"."\n";
				echo "text-transform: uppercase;"."\n";
				echo "}";
			?>
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
				<li><a href="album_all.php" class="active">Elenco album</a></li>
				<li><a href="login.php">Accedi / registrati</a></li>
				<li><a href="carrello.php">Carrello</a></li>
				<li><a href="desideri.php">Lista dei desideri</a></li>
			</ul>
			</nav>
		</header>
		<section id="banner" style="height: 20rem !important; min-height: 20rem">
			<div class="inner">
				<h1 class="title">Ricerca completa</h1>
			</div>
		</section>
		<section class="spazio"  style="padding-top: 1em">
			<div class="inner no-width">
				<div class="card">
					<table style="padding-left: 24px; margin-left: auto; margin-right: auto;">
						<caption>
							<header class="titolo">
								<h2>Tutti gli album</h2>
							</header>
						</caption>
						<tbody>
							<?php
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
								$cont_album = 0;
								for ($x = 0; $x < $n_album_x_ciclo; $x ++)
								{
									$xy = $x * 3;
									echo '<tr style="border: none; background-color: transparent;">'."\n";
									for ($y = 0; $y < 3; $y ++)
									{
										if ($cont_album < $n_album)
										{
											$val = $xy + $y;
											$val_x1 = $xy + $y + 1;
											echo '<td style="padding-bottom: 20px; padding-right: 20px; padding-left: 20px;">'."\n";
											echo "\t".'<selection>'."\n";
											echo "\t\t".'<div class="contenitore">'."\n";
											echo "\t\t\t".'<header>'."\n";
											echo "\t\t\t\t".'<a href="album.php?album_id='.$album_id[$val].'">'."\n";
											echo "\t\t\t\t\t".'<div class="container">'."\n";
											echo "\t\t\t\t\t\t".'<img src="img/album_'.$album_id[$val].'.jpg" width="250px" id="img_'.$val_x1.'"/>'."\n";
											echo "\t\t\t\t\t\t".'<div class="center_'.$val_x1.'">'.$album_name[$val].'</div>'."\n";
											echo "\t\t\t\t\t".'</div>'."\n";
											echo "\t\t\t\t".'</a>'."\n";
											echo "\t\t\t\t".'<h3><a href="band.php?band_id='.$band_id[$val].'">'.$band_name[$val].'</a></h3>'."\n";
											echo "\t\t\t".'</header>'."\n";
											echo "\t\t\t".'<h3>'.$prezzo[$val].'€</h3>'."\n";
											echo "\t\t\t".'<h3 style="text-align: left;">Aggiungi album a:</h3>'."\n";
											echo "\t\t\t".'<table>'."\n";
											echo "\t\t\t\t".'<tbody>'."\n";
											echo "\t\t\t\t\t".'<tr style="border: none; background-color: transparent;">'."\n";
											echo "\t\t\t\t\t\t".'<td>'."\n";
											echo "\t\t\t\t\t\t\t".'<form method="post" action="php/aggiungi.php" style="margin-bottom: 0px;">'."\n";
											echo "\t\t\t\t\t\t\t\t".'<input type="hidden" name="lista" value="carrello"/>'."\n";
											echo "\t\t\t\t\t\t\t\t".'<input type="hidden" name="album_id" value="'.$album_id[$val].'"/>'."\n";
											echo "\t\t\t\t\t\t\t\t".'<input type="submit" value="Carrello" class="main margin_right"/>'."\n";
											echo "\t\t\t\t\t\t\t".'</form>'."\n";
											echo "\t\t\t\t\t\t".'</td>'."\n";
											echo "\t\t\t\t\t\t".'<td>'."\n";
											echo "\t\t\t\t\t\t\t".'<form method="post" action="php/aggiungi.php" style="margin-bottom: 0px;">'."\n";
											echo "\t\t\t\t\t\t\t\t".'<input type="hidden" name="lista" value="desideri"/>'."\n";
											echo "\t\t\t\t\t\t\t\t".'<input type="hidden" name="album_id" value="'.$album_id[$val].'"/>'."\n";
											echo "\t\t\t\t\t\t\t\t".'<input type="submit" value="Lista desideri" class="margin_left"/>'."\n";
											echo "\t\t\t\t\t\t\t".'</form>'."\n";
											echo "\t\t\t\t\t\t".'</td>'."\n";
											echo "\t\t\t\t\t".'</tr>'."\n";
											echo "\t\t\t\t".'</tbody>'."\n";
											echo "\t\t\t".'</table>'."\n";
											echo "\t\t".'</div>'."\n";
											echo "\t".'</section>'."\n";
											echo '</td>'."\n";
											$cont_album ++;
										}
									}
									echo '</tr>';
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
		<script>
			$(document).ready(function(){
				<?php
					for ($script = 0; $script < $n_album; $script ++)
					{
						$valore = $script + 1;
						echo '$("#img_'.$valore.', .center_'.$valore.'").mouseover(function(){'."\n";
						echo "\t".'$("#img_'.$valore.'").css("opacity", 0.5);'."\n";
						echo "\t".'$(".center_'.$valore.'").css("opacity", 1);'."\n";
						echo '});'."\n";
						echo '$("#img_'.$valore.', .center_'.$valore.'").mouseleave(function(){'."\n";
						echo "\t".'$("#img_'.$valore.'").css("opacity", 1);'."\n";
						echo "\t".'$(".center_'.$valore.'").css("opacity", 0);'."\n";
						echo '});'."\n";
					}
				?>
				
			});
		</script>
	</body>
</html>