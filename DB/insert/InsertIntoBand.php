<!doctype html>
<html>
	<head>
		<title>Insert into Band</title>
		<meta charset="UTF-8"/>
		<?php
			if (isset($_POST["nome_band"]) and isset($_POST["genere_id"]))
			{
				$band = $_POST["nome_band"];
				$genere = $_POST["genere_id"];
				$Query[0] = "insert into band (nome) values ('$band')";
				$Query[1] = "insert into band_genere (band_id, genere_id) values ((select band_id from band where nome = '$band'), $genere)";
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
			<input type="text" name="nome_band" placeholder="Nome band" id="nome"/>
			<input type="number" name="genere_id" placeholder="Genere ID"/>
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
			$Query="select B.band_id as BID, B.nome as BNome, G.genere_id as GID, G.nome as GNome
					from band as B, band_genere as BG, genere as G
					where B.band_id = BG.band_id and
						  BG.genere_id = G.genere_id
					order by BID desc";
			$result=mysql_query($Query);
			if(!$result) {
					die("Errore della query:".mysql_error());
			}
			echo "<table>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Band_id</th>";
			echo "<th>Nome band</th>";
			echo "<th>Genere_id</th>";
			echo "<th>Nome genere</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			while ($row = mysql_fetch_assoc($result))
			{
				echo "<tr>";
				echo "<td>".$row["BID"]."</td>";
				echo "<td>".$row["BNome"]."</td>";
				echo "<td>".$row["GID"]."</td>";
				echo "<td>".$row["GNome"]."</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
			mysql_free_result($result);
			mysql_close();
		?>
	</body>
</html>