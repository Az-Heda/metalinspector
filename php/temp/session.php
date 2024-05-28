<?php
	session_start();
	echo "<ol>";
	foreach ($_SESSION as $k => $v)
	{
		echo "<li>$k => $v</li>";
	}
	echo "</ol>";
?>