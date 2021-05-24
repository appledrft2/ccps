<?php 
session_start();
include('../includes/config.php');
if(isset($_POST['btnLogout'])){
  session_unset();
  header('location:'.$baseurl.'');
}if(!isset($_SESSION['dbu'])){ 
  header('location:'.$baseurl.'');
}

if(isset($_POST['btnSet'])){
  $sqlz = "UPDATE tbl_notify SET value=?";
  $qryz = $connection->prepare($sqlz);
  $qryz->bind_param("i",$_POST['value']);
  $qryz->execute();
}

$pages ='dashboard/index';
?>

<?php include('header.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Index</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      <div style="float:left"><a href="print.php" class="btn btn-md btn-danger"><i class="fa fa-print"></i> Print</a></div>

      <?php 
        $sqlx = "SELECT value FROM tbl_notify";
        $qryx = $connection->prepare($sqlx);
        $qryx->execute();
        $qryx->bind_result($notify);
        $qryx->store_result();
        $qryx->fetch ();
      ?>

      <div style="float:right">
      	<div class="form-inline">
          
      	<form method="POST" action="#"><label for="">Set Lockdown notifier: </label><input type="text" class="form-control" name="value" value="<?= $notify; ?>" placeholder="# of cases to lockdown"><button type="submit" name="btnSet" class="btn  btn-danger"> Set</button></form>
      </div></div>
      <br>
      <br>
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">CONFIRMED COVID-19 CASES AS OF <?php echo strtoupper(date('F Y')); ?> (Barangay)</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body chart-responsive">
          
         <div class="box-body chart-responsive">
            <div class="chart" id="bar-chart" style="height: 300px;"></div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <div id="notifier">
      	<?php 
      	  $sql = "SELECT id,name FROM tbl_barangay ORDER BY name ASC";
      	  $qry = $connection->prepare($sql);
      	  $qry->execute();
      	  $qry->bind_result($dbbid,$dbn);
      	  $qry->store_result();
      	  while($qry->fetch ()) {

      	    $sql2 = "SELECT count(id) FROM tbl_patient WHERE status != 'Recovered' AND barangay_id = ?";
      	    $qry2 = $connection->prepare($sql2);
      	    $qry2->bind_param("i",$dbbid);
      	    $qry2->execute();
      	    $qry2->bind_result($dbcount);
      	    $qry2->store_result();

      	    while($qry2->fetch ()) {
      	      if($dbcount >= $notify){
      	      	echo '<div class="alert alert-danger alert-dismissible">
      	      	                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      	      	                    <p><i class="icon fa fa-warning"></i>Lockdown Recommended: <b>Brgy.'.ucfirst($dbn).'</b> has recorded more than '.$dbcount.' positive individuals for COVID-19.</p></div>';
      	      }
      	   
      	    }
      	 
      	  }

      	?>
      </div>
      <div class="row">

        <?php 
          $sql = "SELECT id,name FROM tbl_barangay ORDER BY name ASC";
          $qry = $connection->prepare($sql);
          $qry->execute();
          $qry->bind_result($dbbid,$dbname);
          $qry->store_result();
          while($qry->fetch ()) {

            $bgyid = $dbbid;
      
            $sql2 = "SELECT status,id,count(id) FROM tbl_patient WHERE barangay_id = ? ORDER BY barangay_id ASC ";
            $qry2 = $connection->prepare($sql2);
            $qry2->bind_param("i",$dbbid);
            $qry2->execute();
            $qry2->bind_result($dbst,$dbbid,$dbcount);
            $qry2->store_result();

            while($qry2->fetch ()) {
              if($dbcount >= 1){
             
                

                

                echo '<div class="col-md-3">
                      <!-- DONUT CHART -->

                      <div class="box box-success">
                        <div class="box-header with-border">
                          <h3 class="box-title">Brgy. '.$dbname.' (Individuals)</h3>

                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                          </div>
                        </div>
                        <div class="box-body chart-responsive">
                          <div class="chart" id="dunot-chart-'.$dbbid.'" style="height: 200px; position: relative;"></div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">';
                    
                          
                          $sql3 = "SELECT status,count(*) FROM tbl_patient WHERE barangay_id = ? GROUP BY status";
                          $qry3 = $connection->prepare($sql3);
                          $qry3->bind_param("i",$bgyid);
                          $qry3->execute();
                          $qry3->bind_result($dbstt,$dbas);
                          $qry3->store_result();
                          while($qry3->fetch ()){

                            echo "<br><b>$dbstt</b><br>";
                            $sql4 = "SELECT case_type,count(*) FROM tbl_patient WHERE status = ? AND barangay_id = ?";
                            $qry4 = $connection->prepare($sql4);
                            $qry4->bind_param("si",$dbstt,$bgyid);
                            $qry4->execute();
                            $qry4->bind_result($dbsttt,$dbass);
                            $qry4->store_result();
                            while($qry4->fetch ()){

                              echo "$dbsttt: <b>$dbass</b>";                            
                            

                            }
                          
                          

                          }

                   
                           
                        

                          
                       echo '</div>

                      </div>
                      <!-- /.box -->
                    </div>';
              }
              
            }
         
          }

        ?>
        
        
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs"><b>
      <?php echo date('l, F d Y') ?></b>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2021 <a href="#">CCPS</a>.</strong> All rights reserved.
  </footer>

  
</div>
<!-- ./wrapper -->
<?php include('footer.php'); ?>
<script>
  $(function () {
    "use strict";


    <?php 
          $sql = "SELECT id,name FROM tbl_barangay ORDER BY name ASC";
          $qry = $connection->prepare($sql);
          $qry->execute();
          $qry->bind_result($dbbid,$dbname);
          $qry->store_result();
          while($qry->fetch ()) {
        
            $sql2 = "SELECT id,count(id) FROM tbl_patient WHERE barangay_id = ? ORDER BY barangay_id ASC";
            $qry2 = $connection->prepare($sql2);
            $qry2->bind_param("i",$dbbid);
            $qry2->execute();
            $qry2->bind_result($dbid,$dbcount);
            $qry2->store_result();

            while($qry2->fetch ()) {
              if($dbcount > 0){
                $output = array();
                //DONUT CHART 
                echo 'var donut'.$dbid.' = new Morris.Donut({
                  element: "dunot-chart-'.$dbid.'",
                  resize: true,
               
                  data: [';
                $sql3 = "SELECT status,count(*) FROM tbl_patient WHERE barangay_id = ? GROUP BY status";
                $qry3 = $connection->prepare($sql3);
                $qry3->bind_param("i",$dbbid);
                $qry3->execute();
                $qry3->bind_result($dbstt,$dbas);
                $qry3->store_result();
                while($qry3->fetch ()){

                echo '{label: "'.$dbstt.'", value: '.$dbas.'},';
                
                if($dbstt == 'Asymptomatic'){
                  array_push($output,'#f56954');
                }if($dbstt == 'Symptomatic'){
                  array_push($output,'#f56954');

                }if($dbstt == 'Recovered'){
                  array_push($output,'#5cb85c');

                }if($dbstt == 'Died'){
                  array_push($output,'#ccc');
    
                } 

                }

               echo   '],
                  colors: '.json_encode($output).',
                  hideHover: "auto",

                });';
                 
              }
            }
          }

    ?>
  

    //BAR CHART
    var bar = new Morris.Bar({
      element: 'bar-chart',
      resize: true,
      data: [

        <?php 
          $sql = "SELECT id,name FROM tbl_barangay ORDER BY name ASC";
          $qry = $connection->prepare($sql);
          $qry->execute();
          $qry->bind_result($dbbid,$dbn);
          $qry->store_result();
          while($qry->fetch ()) {

            $sql2 = "SELECT count(id) FROM tbl_patient WHERE  status != 'Recovered' AND barangay_id = ?";
            $qry2 = $connection->prepare($sql2);
            $qry2->bind_param("i",$dbbid);
            $qry2->execute();
            $qry2->bind_result($dbcount);
            $qry2->store_result();

            while($qry2->fetch ()) {

              echo" {y: '".$dbn."', a: ".$dbcount."},";
           
            }
         
          }

        ?>
      

      ],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Confirmed Cases'],
      hideHover: 'auto',
      xLabelAngle: 60,
      barColors: function(row, series, type) {
          if(series.key == 'a')
          {
            if(row.y >= <?= $notify; ?>)
              return "#822317";
            else
              return "#f56954";  
          }
          
       }

    });
  });
</script>