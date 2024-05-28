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
		$lista_finale = array (
		"nome_band" => array ($dati_db["nome_band"][0]),
		"album_id" => array ($dati_db["album_id"][0]),
		"nome_album" => array ($dati_db["nome_album"][0]),
		"nome_artisti" => array ($dati_db["nome_artisti"][0]),
		"nome_strumenti" => array ($dati_db["nome_strumenti"][0]),
		"nome_genere" => array ($dati_db["nome_genere"][0]),
		"n_canzoni" => array ($dati_db["n_canzoni"][0])
	);
	mysql_free_result($result);
	mysql_close();
	for ($ciclo = 0; $ciclo < count ($lista_finale[$lista[0]]); $ciclo ++)
	{
		for ($interno = 0; $interno < count($lista); $interno ++)
		{
			echo $lista_finale[$lista[$interno]][$ciclo]." | ";
		}
		echo "<br/>";
	}
?>