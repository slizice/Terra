<?php

class ThingData {
    
    static function add($type) {

        /* Connect to the database. */
        $dbc = mysql_pconnect(__DB_HOST, __DB_USER, __DB_PASS);

        /* Specify database instance using config constant. */
        mysql_select_db(__DB_INSTANCE);

        /* Escape parameters to prevent injection. */
        $type = mysql_real_escape_string($type);

        /* Resolve empty strings to null. */
        $type = empty($type) ? 'null' : "'" . $type . "'";

        /* Construct insert statement. */
        $query = "INSERT INTO thing (`type`)
                  VALUES (IFNULL($type,null))";

        /* Execute query. */
        mysql_query($query);

        /* The ID of the newly created thing. */
        $thing_id = mysql_insert_id();

        /* Close MySQL connection. */
        mysql_close();
        
        /* Return the ID of the new thing. */
        return $thing_id;
    }
    
    static function remove($thing_id) {
        
        /* Connect to the database. */
        $dbc = mysql_pconnect(__DB_HOST, __DB_USER, __DB_PASS);

        /* Specify database instance using config constant. */
        mysql_select_db(__DB_INSTANCE);

        /* Escape parameters to prevent injection. */
        $thing_id = mysql_real_escape_string($thing_id);

        /* Resolve empty strings to null. */
        $thing_id = empty($thing_id) ? 'null' : "'" . $thing_id . "'";

        /* Construct delete statement for thing. */
        $query = "DELETE FROM thing
                  WHERE `thing_id` = $thing_id";

        /* Execute query. */
        mysql_query($query);
       
        /* Close MySQL connection. */
        mysql_close();
    }
	
	static function all($type) { 
	
		/* Connect to the database. */
		$dbc = mysql_pconnect(__DB_HOST, __DB_USER, __DB_PASS); 
	
		/* Specify database instance using config constant. */ 
		mysql_select_db(__DB_INSTANCE); 
	
		/* Escape parameters to prevent injection. */
		$type = mysql_real_escape_string($type); 
	
		/* Resolve empty strings to null. */ 
		$type = empty($type) ? 'null' : "'" . $type . "'"; 
	
		/* Construct select statement for thing data. */
		$query = "SELECT `id`, `type` 
			FROM `thing` 
			WHERE `type` = $type 
			ORDER BY `id`";
	
		/* Execute query. */ 
		$result = mysql_query($query); 
	
		/* Create an array to store the results of the query. */
		$return_array = array(); 
	
		/* Push each line onto the return array. */
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) { 
			array_push($return_array, $row); 
		} 
	
		/* Free resources. */ 
		mysql_free_result($result); 
		mysql_close(); 
		
		/* Return an associative array */ 
		return $return_array; 
	}

	static function random($type, $limit) { 
	
		/* Connect to the database. */
		$dbc = mysql_pconnect(__DB_HOST, __DB_USER, __DB_PASS); 
	
		/* Specify database instance using config constant. */ 
		mysql_select_db(__DB_INSTANCE); 
	
		/* Escape parameters to prevent injection. */
		$type = mysql_real_escape_string($type); 
	
		/* Resolve empty strings to null. */ 
		$type = empty($type) ? 'null' : "'" . $type . "'"; 
	
		/* Construct select statement for thing data. */
		$query = "SELECT `id`, `type` 
			FROM `thing` 
			WHERE `type` = $type 
			ORDER BY RAND( ) LIMIT $limit";
	
		/* Execute query. */ 
		$result = mysql_query($query); 
	
		/* Create an array to store the results of the query. */
		$return_array = array(); 
	
		/* Push each line onto the return array. */
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) { 
			array_push($return_array, $row); 
		} 
	
		/* Free resources. */ 
		mysql_free_result($result); 
		mysql_close(); 
		
		/* Return an associative array */ 
		return $return_array; 
	}
}

class DataData {
    
