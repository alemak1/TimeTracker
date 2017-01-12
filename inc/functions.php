<?php
//application functions

function get_project_list(){
	include 'connection.php';


	try{
		return $db->query("
			SELECT project_id,title,category 
			FROM projects");
	}catch(Exception $e){
		echo "Error: " . $e->getMessage() . "</br>";
		return array();
	}
}