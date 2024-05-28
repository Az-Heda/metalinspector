<?php
	session_start();
	if (!isset($_SESSION["logged"]))
	{
		$_SESSION["username"] = " ";
		$_SESSION["logged"] = false;
	}
	if (!$_SESSION["logged"])
	{
		header ('Location: ../login.php');
	}
?>
<!doctype html>
<html>
	<head>
		<title>Compra album | MetalInspector</title>
		<meta charset="UTF-8"/>
		<?php
			include 'connect.php';
		?>
	</head>
	<body>
		<?php
			if (isset($_POST["compra"]))
			{
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
					$link_db = connessione_db();
					$Query = "select CID, AID, BID, BNome, ATitolo, Prezzo, Quantita, QuantitaMax from view_carrello where UID = $utente_id order by ATitolo";
					$result=mysql_query($Query);
					if(!$result) {
							die("Errore della query:".mysql_error());
					}
					while ($row = mysql_fetch_assoc($result))
					{
						//Prendo i dati del carrello dell'utente
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
/*				$Query = "call insert_ordini($utente_id);";
				$result=mysql_query($Query);
				if(!$result) {
						die("Errore della query:".mysql_error());
				}
				else
				{*/
					echo "Ordine effettuato, sei pregato di inserire i tuoi dati:<br/>";
					echo "<table>";
					echo "<tbody>";
					for ($x = 0; $x < count($album_id); $x ++)
					{
						echo "<tr>";
						echo '<td><img src="../img/album_"'.$album_id[$x].'.jpg"/></td>';
						echo '<td>'.$band_name[$x].'</td>';
						echo '<td>'.$album_name[$x].'</td>';
						echo '<td>'.number_format($costo * $quantita, 2, '.', '').'</td>';
						echo "</tr>";
					}
					echo "</tbody>";
					echo "</table>";
//				}
			}
		?>
	</body>
</html>