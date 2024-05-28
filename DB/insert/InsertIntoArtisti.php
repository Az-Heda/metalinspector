<!doctype html>
<html>
	<head>
		<title>Insert into Artisti</title>
		<meta charset="UTF-8"/>
		<?php
			if (isset($_POST["artisti"]))
			{
				$nome = $_POST["artisti"];
				$Cn=mysql_connect();
				$link=mysql_connect("localhost","root","");
				if(!$link)
						die("Non riesco a connettermi:".mysql_error());
				$db_selected=mysql_select_db("metalinspector",$link);
				if(!$db_selected)
						die("Errore nella selezione del DB".mysql_error());
				mysql_select_db("metalinspector");
				$Query="insert into artisti (nome) values ('$nome')";
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
			<input type="text" name="artisti" placeholder="Nome artisti" id="nome"/>
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
			$Query="select artista_id as ID, nome as Nome_Artisti from artisti order by ID";
			$result=mysql_query($Query);
			if(!$result) {
					die("Errore della query:".mysql_error());
			}
			echo "<table>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Artista_id</th>";
			echo "<th>Nome artista</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			while ($row = mysql_fetch_assoc($result))
			{
				echo "<tr>";
				echo "<td>".$row["ID"]."</td>";
				echo "<td>".$row["Nome_Artisti"]."</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
			mysql_free_result($result);
			mysql_close();
		?>
	</body>
</html>