    static function add($thing_id, $key, $value) {

        /* Connect to the database. */
        $dbc = mysql_pconnect(__DB_HOST, __DB_USER, __DB_PASS);

        /* Specify database instance using config constant. */
        mysql_select_db(__DB_INSTANCE);

        /* Escape parameters to prevent injection. */
        $thing_id = mysql_real_escape_string($thing_id);
        $key = mysql_real_escape_string($key);
        $value = mysql_real_escape_string($value);

        /* Resolve empty strings to null. */
        $thing_id = empty($thing_id) ? 'null' : "'" . $thing_id . "'";
        $key = empty($key) ? 'null' : "'" . $key . "'";
        $value = empty($value) ? 'null' : "'" . $value . "'";

        /* Construct insert statement. */
        $query = "INSERT INTO data (`thing_id`, `key`, `value`)
                  VALUES (IFNULL($thing_id, null),
                          IFNULL($key, null),
                          IFNULL($value, null))";

        /* Execute query. */
        mysql_query($query);
        
        /* Close MySQL connection. */
        mysql_close();
    }
    
    static function remove($thing_id) {
        
        /* Connect to the database. */
        $dbc = mysql_pconnect(__DB_HOST, __DB_USER, __DB_PASS);

        /* Specify database instance using config constant. */
        mysql_select_db(__DB_INSTANCE);

        /* Escape parameters to prevent injection. */
        $thing_id = mysql_real_escape_string($thing_id);

        /* Resolve empty strings to null. */
        $thing_id = empty($thing_id) ? 'null' : "'" . $thing_id . "'";
       
        /* Construct delete statement for thing data. */
        $query = "DELETE FROM data
                  WHERE `thing_id` = $thing_id";

        /* Execute query. */
        mysql_query($query);
        
        /* Close MySQL connection. */
        mysql_close();
    }

    static function exists($thing_id, $key) {

        /* Connect to the database. */
        $dbc = mysql_pconnect(__DB_HOST, __DB_USER, __DB_PASS);

        /* Specify database instance using config constant. */
        mysql_select_db(__DB_INSTANCE);

        /* Escape parameters to prevent injection. */
        $thing_id = mysql_real_escape_string($thing_id);
        $key = mysql_real_escape_string($key);

        /* Resolve empty strings to null. */
        $thing_id = empty($thing_id) ? 'null' : "'" . $thing_id . "'";
        $key = empty($key) ? 'null' : "'" . $key . "'";
       
        /* Construct delete statement for thing data. */
        $query = "SELECT COUNT(*) AS data_count
                  FROM data
                  WHERE `thing_id` = $thing_id
                  AND `key` = $key";

        /* Execute query. */
        $result = mysql_query($query);
        
        /* Fetch the query result. */
        $data_count = mysql_fetch_array($result, MYSQL_ASSOC);
        
        /* Free resources. */
        mysql_free_result($result);
        
        /* Close MySQL connection. */
        mysql_close();
        
        /* Return 'y' or 'n'. */
        return ($data_count['data_count'] > 0) ? true : false;
    }

    static function find($thing_id, $key) {

        /* Connect to the database. */
        $dbc = mysql_pconnect(__DB_HOST, __DB_USER, __DB_PASS);

        /* Specify database instance using config constant. */
        mysql_select_db(__DB_INSTANCE);

        /* Escape parameters to prevent injection. */
        $thing_id = mysql_real_escape_string($thing_id);
        $key = mysql_real_escape_string($key);

        /* Resolve empty strings to null. */
        $thing_id = empty($thing_id) ? 'null' : "'" . $thing_id . "'";
        $key = empty($key) ? 'null' : "'" . $key . "'";
       
        /* Construct delete statement for thing data. */
        $query = "SELECT `value` AS value
		  		  FROM `data`
                  WHERE `thing_id` = $thing_id
                  AND `key` = $key";

        /* Execute query. */
        $result = mysql_query($query);
 
        /* Fetch the query result. */
        $value = mysql_fetch_array($result, MYSQL_ASSOC);
        
        /* Free resources. */
        mysql_free_result ($result);
        
        /* Close MySQL connection. */
        mysql_close();
        
        /* Return the value */
        return $value;
    }

