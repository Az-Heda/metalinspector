<?php
function val_album_max ($v1, $v2)
{
	$v1 += 3;
	if ($v1 < $v2)
	{
		return $v1;
	}
	else
	{
		return $v2;
	}
}

function n_pagine($n)
{
	return round(($n/9)+0.50);
}

function limite_pagine($x, $i, $n)
{
	if ($i == 1) // Risolve il problema del min
	{
		if ($x <= 1)
		{
			return 1;
		}
		else
		{
			return $x;
		}
	}
	if ($i == 0) // Risolve il problema del max
	{
		if ($x == $n)
		{
			return $n;
		}
		else
		{
			return $x;
		}
	}
}
function percentuale ($n, $max)
{
	// Calcoli:
	// $max : 100 = $n : x
	// x = ($n * 100) / $max
	$valore = ($n * 100) / $max;
	return number_format($valore, 1, ".", "");
}
function righe ($id)
{
	$n = count ($id);
	if ($n <= 3)
	{
		return 1;
	}
	else 
	{
		if ($n > 3 and $n <= 6)
		{
			return 2;
		}
		else
		{
			if ($n > 6 and $n <= 9)
			{
				return 3;
			}
			else
			{
				if ($n > 9 and $n <= 12)
				{
					return 4;
				}
			}
		}
	}
}
function max_album ($id)
{
	$contatore = count($id);
	if ($contatore <= 3)
	{
		return $contatore;
	}
	else
	{
		if ($contatore > 3)
		{
			return 3;
		}
	}
}
function nome_pagina($path, $n = 1)
{
	$cont = 0;
//	echo "Percorso: $path<br/>";
	$lung = strlen($path);
	for ($x = 0; $x < $lung; $x ++)
	{
		$let = substr($path, $x, 1);
		if ($let == "/")
		{
			if ($cont == $n)
			{
//				echo "Restituisco: ".substr($path, $x+1)."<br/>";
				return substr($path, $x+1);
			}
			$cont ++;
		}
	}
}
function costruzione_link($array, $pag)
{
	$pagina = $_GET["pagina"];
	$link = nome_pagina($_SERVER["PHP_SELF"])."?pagina=".$pag;
	$str = [];
//	echo "Ci sono: ".count($array)." generi";
	for ($x = 0; $x < count($array); $x ++)
	{
		$str[$x] = "id_".$x;
		if (isset($_GET[$str[$x]]))
		{
			//echo "Genere settato: ".$str[$x]."<br/>";
			$link .= "&".$str[$x]."=".$_GET[$str[$x]];
		}
	}
	if (isset($_GET["ordine"]))
	{
		$val = $_GET["ordine"];
		$link .= "&ordine=".$val;
	}
	return $link;
}
function filtri_attivi($g_id)
{
	$str = [];
	$cont = 0;
	for ($x = 0; $x < count($g_id); $x ++)
	{
		$str[$x] = "id_".$x;
		if (isset($_GET[$str[$x]]))
		{
			$cont ++;
		}
	}
	if ($cont == 0)
	{
		return false;
	}
	else
	{
		return true;
	}
}
function n_pagine_filtrate($tot_generi_id, $n_album_x_genere)
{
	$str = [];
	$g_id = [];
	$tot = 0;
	for ($x = 0; $x < count($tot_generi_id); $x ++)
	{
		$str[$x] = "id_".$x;
		if (isset($_GET[$str[$x]]))
		{
			$g_id[count($g_id)] = $_GET[$str[$x]];
			//echo "Corrispondenza trovata: Genere_ID: ".$_GET[$str[$x]]."<br/>";
		}
	}
	for ($a = 0; $a < count($g_id); $a ++)
	{
		for ($b = 0; $b < count($tot_generi_id); $b ++)
		{
			if ($g_id[$a] == $tot_generi_id[$b])
			{
				$tot += $n_album_x_genere[$b];
				//echo "Corrispondenza trovata, trovati ".$n_album_x_genere[$b]."<br/>";
			}
		}
	}
	//echo "Trovati $tot album<br/>";
	return $tot;
}
function input_tag_hidden($array, $ordine)
{
	//Fase di controllo
	$g_id = [];
	$tot = 0;
	for ($x = 0; $x < count($array); $x ++)
	{
		if (isset($_GET[$array[$x]]))
		{
			$g1 = $array[$x];
			$g2 = $_GET[$array[$x]];
			echo '<input type="hidden" name="'.$g1.'" value="'.$g2.'"/>'."\n";
		}
	}
	if (isset($_GET["ordine"]))
	{
		echo '<input type="hidden" name="ordine" value="'.$_GET["ordine"].'"/>'."\n";
	}
}
/*
	FUNZIONI CHE VENGONO CHIAMATE SOLO NEI VARI FILE CONTENTENTI SOLO PHP
*/
function find_cart_id ()
{
	$uid = $_SESSION["id"];
	$cont = 0;
	$link_db = connessione_db();
	$Query="select carrello_id as CID from carrello where utente_id = $uid and ordine_id is null order by carrello_id desc limit 1";
	$result=mysql_query($Query);
	if(!$result) {
			die("Errore della query:".mysql_error());
	}
	while ($row = mysql_fetch_assoc($result)) {
		$_SESSION["carrello_id"] = $row["CID"];
		$cont ++;
	}
	mysql_close($link_db);
	return $_SESSION["carrello_id"];
}
function carrello ($uid)
{
	//$link_db = connessione_db();
	$cont = 0;
	$Query="select carrello_id as CID from carrello where utente_id = $uid and ordine_id is null order by carrello_id desc limit 1";
	$result=mysql_query($Query);
	if(!$result) {
			die("Errore della query:".mysql_error());
	}
	while ($row = mysql_fetch_assoc($result)) {
			$carrello_id = $row["CID"];
			$cont ++;
		}
	
	if ($cont == 0)
	{ 
		//Bisogna creare una riga nel carrello per l'utente x
		$Query="call insert_carrello ($uid)";
		$result=mysql_query($Query);
		if(!$result) {
				die("Errore della query:".mysql_error());
		}
		$Query="select carrello_id as CID from carrello where utente_id = $uid and ordine_id is null order by carrello_id desc limit 1";
		$result=mysql_query($Query);
		if(!$result) {
				die("Errore della query:".mysql_error());
		}
		while ($row = mysql_fetch_assoc($result)) {
			$_SESSION["carrello_id"] = $row["CID"];
		}
	}
	else
	{
		$_SESSION["carrello_id"] = $carrello_id;
	}
//	mysql_close($link_db);
}

