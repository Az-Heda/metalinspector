<!doctype html>
<html>
	<head>
		<title>Insert into Artisti-Strumenti</title>
		<meta charset="UTF-8"/>
		<?php
			if (isset($_POST["artisti"]) and isset($_POST["strumenti"]))
			{
				$artista_id = $_POST["artisti"];
				$strumento_id = $_POST["strumenti"];
				$Cn=mysql_connect();
				$link=mysql_connect("localhost","root","");
				if(!$link)
						die("Non riesco a connettermi:".mysql_error());
				$db_selected=mysql_select_db("metalinspector",$link);
				if(!$db_selected)
						die("Errore nella selezione del DB".mysql_error());
				mysql_select_db("metalinspector");
				$Query="insert into artisti_strumenti (strumento_id, artista_id) values ($strumento_id, $artista_id)";
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
			<input type="number" name="artisti" placeholder="Artista ID" id="nome"/>
			<input type="number" name="strumenti" placeholder="Strumento ID"/>
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
			$Query="select artista_id as AID, strumento_id as SID from artisti_strumenti order by AID";
			$result=mysql_query($Query);
			if(!$result) {
					die("Errore della query:".mysql_error());
			}
			echo "<table>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Artista_id</th>";
			echo "<th>Strumento_Id</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			while ($row = mysql_fetch_assoc($result))
			{
				echo "<tr>";
				echo "<td>".$row["AID"]."</td>";
				echo "<td>".$row["SID"]."</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
			mysql_free_result($result);
			mysql_close();
		?>
	</body>
</html>