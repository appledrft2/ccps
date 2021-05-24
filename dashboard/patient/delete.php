<?php 
session_start();
include('../../includes/config.php');
if(isset($_SESSION['dbu'])){ 
 
	if(isset($_GET['id'])){
		$sql = "DELETE FROM tbl_patient WHERE id=?";
		$qry = $connection->prepare ($sql);
		$qry->bind_param("i",$_GET['id']);
		if($qry->execute()){
			header('location:index.php?status=deleted');
  }
}
}else{
  header('location:'.$baseurl.'');
} 


?>