<?php
	session_start();
?>
<!doctype html>
<html>
	<head>
		<title>Login Metal Inspector</title>
		<meta charset="UTF-8"/>
		<?php
			include 'connect.php';
			switch ($link_db)
			{
				case -1:
					die("Non riesco a connettermi:".mysql_error());
					break;
				case -2:
					die("Errore nella selezione del DB".mysql_error());
					break;
			}
		?>
	</head>
	<body>
		<?php
			$error = false;
			if(isset($_POST["username"]) and isset($_POST["password1"]) and isset($_POST["password2"]))
			{
				$username = $_POST["username"];
				$password1 = $_POST["password1"];
				$password2 = $_POST["password2"];
				$new_username = mysql_real_escape_string($username);
				if ($password1 == $password2)
				{
					$password = password_hash($password1, PASSWORD_DEFAULT);
					$username_db = [];
					$id_db;
					$cont_username = 0;
					$id_utente = 0;
					$link_db = connessione_db();
					$Query="select US from view_utenti";
					$result=mysql_query($Query);
					if(!$result) {
						die("Errore della query:".mysql_error());
					}
					while ($row = mysql_fetch_assoc($result)) {
						$username_db[$cont_username] = $row["US"];
						$cont_username ++;
					}
					for ($check = 0; $check < count($username_db); $check ++)
					{
						if ($username == $username_db[$check])
						{
							$error = true;
						}
					}
					if ($error)
					{
						mysql_close($link_db);
						$_SESSION["login_error"] = "Username gia preso, scegliene un'altro";
						header('Location: ../login.php');
					}
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
					}
				}
				else
				{
					echo "Password diverse";
					$_SESSION["login_error"] = "Password diverse";
					header('Location: ../login.php');
				}
			}
			else
			{
				header('Location: ../index.php');
			}
		?>
	</body>
</html>