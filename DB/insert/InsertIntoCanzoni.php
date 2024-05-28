<!doctype html>
<html>
	<head>
		<title>Insert into Canzoni</title>
		<meta charset="UTF-8"/>
		<?php
			if (isset($_POST["canzoni"]) and isset($_POST["album_id"]))
			{
				$nome = $_POST["canzoni"];
				$album = $_POST["album_id"];
				$Cn=mysql_connect();
				$link=mysql_connect("localhost","root","");
				if(!$link)
						die("Non riesco a connettermi:".mysql_error());
				$db_selected=mysql_select_db("metalinspector",$link);
				if(!$db_selected)
						die("Errore nella selezione del DB".mysql_error());
				mysql_select_db("metalinspector");

				$Query = "select count(*) as NC from canzoni";
				$result=mysql_query($Query);
				if(!$result) {
						die("Errore della query:".mysql_error());
				}
				while ($row = mysql_fetch_assoc($result))
				{
					$cid = $row["NC"] + 4;
				}

				//$Query="insert into canzoni (titolo, band_id, album_id) values ('$nome', (select band_id from album where album_id = $album), $album)";
				$Query = "call insert_song ('$nome', $cid, $album)";
				$result=mysql_query($Query);
				if(!$result) {
						die("Errore della query: ".mysql_error());
				}
				mysql_close();
			}
		?>
		<style>
			table {
				width: 100%;
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
			<input type="text" name="canzoni" placeholder="Nome canzone" id="nome"/>
			<input type="number" name="album_id" placeholder="Album id"/>
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
			$Query="select C.canzone_id as CID, C.titolo as CTitolo, A.album_id as AID, A.titolo as Titolo, B.band_id as BID, B.nome as BNome
					from album as A, band as B, canzoni as C
					where A.band_id = B.band_id and
						  A.album_id = C.album_id and
						  C.band_id = B.band_id
					order by CID desc";
			$result=mysql_query($Query);
			if(!$result) {
					die("Errore della query:".mysql_error());
			}
			echo "<table>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>canzone_id</th>";
			echo "<th>Nome canzone</th>";
			echo "<th>album_id</th>";
			echo "<th>Nome album</th>";
			echo "<th>band_id</th>";
			echo "<th>Nome band</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			while ($row = mysql_fetch_assoc($result))
			{
				echo "<tr>";
				echo "<td>".$row["CID"]."</td>";
				echo "<td>".$row["CTitolo"]."</td>";
				echo "<td>".$row["AID"]."</td>";
				echo "<td>".$row["Titolo"]."</td>";
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