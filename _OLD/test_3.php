<?php
	$band_id = $_GET["band_id"];
	$album_id = [];
	$nome_band;
	$nome_album = [];
	$nome_artisti = [];
	$nome_strumenti = [];
	$nome_genere = [];
	$genere_id = [];
	$n_canzoni = [];
	$cont1 = 0;
	$cont2 = 0;
	$cont3 = 0;
	$Cn=mysql_connect();
	$link=mysql_connect("localhost","root","");
	if(!$link)
			die("Non riesco a connettermi:".mysql_error());
	$db_selected=mysql_select_db("metal",$link);
	if(!$db_selected)
			die("Errore nella selezione del DB".mysql_error());
	mysql_select_db("metal");
	$Query1 = "select B.nome as BNome, A.titolo as ATitolo, A.album_id as AID, count(*) as NCanzoni
				from band as B, album as A, canzoni as C
				where B.band_id = A.band_id and
					  B.band_id = C.band_id and
					  C.album_id = A.album_id and
					  B.band_id = $band_id
				group by ATitolo
				order by ATitolo;";
	$Query2 = "select GE.genere_id GID, GE.nome as GNome
				from band_genere as BG, genere as GE
				where BG.genere_id = GE.genere_id and
					  BG.band_id = $band_id
				order by GID;";
	$Query3 = "select A.nome as ANome, S.nome as SNome
				from artisti as A, strumenti as S, artisti_strumenti as ARST, band_artisti as BAAR
				where BAAR.artista_id = A.artista_id and
					  A.artista_id = ARST.artista_id and
					  ARST.strumento_id = S.strumento_id and
					  BAAR.band_id = $band_id
				order by S.strumento_id, A.Nome";
	echo "-- Risultati delle select: <br/>";
	$result1=mysql_query($Query1);
	if(!$result1) {
			die("Errore della query:".mysql_error());
	}
	echo "<br/>-- Select n: 1 <br/><br/>";
	while ($row1 = mysql_fetch_assoc($result1)) {
			$nome_band = $row1["BNome"];
			$nome_album[$cont1] = $row1["ATitolo"];
			$album_id[$cont1] = $row1["AID"];
			$n_canzoni[$cont1] = $row1["NCanzoni"];
			echo $nome_band." | ".$nome_album[$cont1]." | ".$album_id[$cont1]." | ".$n_canzoni[$cont1]."<br/>";
			$cont1 ++;
		}
	$result2=mysql_query($Query2);
	if(!$result2) {
			die("Errore della query:".mysql_error());
	}
	echo "<br/>-- Select n: 2 <br/><br/>";
	while ($row2 = mysql_fetch_assoc($result2)) {
			$genere_id[$cont2] = $row2["GID"];
			$nome_genere[$cont2] = $row2["GNome"];
			echo $genere_id[$cont2]." | ".$nome_genere[$cont2]."<br/>";
			$cont2 ++;
		}
	$result3=mysql_query($Query3);
	if(!$result3) {
			die("Errore della query:".mysql_error());
	}
	echo "<br/>-- Select n: 3 <br/><br/>";
	while ($row3 = mysql_fetch_assoc($result3)) {
			$nome_artisti[$cont3] = $row3["ANome"];
			$nome_strumenti[$cont3] = $row3["SNome"];
			echo $nome_artisti[$cont3]." | ".$nome_strumenti[$cont3]."<br/>";
			$cont3 ++;
		}
	mysql_free_result($result1);
	mysql_free_result($result2);
	mysql_free_result($result3);
	mysql_close();
	echo "<br/>";
	echo "<br/>";
	echo "<br/>";
	echo "<br/>";
	echo "<br/>";
	echo "<br/>";
	for ($x = 0; $x < $cont1; $x ++)
	{
		$prezzo = $n_canzoni[$x] * 0.90;
		echo $nome_band." | ".$nome_album[$x]." | ".$album_id[$x]." | ".$n_canzoni[$x]." | ".number_format($prezzo, 2, '.', '')."€<br/>";
	}
	echo "<br/>";
	echo "<br/>";
	echo "<br/>";
	echo "<br/>";
	echo "<br/>";
	for ($y = 0; $y < $cont2; $y ++)
	{
		echo $genere_id[$y]. " | ".$nome_genere[$y]."<br/>";
	}
	echo "<br/>";
	echo "<br/>";
	echo "<br/>";
	echo "<br/>";
	echo "<br/>";
	for ($z = 0; $z < $cont3; $z ++)
	{
		echo $nome_artisti[$z]." | ".$nome_strumenti[$x]."<br/>";
	}
?>