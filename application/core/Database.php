<?php

class Database extends PDO {

	public function __construct() {
	
	}

	public function connect($db) {

		$db = $this->prependDB($db);
		if(!(defined($db . '_USER'))) {
		    
		    return null;
		}

		try {
		    $dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' .  $db, constant($db . '_USER'), constant($db . '_PASSWORD'));
		    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		    $sth = $dbh->prepare(CHAR_ENCODING_SCHEMA);
			$sth->execute();

		    return $dbh;
		}
		catch(PDOException $e) {

		    echo $e->getMessage();
		    return null;
	    }
	}

	public function createDB($db, $schema) {

		$db = $this->prependDB($db);
		try {
		    $dbh = new PDO('mysql:host=' . DB_HOST . ';', constant($db . '_USER'), constant($db . '_PASSWORD'));
		    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    
		    $schema = str_replace(':db', $db, $schema);

			$sth = $dbh->prepare($schema);
			$sth->execute();
		}
		catch(PDOException $e) {
		    echo $e->getMessage();
	    }
	}

	public function createTable($table, $dbh, $schema) {
	
		$sth = $dbh->prepare($schema);
		$sth->execute();
	}

	public function dropTable($table, $dbh) {
	
		$sth = $dbh->prepare('DROP TABLE IF EXISTS '. $table);
		$sth->execute();
	}

	public function insertData($table, $dbh, $data) {

		// Take list of keys as in schema and data
	    $keys = implode(', ', array_keys($data));
	    // form unnamed placeholders with count number of ? marks
	    $bindValues =  str_repeat('?, ', count($data) - 1) . ' ?';
	    $sth = $dbh->prepare('INSERT INTO ' . $table . ' (' . $keys .') VALUES (' . $bindValues . ')');

		$sth->execute(array_values($data));
	}

	public function deleteDataByID($table, $dbh, $id) {

		// This method deletes a row based on id alone
		
	    $sth = $dbh->prepare('DELETE FROM ' . $table . ' WHERE id = :id');
	    $sth->bindParam(':id', $id);
		$sth->execute();
	}

	public function deleteData($table, $dbh, $data) {

		// This method deletes a row. If data does not exist, now warnings are returned
		
	    $deleteSQL = '';

	    foreach ($data as $key => $value) {

	    	$deleteSQL .= $key . ' = :' . $key . ' AND ';
	    }
	    $deleteSQL = preg_replace('/ AND $/', '', $deleteSQL);

	    $sth = $dbh->prepare('DELETE FROM ' . $table . ' WHERE ' . $deleteSQL);
		$sth->execute($data);
	}

	public function executeQuery($dbh = null, $query = '') {

	    $sth = $dbh->prepare($query);
		$sth->execute();
	}

	public function prependDB($db = DEFAULT_JOURNAL) {

		return $db;
	}
}

?>
