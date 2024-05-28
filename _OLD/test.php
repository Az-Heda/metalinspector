<?php
	function x () {
	$artista = [];
	$strumento = [];
	$lung1 = count ($artista);
	$lung2 = count ($strumento);
	$lista_finale = array (
		"artista" => array (),
		"strumento" => array ()
	);
	$corrisp = false;
	$pos = 0;
	if ($lung1 == $lung2)
	{
		for ($a = 0; $a < $lung1; $a ++)
		{
			echo $artista[$a]." | ".$strumento[$a]."<br/>";
		}
	}
	else
	{
		for ($x = 0; $x < $lung1; $x ++)
		{
			for ($y = 0; $y < $lung2; $y ++)
			{
				if ($artista[$x] == $artista[y])
				{
					$lista_finale["artista"] [$x] = $artista[$x];
					$lista_finale["strumento"] [$x] = $strumento[$x].", ".$strumento[$y];
					$corrisp = true;
				}
			}
			if (!$corrisp)
			{
				$lista_finale["artista"] [$x] = $artista[$x];
				$lista_finale["strumento"] [$x] = $strumento[$x];
			}
			$corrisp = false;
		}
	}
	}
	
	//creare un unico grande array associativo che contenga tutto l'output del db
	//Poi per ogni voce che è in una lista fare una lista a parte controllando che il valore in $x sia diverso da tutti i valori messi nella lista
?>
<?php
	$band_id = $_GET["band_id"];
	$dati_db = array(
		"nome_band" => array (),
		"album_id" => array (),
		"nome_album" => array (),
		"nome_artisti" => array (),
		"nome_strumenti" => array (),
		"nome_genere" => array (),
		"n_canzoni" => array ()
	);
	$lista = array ("nome_band",
					"album_id",
					"nome_album",
					"nome_genere",
					"n_canzoni",
					"nome_artisti",
					"nome_strumenti"
	);
	$cont = 0;
	$Cn=mysql_connect();
	$link=mysql_connect("localhost","root","");
	if(!$link)
			die("Non riesco a connettermi:".mysql_error());
	$db_selected=mysql_select_db("metal",$link);
	if(!$db_selected)
			die("Errore nella selezione del DB".mysql_error());
	mysql_select_db("metal");
	$Query="select BA.nome as BNome, AL.album_id as AID, AL.titolo as ALTitolo, AR.nome as ARNome, ST.nome as STNome, GE.nome as GENome, count(*) as NCanzoni
			from band as BA, album as AL, canzoni as CA, band_genere as BAGE, genere as GE, band_artisti as BAAR, artisti as AR, artisti_strumenti as ARST, strumenti as ST
			where BA.band_id = AL.band_id and
				  BA.band_id = CA.band_id and
				  AL.album_id = CA.album_id and
				  BA.band_id = BAGE.band_id and
				  BAGE.genere_id = GE.genere_id and
				  BA.band_id = BAAR.band_id and
				  BAAR.artista_id = AR.artista_id and
				  AR.artista_id = ARST.artista_id and
				  ARST.strumento_id = ST.strumento_id and
				  BA.band_id = $band_id
			group by STNome, ARNome
			order by ST.strumento_id, ARNome";
	$result=mysql_query($Query);
	if(!$result) {
			die("Errore della query:".mysql_error());
	}
	while ($row = mysql_fetch_assoc($result)) {
/*			$album_id [$cont]= $row["AID"];
			$nome_band = $row["BNome"];
			$nome_album [$cont]= $row["ALTitolo"];
			$nome_artisti [$cont]= $row["ARNome"];
			$nome_strumenti [$cont]= $row["STNome"];
			$nome_genere = $row["GENome"];
			$n_canzoni = $row["NCanzoni"];*/
			$dati_db["nome_band"] [$cont] = $row["BNome"];
			$dati_db["album_id"] [$cont] = $row["AID"];
			$dati_db["nome_album"][$cont] = $row["ALTitolo"];
			$dati_db["nome_artisti"][$cont] = $row["ARNome"];
			$dati_db["nome_strumenti"][$cont] = $row["STNome"];
			$dati_db["nome_genere"][$cont] = $row["GENome"];
			$dati_db["n_canzoni"][$cont] = $row["NCanzoni"];
			$cont ++;
		}
	mysql_free_result($result);
	mysql_close();
	for ($ciclo = 0; $ciclo < count ($dati_db[$lista[0]]); $ciclo ++)
	{
		for ($interno = 0; $interno < count($lista); $interno ++)
		{
			echo $dati_db[$lista[$interno]][$ciclo]." | ";
		}
		echo "<br/>";
	}
	echo "<br/><br/><br/><br/><br/><br/>";
	$album_id = [];
	$nome_band = $dati_db["nome_band"][0];
	$nome_album = [];
	$nome_artisti = [];
	$nome_strumenti = [];
	$nome_genere = $dati_db["nome_genere"][0];
	$n_canzoni = $dati_db["n_canzoni"][0];
	$lista_finale = array (
		"nome_artisti" => array (),
		"nome_strumenti" => array ()
	);
	$cont1 = 0;
	$nome = array ("nome_artisti", "nome_strumenti");
	for ($asign = 0; $asign < count ($dati_db["nome_artisti"]); $asign ++)
	{
		$album_id [$asign] = $dati_db["album_id"][$asign];
		$nome_album [$asign] = $dati_db["nome_album"][$asign];
		$nome_artisti [$asign] = $dati_db["nome_artisti"][$asign];
		$nome_strumenti [$asign] = $dati_db["nome_strumenti"][$asign];
	}
	foreach ($nome_strumenti as $v1 => $k1)
	{
		foreach ($lista_finale as $v2 => $k2)
		{
			if ($v2 = $nome[1])
			{
				echo "$v2 => $k1 <br/>";
			}
		}
		echo "$v1 => $k1 <br/>";
	}
	echo "<br/><br/><br/><br/><br/><br/>";
	for ($x = 0; $x < count ($nome_artisti); $x ++)
	{
		echo $nome_band." | ".$album_id[$x]." | ".$nome_album[$x]." | ".$nome_genere." | ".$n_canzoni." | ".$nome_artisti[$x]." | ".$nome_strumenti[$x]." | <br/>";
	}
?>