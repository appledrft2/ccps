<?php 
session_start();
include('../includes/config.php');
if(isset($_POST['btnLogout'])){
  session_unset();
  header('location:'.$baseurl.'');
}if(!isset($_SESSION['dbu'])){ 
  header('location:'.$baseurl.'');
}

$pages ='dashboard/index';
if(isset($_SESSION['dbu'])){
  $cid = 1;
  $sql = "SELECT name FROM tbl_city WHERE id=?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("i",$cid);
  $qry->execute();
  $qry->bind_result($dbcity);
  $qry->store_result();
  $qry->fetch ();
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Print | CCPS</title>
	<link rel="stylesheet" href="<?php echo $baseurl ?>template/dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?php echo $baseurl ?>template/dist/css/skins/_all-skins.min.css">
</head>
<body>

	<center>
	  <img src="http://localhost/ccps/city_logo.png" width="100px" style="border:1px solid white"><br>
	  <b style="text-transform: uppercase;">CITY COVID-19 PROFILING SYSTEM</b>
	  <p>
	    <b>CITY OF <?php echo strtoupper($dbcity); ?></b>	<br>
	  </p>
	  <p>LIST OF BARANGAY WITH COVID-19 CASES</p>

	</center>
	<table border="1" width="100%">
		<thead>
			<tr>
				<th>#</th>
				<th>Barangay</th>
				<th>Cases</th>
			</tr>
		</thead>
		<tbody>
			<?php
			  $cntr = $total = 0; 
			  $sql = "SELECT id,name FROM tbl_barangay ORDER BY name ASC";
			  $qry = $connection->prepare($sql);
			  $qry->execute();
			  $qry->bind_result($dbbid,$dbn);
			  $qry->store_result();
			  while($qry->fetch ()) {

			    $sql2 = "SELECT count(id) FROM tbl_patient WHERE barangay_id = ?";
			    $qry2 = $connection->prepare($sql2);
			    $qry2->bind_param("i",$dbbid);
			    $qry2->execute();
			    $qry2->bind_result($dbcount);
			    $qry2->store_result();

			    while($qry2->fetch ()) {
			    	$cntr++;
			    	$total = $total + $dbcount;
			      echo"<tr>
			      	<td style='text-align:center'>
			      	".$cntr."
			      	</td>
			      	<td style='text-align:center'>
			      	".$dbn."
			      	</td>			      	
			      	<td style='text-align:center'>
			      	".$dbcount."
			      	</td>

			      	</tr>";
			   
			    }
			 
			  }

			?>
		</tbody>
		<tfoot>
			<tr>
				<td></td>
				<td style="text-align:right"><b>Total Cases:</b></td>
				<td style="text-align:center"><?php echo $total; ?></td>

			</tr>
		</tfoot>
	</table>
</body>
</html>
<script type="text/javascript">
	window.print();
</script>
<?php echo '<meta http-equiv="refresh" content="0; URL=index.php">';  ?>