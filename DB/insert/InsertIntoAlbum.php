<!doctype html>
<html>
	<head>
		<title>Insert into album</title>
		<meta charset="UTF-8"/>
		<?php
			if (isset($_POST["album"]))
			{
				$nome = $_POST["album"];
				$band = $_POST["band_id"];
				$pezzi = $_POST["n_pezzi"];
				$Cn=mysql_connect();
				$link=mysql_connect("localhost","root","");
				if(!$link)
						die("Non riesco a connettermi:".mysql_error());
				$db_selected=mysql_select_db("metalinspector",$link);
				if(!$db_selected)
						die("Errore nella selezione del DB".mysql_error());
				mysql_select_db("metalinspector");
				$Query="insert into album (titolo, band_id, n_pezzi) values ('$nome', $band, $pezzi)";
				$result=mysql_query($Query);
				if(!$result) {
						die("Errore della query: ".mysql_error());
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
			<input type="text" name="album" placeholder="Nome album" id="nome"/>
			<input type="number" name="band_id" placeholder="Band id"/>
			<input type="number" name="n_pezzi" placeholder="Num pezzi"/>
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
			$Query="select A.album_id as AID, A.titolo as Titolo, B.band_id as BID, B.nome as BNome
					from album as A, band as B
					where A.band_id = B.band_id
					order by A.album_id desc";
			$result=mysql_query($Query);
			if(!$result) {
					die("Errore della query:".mysql_error());
			}
			echo "<table>";
			echo "<thead>";
			echo "<tr>";
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