<!doctype html>
<html>
	<head>
		<title>Insert into Genere</title>
		<meta charset="UTF-8"/>
		<?php
			if (isset($_POST["genere"]))
			{
				$nome = $_POST["genere"];
				$Cn=mysql_connect();
				$link=mysql_connect("localhost","root","");
				if(!$link)
						die("Non riesco a connettermi:".mysql_error());
				$db_selected=mysql_select_db("metalinspector",$link);
				if(!$db_selected)
						die("Errore nella selezione del DB".mysql_error());
				mysql_select_db("metalinspector");
				$Query="insert into genere (nome) values ('$nome')";
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
			<input type="text" name="genere" placeholder="Nome genere" id="nome"/>
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
			$Query="select genere_id as ID, nome as Nome_Genere from genere order by ID";
			$result=mysql_query($Query);
			if(!$result) {
					die("Errore della query:".mysql_error());
			}
			echo "<table>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Genere_id</th>";
			echo "<th>Nome genere</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			while ($row = mysql_fetch_assoc($result))
			{
				echo "<tr>";
				echo "<td>".$row["ID"]."</td>";
				echo "<td>".$row["Nome_Genere"]."</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
			mysql_free_result($result);
			mysql_close();
		?>
	</body>
</html>