<?php
	session_start();
	if (!isset($_SESSION["logged"]))
	{
		$_SESSION["username"] = " ";
		$_SESSION["logged"] = false;
	}
	include 'connect.php';
	include 'funzioni.php';
?>


<?php
	echo "File chiamato con successo<br/>";
	foreach ($_SESSION as $k => $v)
	{
		echo '$_SESSION["'.$k.'"] = '.$v.'<br/>';
	}
	echo "<hr/>";
	if (isset($_SESSION["id"]))
	{
		echo "IF alla riga: 20 risulta TRUE<br/>";
		if (isset($_POST["album_id"]) and isset($_POST["lista"]) and !isset($_POST["sposta"]))
		{
			echo "Codice per aggiungere gli album agli utenti gia loggati";
			$lista = mysql_real_escape_string($_POST["lista"]);
			$album_id = mysql_real_escape_string($_POST["album_id"]);
			$utente_id = mysql_real_escape_string($_SESSION["id"]);
			if (isset($_SESSION["carrello_id"]))
			{
				$carrello_id = $_SESSION["carrello_id"];
			}
			else
			{
				$carrello_id = find_cart_id();
			}
			$pos; //Valore n = sta nel carrello, valore s = sta nella lista desideri
			if ($lista == "carrello")
			{
				$pos = "n";
			}
			else
			{
				$pos = "s";
			}
			$cont = 0;
			$link_db = connessione_db();
			carrello ($utente_id);
			$Query="call insert_album_carrello ($album_id, (select carrello_id from carrello where utente_id = $utente_id and ordine_id is 	null order by carrello_id desc limit 1), '$pos');";
			$result=mysql_query($Query);
			if(!$result) {
					die("Errore della query:<br/>".mysql_error()."<hr/>");
			}
			else
			{
				echo "Query eseguita";
			}
			
			mysql_close($link_db);
			if ($pos == "n")
			{
				header('Location: ../carrello.php');
			}
			else
			{
				header('Location: ../desideri.php');
			}
		}
		else
		{
			if (isset($_SESSION["album_id"]) and isset($_SESSION["lista"]))
			{
				echo "Codice per memorizzare nella sessione che un utente non loggato vuole aggiungere un album al carrello o alla lista dei 	desideri, questo mi server per prepararmi la query, salvarmela ed eseguirla una volta che l'utente si è registrato.
				//Memorizzo sia l'id dell'album da aggiungere che la sua destinazione (carrello, lista dei desideri) nella sessione, per poter 	accedere a queste variabili con comodità<br/>";
				if ($_SESSION["logged"])
				{
					echo "Esegui il codice per un utente che ha schiacciato il bottone per aggiungere al carrello da non loggato e ora si è 	loggato, e quindi l'album si aggiunge in automatico";
					$lista = $_SESSION["lista"];
					$album_id = $_SESSION["album_id"];
					$utente_id = $_SESSION["id"];
					togli_sessione("pagina_prec");
					togli_sessione("album_id");
					togli_sessione("lista");
					if (isset($_SESSION["carrello_id"]))
					{
						$carrello_id = $_SESSION["carrello_id"];
					}
					else
					{
						$carrello_id = find_cart_id();
					}
					$pos; //Valore n = sta nel carrello, valore s = sta nella lista desideri
					if ($lista == "carrello")
					{
						$pos = "n";
					}
					else
					{
						$pos = "s";
					}
					$cont = 0;
					$link_db = connessione_db();
					carrello ($utente_id);
					$Query="call insert_album_carrello ($album_id, (select carrello_id from carrello where utente_id = $utente_id and ordine_id is null order by carrello_id desc limit 1), '$pos');";
					$result=mysql_query($Query);
					if(!$result) {
							die("Errore della query:<br/>".mysql_error()."<hr/>");
					}
					else
					{
						echo "Query eseguita";
					}
					
					mysql_close($link_db);
					if ($pos == "n")
					{
						header('Location: ../carrello.php');
					}
					else
					{
						header('Location: ../desideri.php');
					}
				}
			}
		}
	}
	else
	{
		echo "IF alla riga: 20 risutla FALSE<br/>";
		echo "Utente da mandare alla pagina di login<br/>";
		$_SESSION["album_id"] = $_POST["album_id"];
		$_SESSION["lista"] = ($_POST["lista"] == 'carrello') ? 'n' : 's';
		$pos = $_SESSION["lista"];
		echo "Pos: $pos<br/>Lista: ".$_SESSION["lista"]."<br/>Album: ".$_SESSION["album_id"];
		$_SESSION["pagina_prec"] = $_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"];
		header('Location: ../login.php');
	}
?>