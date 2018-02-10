<?php

class Action {

	function Action () {
	}

	//Détachement d'une base
	function detach_db($base) {
		global $page, $db;

		$query = "EXEC sp_detach_db '$base'";
		$db->displayQuery($query);
		if (!$db->query($query)) {
			$page->msgError("Database <b>$base</b> not detached");
		} else {
			$page->msgInfo("Database <b>$base</b> detached");
		}	
	}

	//DB attach
	function attach_db($base, $files) {
		global $page, $db;
		
		$file_opt = Array();
		foreach ($files as $no_file => $file_path)  {
			if (empty($file_path)) continue;
			$file_opt[] = '@filename' . $no_file . '=\'' . $file_path . '\'';
		}
		
		
		$query = "EXEC sp_attach_db @dbname='$base', " . implode(',', $file_opt);
		
		
		$db->displayQuery($query);
		if (!$db->query($query)) {
			$page->msgError("Database <b>$base</b> not attached");
		} else {
			$page->msgInfo("Database <b>$base</b> attached");
		}	
	}

	//Suppression d'une base
	function delete_db($base) {
		global $page, $db;
		
		$query = "EXEC sp_dbremove '$base'";
		$db->displayQuery($query);
		if (!$db->query($query)) {
			$page->msgError("Database <b>$base</b> not deleted");
		} else {
			$page->msgInfo("Database <b>$base</b> deleted");
		}	
	}

	//Create db
	function create_db($base, $sys, $log, $data) {
		global $page, $db;

		
		
		$query = "EXEC sp_create_removable @dbname='$base', @syslogical='".$sys['logical']."', @sysphysical='".$sys['physical']."', @syssize=".$sys['size'].", @loglogical='".$log['logical']."', @logphysical='".$log['physical']."', @logsize=".$log['size']."";
		
		foreach($data as $key => $data_file) {
			if (empty($data_file['logical']) or empty($data_file['physical'])) continue;
			$query .= ", @datalogical$key='".$data_file['logical']."', @dataphysical$key='".$data_file['physical']."', @datasize$key=".$data_file['size']." ";	
		}
		
		$db->displayQuery($query);
		if (!$db->query($query)) {
			$page->msgError("Database <b>$base</b> not created");
		} else {
			$page->msgInfo("Database <b>$base</b> created");
		}	
	}

	//empty table
	function empty_table($table) {
		global $page, $db;

		$query = "DELETE FROM $table";
		$db->displayQuery($query);
		if ($db->query($query)) {
			$page->msgInfo("<b>".$db->rows_affected()."</b> record(s) deleted");
		}	
	}
	
	//Suppression d'une table
	function drop_table($table) {
		global $page, $db;
		
		$query = "DROP TABLE $table";
		$db->displayQuery($query);
		if (!$db->query($query)) {
			$page->msgError("Table not deleted");
		} else {
			$page->msgInfo("Table deleted");
		}
	}

	//Creation d'une table
	function create_table($table, $field, $field_name, $field_type, $field_length, $field_scale, $field_null, $field_id, $field_id_start, $field_id_step, $field_default, $field_pkey) {
		global $page, $db;

		if (!empty($table)) {
			$query = 'CREATE TABLE ' . $table;

			$columns = Array ();
			$pkeys = Array();
			foreach ($field as $key => $val) {
				if (empty($field_name[$key])) continue;

				$column = $field_name[$key] . ' ';
                $type = $field_type[$key];

			    $row = $db->getTypeInfo($type);

				//Precision, length

				//Does not work with some data types, ex : decimal() identity
				$arg_create = explode(',', $row['CREATE_PARAMS']);
				$nb_params = count($arg_create);
				$to_add = '';
				if (!empty($row['CREATE_PARAMS'])) {
					if ($nb_params == 2) {
						$to_add = ' ('.$field_length[$key] . ','.$field_scale[$key] . ') ';
					}
					if ($nb_params == 1) {
						$to_add = ' ('.$field_length[$key] . ') ';
					}
				}
				
				echo $nb_params;
				if (ereg("\(\)", $type)) {
					echo 1;
					$column .= ereg_replace("\(\)", $to_add, $type);					
				} else {
					echo 2;
					$column .= $type . $to_add;
				}

				//Identity
					if (eregi(" identity$", $type)) {
						$column .= ' ('.$field_id_start[$key] . ','.$field_id_step[$key] . ') ';
					}

				//Null
					if (empty($field_null[$key])) {
						$column .= ' NOT NULL ';
					} else {
						$column .= ' NULL ';
					}

				//Default value
					if (!empty($field_default[$key])) {
						$column .= ' DEFAULT ' . $row['LITERAL_PREFIX'] . stripslashes($field_default[$key]) . $row['LITERAL_SUFFIX'] . ' ';
					}

				//Primary keys
					if (!empty($field_pkey[$key])) {
						$pkeys[] = $field_name[$key];
					}

					$columns[] = $column;
			}
			if (count($pkeys) > 0) {
				$columns[] = ' PRIMARY KEY ( ' . implode (', ', $pkeys) . ') ';
			}
			$query = $query . " (\n".implode(",\n", $columns) . "\n)";
			$affichage="table_created";

			$db->displayQuery($query);
			if (!$db->query($query)) {
				$page->msgError("The table has not been created");
			} else {
				$page->msgInfo("Table created");
			}

		} else {
			$affichage = 'full_form';
			$page->msgError("A table must have a name");
		}

	}