function sostituzione($str)
{
	$str_finale = '';
	for ($x = 0; $x < strlen($str); $x ++)
	{
		$lett = substr($str, $x, 1);
		$lett = ($lett == "#") ? $_SESSION["id"] : false;
		$str_finale .= $lett;
		echo $lett;
	}
	return $str_finale;
}

function execute_query ()
{
	echo "Sei entrato nella funzione: execute_query();<br/>";
	$utente_id = $_SESSION["id"];
	$_SESSION["query"] = sostituzione($_SESSION["query"]);
	echo $_SESSION["query"];
	$link_db = connessione_db();
	$result = $_SESSION["query"];
	if (!$result) {
		die("Errore della query: ".mysql_error());
	}
	echo "Album inserito nel carrello";
	mysql_close($link_db);
	unset($_SESSION["query"]);
}

function togli_sessione($par)
{
	// unset($_SESSION["x"]);
	if (isset($_SESSION[$par]))
	{
		unset($_SESSION[$par]);
	}
}
/*
	Protezione - cross site scripting
*/
	//<script>docunment.write('<img src="cookie?cookie=' + escape(document.cookie) + '" />')</script>

	//Controllo che non metta il tag di script
	function CrossSiteScripting ($str)
	{
		//Questa funzione mi protegge per quanto riguarda Cross-site scripting
		return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
	}
?>