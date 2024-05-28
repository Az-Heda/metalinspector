<?php
	function connessione_db()
	{
		$nome_db = "metalinspector";
		$link=mysql_connect("localhost","root","");
		if(!$link)
				return -1;
				//die("Non riesco a connettermi:".mysql_error());
		$db_selected=mysql_select_db($nome_db,$link);
		if(!$db_selected)
				return -2;
				//die("Errore nella selezione del DB".mysql_error());
		mysql_select_db($nome_db);
		return $link;
	}
?>
