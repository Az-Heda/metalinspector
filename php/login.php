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
			include 'funzioni.php';
			function login ()
			{
				$username = $_POST["username"];
				$password = $_POST["password"];
				$path = $_POST["indirizzo"];
				$id;
				$pass;
				$cont = 0;
				$link_db = connessione_db();
				$new_username = mysql_real_escape_string($username);
				$Query="select UID, PAS from view_utenti where US = '$new_username'";
				$result=mysql_query($Query);
				if(!$result) {
						die("Errore della query:".mysql_error());
				}
				while ($row = mysql_fetch_assoc($result))
				{
					$id = $row["UID"];
					$pass = $row["PAS"];
					$cont ++;
				}
				mysql_close($link_db);
				if ($cont == 1)
				{
					if (password_verify($password, $pass))
					{
						//session_unset();
						togli_sessione("login_error");
						togli_sessione("username");
						togli_sessione("id");
						$_SESSION["id"] = $id;
						$_SESSION["username"] = $_POST["username"];
						$_SESSION["logged"] = true;
						//echo 'Location: ../'.nome_pagina($path, 1);
						header('Location: ../'.nome_pagina($path, 1));
					}
					else
					{
						$_SESSION["login_error"] = "Password errata";
						header('Location: ../login.php');
					}
				}
				else
				{
					$_SESSION["login_error"] = "Username o password errati";
					header('Location: ../login.php');
				}
			}
			function logout()
			{
				session_unset();
				$_SESSION["username"] = " ";
				$_SESSION["logged"] = false;
				$indirizzo = $_POST["indirizzo"];
				header ('Location: ../'.nome_pagina($indirizzo,1));
			}
			
		?>
	</head>
	<body>
		<?php
			if(isset($_POST["username"]) and isset($_POST["password"]))
			{
				login();
			}
			else
			{
				if (!(isset($_POST["logout"])))
				{
					$_SESSION["login_error"] = "Problemi con il login, per favore, riprova";
					header ('Location: ../login.php');
				}
			}
			/*
				PARTE DI LOGOUT
			*/
			if (isset($_POST["logout"]) and isset($_POST["indirizzo"]))
			{
				logout();
			}
		?>
	</body>
</html>