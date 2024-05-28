<?php
	session_start();
	echo "<h1>Elenco generi id</h1><ol>";
	foreach ($_SESSION["generi"] as $k => $v)
	{
		echo "<li>$k => $v</li>";
	}
	echo "</ol>";
?>