<?php 
session_start();
include('../../includes/config.php');
if(isset($_POST['btnLogout'])){
  session_unset();
  header('location:'.$baseurl.'');
}
if(!isset($_SESSION['dbu'])){ 

  header('location:'.$baseurl.'');
} 
if(isset($_SESSION['dbu'])){
  $cid = 1;
  $sql = "SELECT id,name FROM tbl_city WHERE id=?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("i",$cid);
  $qry->execute();
  $qry->bind_result($dbid,$dbn);
  $qry->store_result();
  $qry->fetch ();
}
$pages = 'city/index';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        System Settings
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> System Settings</a></li>
        <li class="active">Index</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">
       <?php 
      if(isset($_GET['status'])){
        if($_GET['status'] == 'created'){
          echo '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p><i class="icon fa fa-check"></i>  Settings Successfully Added.</p>
                   
                  </div>';
        }if($_GET['status'] == 'updated'){
          echo '<div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p><i class="icon fa fa-info"></i>  Settings Successfully Updated.</p>
                   
                  </div>';
        }if($_GET['status'] == 'deleted'){
          echo '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p><i class="icon fa fa-remove"></i>  Settings Successfully Deleted.</p>
                   
                  </div>';
        }
      }
    ?>
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header"></div>
            <div class="box-body">
              <form method="POST" action="#">
              <div class="col-md-6">
                <label>City Name <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="name" value="<?php echo $dbn; ?>" required>

              </div>

              
            </div>
            <div class="box-footer">
              <div class="pull-right">
              
                <button name="btnSave" class="btn btn-danger" > Save Changes</button>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
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

<?php include('footer.php') ?>

<?php 
if(isset($_POST['btnSave'])){

   
    $sql = "UPDATE tbl_city SET name=? WHERE id=?";
    $qry = $connection->prepare($sql);
    $qry->bind_param("si",$_POST['name'],$dbid);
    
  
    if($qry->execute()) {
      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=updated">';
    }else{
      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=error">';
    }
}
?>