	//Suppression d'un champ
	function drop_field($table, $field) {
		global $page, $db;

		$query = "ALTER TABLE $table DROP COLUMN $field";

		$db->displayQuery($query);
		if (!$db->query($query)) {
			$page->msgError("Field not deleted");
		} else {
			$page->msgInfo("Field deleted");
		}
	}

	//Modification d'un champ
	function alter_field($table, $field, $field_type, $field_length, $field_null) {
		global $page, $db;

		foreach($field as $field_ori => $val) {
			$query = "ALTER TABLE $table ALTER COLUMN $field_ori ";

			$query .= $field_type[$field_ori] . ' ';

			if (!empty($field_length[$field_ori])) {
				$query .= '('. $field_length[$field_ori] . ') ';
			}

			
			if (empty($field_null[$field_ori])) {
				$query .= ' NOT NULL ';
			} else {
				$query .= ' NULL ';
			}			
			$db->displayQuery($query);
			$db->query($query);
		}
	}
	
	//Edition d'un enregistrement
	function edit_record($table, $where, $lst_column_name, $type_name, $is_null, $lst_value, $data_type, $data_function) {
		global $page, $db, $config;
		
		$query_base = 'UPDATE ';
		$query_fields = Array();
		
		foreach ($lst_column_name as $column_name) {
			
			//On voit si on doit y faire quelque chose
			if (ereg("identity", $type_name[$column_name])) {
				continue;	
			}
			
			
			if (!empty($is_null[$column_name])) {
				$value = 'NULL';
			} else {
				$value = $lst_value[$column_name];
				
				if ($config['type'][$data_type[$column_name]] == 'text') {
					$value = "'$value'";
				}
				if (!empty($data_function[$column_name])) {
					$value = $data_function[$column_name] . '(' . $value . ')';
				}
				
			}
			$query_fields[] = $column_name . ' = ' . $value;
		}
		
		
		
		$query = 'UPDATE ' . $table . ' SET ' . implode(', ', $query_fields) . ' WHERE ' . $where;
		$db->displayQuery($query);
		if ($db->query($query)) {
			$page->msgInfo("Data saved");
		}
	}

	//Suppression d'un enregistrement
	function delete_record($table, $where) {
		global $page, $db;
		
		$query = "DELETE FROM $table WHERE $where";

		$db->displayQuery($query);
		if (!$db->query($query)) {
			$page->msgError("Record not deleted");
		} else {
			$page->msgInfo("Record deleted");
		}
	}

	function new_record($table, $lst_column_name, $type_name, $is_null, $lst_value, $data_type, $data_function) {
		global $page, $db, $config;
		
		$query_base = 'INSERT INTO ';
		$query_fields = Array();
		$query_values = Array();
		
		foreach ($lst_column_name as $column_name) {
			//echo "<b>$column_name</b><br>";
			
			//On voit si on doit y faire quelque chose
			if (ereg("identity", $type_name[$column_name])) {
				//echo '[ignored]<hr>';
				continue;	
			}
			
			$query_fields[] = $column_name;
			if (!empty($is_null[$column_name])) {
				$value = 'NULL';
			} else {
				$value = $lst_value[$column_name];
				
				if ($config['type'][$data_type[$column_name]] == 'text') {
					$value = "'$value'";
				}
				if (!empty($data_function[$column_name])) {
					$value = $data_function[$column_name] . '(' . $value . ')';
				}
				
			}
			$query_values[] = $value;
			
		}
		
		
		
		$query = $query_base .' ' . $table . ' (' . implode(', ', $query_fields) . ') VALUES (' . implode(',', $query_values) . ')';
		$db->displayQuery($query);
		if ($db->query($query)) {
			$page->msgInfo("Data saved");
		}
		
	}
	
}

?>
