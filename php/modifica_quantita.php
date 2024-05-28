<?php
	session_start();
?>
<!doctype html>
<html>
	<head>
		<title>Modifica quantità nel carrello | MetalInspector</title>
		<meta charset="UTF-8"/>
		<?php
			include 'connect.php';
		?>
	</head>
	<body>
		<?php
			if(isset($_POST["album_id"]) and isset($_POST["quantita"]))
			{
				$album_id = $_POST["album_id"];
				$quantita = $_POST["quantita"];
				$utente_id = $_SESSION["id"];
				echo "Album id: $album_id<br/>";
				echo "Quantita: $quantita<br/>";
				echo "Utente_id: $utente_id<br/>";
				$quant_max;
				$link_db = connessione_db();
				$Query="select Quantita from view_quantita where AID = $album_id";
				$result=mysql_query($Query);
				if(!$result) {
					die("Errore della query:".mysql_error());
				}
				while ($row = mysql_fetch_assoc($result)) {
					$quant_max = $row["Quantita"];
					echo "Quantità massima: $quant_max<br/>";
				}
				if ($quantita <= $quant_max)
				{
					$Query = "update album_carrello set quantita = $quantita where album_id = $album_id and carrello_id = (select carrello_id from carrello where utente_id = $utente_id and ordine_id is null order by carrello_id desc limit 1)";
					echo "Allora eseguo questa query:\n$Query<hr/><br/>";
					$result=mysql_query($Query);
					if(!$result) {
						die("Errore della query:".mysql_error());
					}
					mysql_close($link_db);
					header ('Location: ../carrello.php');
				}
				else
				{
					mysql_close($link_db);
					header ('Location: ../carrello.php');
				}
			
/*				
				
				
				
				else
				{
					//$Query_insert="insert into utenti (username, password) values ('$new_username', '$password');";
					$Query_insert="call insert_utenti('$new_username', '$password');";
					$result_insert=mysql_query($Query_insert);
					if(!$result_insert) {
							die("Errore della query:".mysql_error());
					}
					$Query="select UID from view_utenti where US = '$new_username'";
					$result=mysql_query($Query);
					if(!$result) {
						die("Errore della query:".mysql_error());
					}
					while ($row = mysql_fetch_assoc($result)) {
						$id_utente[$cont_id] = $row["UID"];
						$cont_id ++;
					}
					mysql_close($link_db);
					if (count($cont_id) == 1)
					{
						session_unset();
						$_SESSION["id"] = $id_utente;
						$_SESSION["username"] = $username;
						$_SESSION["logged"] = true;
						header('Location: ../index.php');
					}
					else
					{
						$_SESSION["login_error"] = "Errore: Esiste già un utente con il tuo username";
						header('Location: ../login.php');
					}
				}*/
			}
			else
			{
				header('Location: ../carrello.php');
			}
		?>
	</body>
</html>