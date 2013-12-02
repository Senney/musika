<?php

require_once "database.config.php";

// Enable error reporting for all pages that make use of the database.
@ini_set('display_errors', '1');
error_reporting(E_ALL);

/**
 * Returns a link to the mysql server.
 **/
function get_mysqli_link() {
	$link = mysqli_connect(dbConfig::$server, dbConfig::$username,
		dbConfig::$password, dbConfig::$database);
	if (mysqli_connect_error()) {
		printf("Connection failed: %s\n", mysqli_connect_error());
		exit(1);
	}
	return $link;
}

// Source: http://php.net/manual/en/mysqli.prepare.php
// Author: User/Darren
// Accessed: December 1st, 2013.
/**
 * Prepares a query and sends it down the specified link.
 * Arguments:
 * 	$link - The mysqli link.
 *  $sql  - The SQL query.
 *  $typeDef - The types of the arguments being passed in.
 *  $params  - The parameters to be inserted into the query.
 * Returns:
 *  An array of 0 or more elements, each element containing an array
 *  of the returned columns indexed by the column title.
 * Example:
 * 	$query = "SELECT * FROM names WHERE lastName=?"; 
	$params = array("Smith"); 

	mysqli_prepared_query($link,$query,"s",$params) 

	returns array( 
	0=> array('firstName' => 'John', 'lastName' => 'Smith') 
	1=> array('firstName' => 'Mark', 'lastName' => 'Smith') 
	) 
 **/
function mysqli_prepared_query($link,$sql,$typeDef = FALSE,$params = FALSE){ 
  if($stmt = mysqli_prepare($link,$sql)){ 
    if(count($params) == count($params,1)){ 
      $params = array($params); 
      $multiQuery = FALSE; 
    } else { 
      $multiQuery = TRUE; 
    }  
    
    if($typeDef){ 
      $bindParams = array();    
      $bindParamsReferences = array(); 
      $bindParams = array_pad($bindParams,(count($params,1)-count($params))/count($params),"");         
      foreach($bindParams as $key => $value){ 
        $bindParamsReferences[$key] = &$bindParams[$key];  
      } 
      array_unshift($bindParamsReferences,$typeDef); 
      $bindParamsMethod = new ReflectionMethod('mysqli_stmt', 'bind_param'); 
      $bindParamsMethod->invokeArgs($stmt,$bindParamsReferences); 
    } 
    
    $result = array(); 
    foreach($params as $queryKey => $query){ 
      foreach($bindParams as $paramKey => $value){ 
        $bindParams[$paramKey] = $query[$paramKey]; 
      } 
      $queryResult = array(); 
      if(mysqli_stmt_execute($stmt)){ 
        $resultMetaData = mysqli_stmt_result_metadata($stmt); 
        if($resultMetaData){                                                                               
          $stmtRow = array();   
          $rowReferences = array(); 
          while ($field = mysqli_fetch_field($resultMetaData)) { 
            $rowReferences[] = &$stmtRow[$field->name]; 
          }                                
          mysqli_free_result($resultMetaData); 
          $bindResultMethod = new ReflectionMethod('mysqli_stmt', 'bind_result'); 
          $bindResultMethod->invokeArgs($stmt, $rowReferences); 
          while(mysqli_stmt_fetch($stmt)){ 
            $row = array(); 
            foreach($stmtRow as $key => $value){ 
              $row[$key] = $value;           
            } 
            $queryResult[] = $row; 
          } 
          mysqli_stmt_free_result($stmt); 
        } else { 
          $queryResult[] = mysqli_stmt_affected_rows($stmt); 
        } 
      } else { 
        $queryResult[] = FALSE; 
      } 
      $result[$queryKey] = $queryResult; 
    } 
    mysqli_stmt_close($stmt);   
  } else { 
    $result = FALSE; 
  } 
  
  if($multiQuery){ 
    return $result; 
  } else { 
    return $result[0]; 
  } 
}

?>
