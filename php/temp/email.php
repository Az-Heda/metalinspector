<?php
	$msg = "Ciao, questo è il messaggio";
	$obg = "Prova invio email";
	$to = "-@gmail.com";
	echo "Messaggio: $msg<br/>\n";
	echo "Oggetto: $obg<br/>\n";
	echo "A: $to<br/>\n";
	mail($to, $obg, $msg);
?>