<?php
	session_start();
	if (!isset($_SESSION["album_id"]))
	{
		$_SESSION["album_id"] = rand(1,120);
		$_SESSION["lista"] = "s";
		$_SESSION["logged"] = false;
		echo "Valori settati: <br/>";
		echo "Album_id = ".$_SESSION['album_id']."<br/>";
		echo "Lista = ".$_SESSION["lista"]."<br/>";
	}
	else
	{
		echo "Valori eliminati";
		/*unset($_SESSION["album_id"]);
		unset($_SESSION["lista"]);*/
		session_unset();
	}
?>