<?php

class Mssql {
	var $host = '';
	var $user = '';
	var $pass = '';
	var $base = '';
	var $type_lst = Array ();
	var $connexion;

	function Mssql () {
		//Verification si mssql est bien chargé par php,
		//sinon, on essaye avec dl()
	}

	function connect ($host, $user, $pass) {
		if ($connexion = @mssql_connect($host, $user, $pass)) {
			$this->connexion = $connexion;

			$this->host = $host;
			$this->pass = $pass;
			$this->user = $user;
		}
		return $connexion;
	}

	function select_db($base) {
		//$base = ($base);
		//echo $base;
		if( @mssql_select_db ( $base, $this->connexion)) {
			$this->base = $base;
		} else {
			$this->msg('SELECT_DB : ' . mssql_get_last_message());
		}
	}
	
	function close() {
		mssql_close($this->connexion);
	}

	function query($query) {
		$query = stripslashes($query);
		$result = @mssql_query($query);
		if (!$result) {
			$this->msg('QUERY : ' . mssql_get_last_message() . '<br>' . $query );
		}
		return $result;
	}
	
	function num_rows($result) {
		$num = mssql_num_rows($result);
		return $num;
	}

	function fetch_array($result) {
		$row = mssql_fetch_array ($result);
		return $row;
	}


	function fetch_field($result) {
		$row = mssql_fetch_field ($result);
		return $row;
	}

	function result($result, $i, $field) {
		$value = mssql_result($result, $i, $field);
		return $value;
	}
	
	function rows_affected() {
		$value = mssql_rows_affected($this->connexion);
		return $value;
	}

	function next_result($result) {
		mssql_next_result($result);
	}

	function msg ($text) {
      echo '<table border="0" cellspacing="1" cellpadding="2" bgcolor="#DD0000" align="center" width="300">
             <tr class="titre">
              <td><font color="#FFFFFF"><b>Erreur</b></font></td>
             </tr>
             <tr class="contenu">
              <td bgcolor="#FFFFFF">'.$text.'</td>
             </tr>
           </table>';
	}

	function displayQuery($query) {
		echo '<code>'.stripslashes(nl2br($query)).'</code> ';
		echo '<a href="db_exec_sql.php?base='.$this->base.'&sql_query_text='.$query.'">Edit</a>';
		echo '<br>';
	}

	//Retoune les infos sur un type de données
	function getTypeInfo($type='') {
        $this->defineTypeInfo();
		if (!empty($type)) {
            return ($this->type_lst[$type]);
    	} else {
            return ($this->type_lst);
    	}
	}

	//Get all data type info
	function defineTypeInfo() {
         if (empty($this->type_lst)) {
			$result = $this->query("EXEC sp_datatype_info", $this->connexion);
			while ($row = $this->fetch_array($result)) {
				$this->type_lst[$row['TYPE_NAME']] = $row;
			}
		 }
	}

	//Retourne des infos sur les colonnes d'une table
	function getColumnType($table, $field = '') {
		if (!empty($field)) {
			$result = $this->query("EXEC sp_columns @table_name = '$table', @column_name='$field'");
			$row = $this->fetch_array($result);
			return($row);
		} else {
			$fields = Array();
			$result = $this->query("EXEC sp_columns @table_name = '$table'");
			while ($row = $this->fetch_array($result)) {
				$fields[$row['COLUMN_NAME']] = $row;
			}
			return($fields);
		}
	}

	//Retoune les infos sur un type de données
	function getPrimaryKeys($table) {
		$primarykeys = Array();

		$result = $this->query("EXEC sp_tables @table_name = '$table'");
		$row = $this->fetch_array($result);

		$result2 = $this->query("EXEC sp_primarykeys '".$this->host."', '".$table."','".$row['TABLE_OWNER']."','".$this->base."'");
		while ($row2 = $this->fetch_array($result2)) {
			$primarykeys[] = $row2['COLUMN_NAME'];
		}
		return $primarykeys;
	}


}
?>