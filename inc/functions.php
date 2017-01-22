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

function get_task_list($filter = null){
	include 'connection.php';

	$sql = "SELECT tasks.*,projects.title AS project FROM tasks INNER JOIN projects ON projects.project_id = tasks.project_id";

	$where = '';

	if(is_array($filter)){
		if($filter[0] == 'project'){
			$where = ' WHERE projects.project_id = ?';
		}
	}

	$orderBy = ' ORDER BY date DESC';

	if($filter){
		$orderBy = ' ORDER BY projects.title ASC, date DESC';
	}

	try{
		$results = $db->prepare($sql . $where . $orderBy);
		if(is_array($filter)){
			$results->bindValue(1,$filter[1],PDO::PARAM_INT);
		}
		$results->execute();
	}catch(Exception $e){
		echo "Error: " . $e->getMessage() . "</br>";
		return array();
	}

	return $results->fetchAll(PDO::FETCH_ASSOC);
}

function add_project($title, $category){
	include 'connection.php';

	$sql = "INSERT INTO projects(title,category) VALUES(?,?)";

	try{
		$results = $db->prepare($sql);
		$results->bindValue(1,$title,PDO::PARAM_STR);
		$results->bindValue(2,$category,PDO::PARAM_STR);
		$results->execute();

	}catch(Exception $e){
		echo "Error: ". $e->getMessage() . "<br />";
		return false;
	}

	return true;

}


function add_task($project_id, $title, $date, $time){
	include 'connection.php';

	$sql = 'INSERT INTO tasks(project_id,title,date,time) VALUES(?,?,?,?)';

	try{
		$results = $db->prepare($sql);
		$results->bindValue(1,$project_id,PDO::PARAM_INT);
		$results->bindValue(2,$title,PDO::PARAM_STR);
		$results->bindValue(3,$date);
		$results->bindValue(4,$time, PDO::PARAM_INT);
		$results->execute();

	}catch(Exception $e){
		echo "Error: ". $e->getMessage() . "<br />";
		return false;
	}

	return true;

}