	// Find thing ID based on a key/ value pair 
	static function find_thing_ID($key, $value, $limit) {
	
		/* Connect to the database. */ 
		$dbc = mysql_pconnect(__DB_HOST, __DB_USER, __DB_PASS); 
		
		/* Specify database instance using config constant. */
		mysql_select_db(__DB_INSTANCE);
		
		/* Escape parameters to prevent injection. */
		$value = mysql_real_escape_string($value);
		$key = mysql_real_escape_string($key); 
		
		/* Resolve empty strings to null. */ 
		$value = empty($value) ? 'null' : "'" . $value . "'"; 
		$key = empty($key) ? 'null' : "'" . $key . "'";
		
		// TODO: Get multiples!!!!
		
		/* Construct delete statement for thing data. */ 
		$query = "SELECT `thing_id` AS thing_id 
			FROM `data` 
			WHERE `key` = $key AND `value` = $value
			ORDER BY RAND()
			LIMIT $limit"; 
		
		/* Execute query. */ 
		$result = mysql_query($query); 
		
		/* Create an array to store the results of the query. */
		$return_array = array();
		
		/* Push each line onto the return array. */
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			array_push($return_array, $row);
		}
		   
		/* Free resources. */
		mysql_free_result($result);
		mysql_close();
		
		/* Return an associative array of results. */
		return $return_array;
	}


static function all($thing_id) { 
	/* Connect to the database. */ 
	$dbc = mysql_pconnect(__DB_HOST, __DB_USER, __DB_PASS); 
	
	/* Specify database instance using config constant. */ 
	mysql_select_db(__DB_INSTANCE); 
	
	/* Escape parameters to prevent injection. */ 
	$thing_id = mysql_real_escape_string($thing_id); 
	
	/* Construct delete statement for thing data. */ 
	$query = "SELECT `key` , `value` FROM `data` WHERE `thing_id` = $thing_id"; 
	
	/* Execute query. */ 
	$result = mysql_query($query); 
	
	/* Create an array to store the results of the query. */ 
	$return_array = array(); 
	
	/* Push each line onto the return array. */ 
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) { 
		array_push($return_array, $row); 
	} 
	/* Free resources. */ 
	mysql_free_result($result); 
	mysql_close(); 
	
	/* Return an associative array */ 
	return $return_array; 
}

   static function random($thing_id, $key, $limit) { 
   /* Connect to the database. */ 
   $dbc = mysql_pconnect(__DB_HOST, __DB_USER, __DB_PASS); 
   /* Specify database instance using config constant. */ 
   mysql_select_db(__DB_INSTANCE); 
   /* Escape parameters to prevent injection. */ 
   $key = mysql_real_escape_string($key); 
   /* Resolve empty strings to null. */ 
   $key = empty($key) ? 'null' : "'" . $key . "'"; 
   /* Construct delete statement for thing data. */ 
   $query = "SELECT `key` , `value` FROM `data` WHERE `thing_id` = $thing_id AND `key` = $key ORDER BY RAND( ) LIMIT $limit"; 
   /* Execute query. */ 
   $result = mysql_query($query); 
   /* Create an array to store the results of the query. */ 
   $return_array = array(); 
   /* Push each line onto the return array. */ 
   while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) { array_push($return_array, $row); } 
   /* Free resources. */ 
   mysql_free_result($result); mysql_close(); 
   /* Return an associative array */ 
   return $return_array; 
   }
 
    static function update($thing_id, $key, $value) {
        
        /* Connect to the database. */
        $dbc = mysql_pconnect(__DB_HOST, __DB_USER, __DB_PASS);

        /* Specify database instance using config constant. */
        mysql_select_db(__DB_INSTANCE);

        /* Escape parameters to prevent injection. */
        $thing_id = mysql_real_escape_string($thing_id);
        $key = mysql_real_escape_string($key);
        $value = mysql_real_escape_string($value);

        /* Resolve empty strings to null. */
        $thing_id = empty($thing_id) ? 'null' : "'" . $thing_id . "'";
        $key = empty($key) ? 'null' : "'" . $key . "'";
        $value = empty($value) ? 'null' : "'" . $value . "'";
       
        /* Construct delete statement for thing data. */
        $query = "UPDATE `data`
                  SET `key` = $key,
                  `value` = $value,
                  WHERE `thing_id` = $thing_id";

        /* Execute query. */
        mysql_query($query);
        
        /* Close MySQL connection. */
        mysql_close();
    }
}


?>
