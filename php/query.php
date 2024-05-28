<?php	
	function conversione_query ($sql)
	{
		$ban = [];
		$ban[0] = "'";
		$ban[1] = '"';
		$query = '';
		$char = [];
		$result = false;
		for ($as = 0; $as < strlen($sql); $as ++)
		{
			$char[$as] = substr($sql, $as, 1);
			//echo "Carattere: ".$char[$as]."<br/>";
		}
		for ($x = 0; $x < count($char); $x ++)
		{
			for ($y = 0; $y < count($ban); $y ++)
			{
				//echo "if (".$char[$x]." == ".$ban[$y].")<br/>";
				if ($char[$x] == $ban[$y])
				{
					$char[$x] = "\\".$ban[$y];
					//echo "Corrispondenza trovata<br/>";
				}
			}
		}
		foreach ($char as $k=>$v)
		{
			$query .= $v;
		}
		return $query;
	}
	function controllo_stringa ($str)
	{
		$output = mysql_real_escape_string($str);
	}
/*	function controllo_query($sql)
	{
		$ban = [];
		$ban[0] = "'";
		$ban[1] = '"';
		$char = [];
		$result = false;
		for ($as = 0; $as < strlen($sql); $as ++)
		{
			$char[$as] = substr($sql, $as, 0);
		}
		for ($x = 0; $x < count($char); $x ++)
		{
			for ($y = 0; $y < count($ban); $y ++)
			{
				if ($char[$x] == $ban[$y])
				{
					$result = true;
				}
			}
		}
		return result;
	}*/
	
	//Stored procedures:
	
	//Devo lanciare 2 query, la prima è;
	/*		DELIMITER $$

			DROP PROCEDURE IF EXISTS insert_utenti $$
			CREATE PROCEDURE insert_utenti (us text, psw text)
			BEGIN
				insert into utenti(username, password) values (us, psw);
			END $$

			DELIMITER ;
			-- Poi la chiamo con "call $nome_procedura($parametri)"
			call insert_utenti("Ciao", "PASSWORD1");
	*/
	//Scritta su una riga è cosi:
	//DELIMITER $$ DROP PROCEDURE IF EXISTS insert_utenti $$ CREATE PROCEDURE insert_utenti (us text, psw text)  BEGIN insert into utenti(username, password) values (us, psw); END $$ DELIMITER ;
?>