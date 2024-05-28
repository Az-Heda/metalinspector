<?php
	session_start();
	if (!isset($_SESSION["logged"]))
	{
		$_SESSION["username"] = " ";
		$_SESSION["logged"] = false;
	}
	if (!$_SESSION["logged"])
	{
		header('Location: ../login.php');
	}
?>
<!doctype html>
<html>
	<head>
		<title>Rimuovi dal carrello / lista desideri</title>
		<meta charset="UTF-8"/>
		<?php
			include 'connect.php';
			function carrello_inattivo ()
			{
				$carrello_id = $_POST["carrello_id"];
				$album_id = $_POST["album_id"];
				$utente_id = $_SESSION["id"];
				$cont = 0;
				$link_db = connessione_db();
				//$Query_update_1="update album_carrello set attivo = 'n' where carrello_id = $carrello_id";
				$Query_update_1="delete from album_carrello where carrello_id = $carrello_id and album_id = $album_id";
				$result_update_1=mysql_query($Query_update_1);
				if(!$result_update_1) {
						die("Errore della query:".mysql_error());
				}
				mysql_free_result($result_update_1);
				mysql_close($link_db);
			}
		?>
	</head>
	<body>
		<?php
			if (isset ($_POST["album_id"]) and isset ($_POST["carrello_id"]) and isset ($_POST["lista"]))
			{
				$lista = $_POST["lista"];
				carrello_inattivo();
				if ($lista == "carrello")
				{
					header('Location: ../carrello.php');
				}
				else
				{
					header('Location: ../desideri.php');
				}
			}
		?>
	</body>
</html>