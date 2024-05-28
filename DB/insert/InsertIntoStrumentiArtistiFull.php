<!doctype html>
<html>
	<head>
		<title>Insert into Artisti-Strumenti</title>
		<meta charset="UTF-8"/>
		<?php
			if (isset($_POST["artista"]) and isset($_POST["strumento"]) and isset($_POST["band"]))
			{
				$nome_artista = $_POST["artista"];
				$strumento_id = $_POST["strumento"];
				$band_id = $_POST["band"];
				$Query = [];
				$Query[0] = "insert into artisti (nome) values ('$nome_artista');";
				$Query[1] = "insert into artisti_strumenti (strumento_id, artista_id) values ($strumento_id, (select artista_id from artisti where nome = '$nome_artista'));";
				$Query[2] = "insert into band_artisti (band_id, artista_id) values ($band_id, (select artista_id from artisti where nome = '$nome_artista'));";
				$Cn=mysql_connect();
				$link=mysql_connect("localhost","root","");
				if(!$link)
						die("Non riesco a connettermi:".mysql_error());
				$db_selected=mysql_select_db("metalinspector",$link);
				if(!$db_selected)
						die("Errore nella selezione del DB".mysql_error());
				mysql_select_db("metalinspector");
				for ($x = 0; $x < count($Query); $x ++)
				{
					$result=mysql_query($Query[$x]);
					if(!$result) {
							die("Errore della query: ".mysql_error());
					}
				}
				mysql_close();
			}
			
		?>
		<style>
			table {
				width: 50%;
				text-align: center;
				text-transform: uppercase;
			}
			table tbody tr:hover {
				background-color: #444444;
				color: #ffffff;
			}
		</style>
	</head>
	<body onload="document.getElementById('nome').focus()">
		<form method="post">
			<input type="text" name="artista" placeholder="Nome artista" id="nome"/>
			<input type="number" name="strumento" placeholder="Strumento ID"/>
			<input type="number" name="band" placeholder="Band ID"/>
			<br/>
			<input type="submit" value="Inserisci dati"/>
		</form>
		<?php
			$Cn=mysql_connect();
			$link=mysql_connect("localhost","root","");
			if(!$link)
					die("Non riesco a connettermi:".mysql_error());
			$db_selected=mysql_select_db("metalinspector",$link);
			if(!$db_selected)
					die("Errore nella selezione del DB".mysql_error());
			mysql_select_db("metalinspector");
			$Query="select A.nome as ANome, S.nome as SNome, B.nome as BNome, A.artista_id as AID, S.strumento_id as SID, B.band_id as BID
					from strumenti as S, artisti_strumenti as ARST, artisti as A, band_artisti as BAAR, band as B
					where S.strumento_id = ARST.strumento_id and
						  ARST.artista_id = A.artista_id and
						  A.artista_id = BAAR.artista_id and
						  BAAR.band_id = B.band_id
						  order by A.artista_id desc;
					";
			$result=mysql_query($Query);
			if(!$result) {
					die("Errore della query:".mysql_error());
			}
			echo '<table style="width: 100%;">';
			echo "<thead>";
			echo "<tr>";
			echo "<th>Artista ID</th>";
			echo "<th>Nome artista</th>";
			echo "<th>Strumento_Id</th>";
			echo "<th>Nome strumento</th>";
			echo "<th>Band ID</th>";
			echo "<th>Nome band</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			while ($row = mysql_fetch_assoc($result))
			{
				echo "<tr>";
				echo "<td>".$row["AID"]."</td>";
				echo "<td>".$row["ANome"]."</td>";
				echo "<td>".$row["SID"]."</td>";
				echo "<td>".$row["SNome"]."</td>";
				echo "<td>".$row["BID"]."</td>";
				echo "<td>".$row["BNome"]."</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
			mysql_free_result($result);
			mysql_close();
		?>
	</body>
</html>