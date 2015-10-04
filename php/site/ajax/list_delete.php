<?php
$database = new SyncDatabase();
$column = array('employee'=>'emp_id','customer'=>'cus_id','object_rental'=>'object_id');
foreach($_POST['list_id'] as $id) {
	$database->Delete($_GET['table'],array($column[$_GET['table']]=>$id));
}
?>