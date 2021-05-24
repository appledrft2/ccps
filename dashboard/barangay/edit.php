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
if(isset($_GET['id'])){
  $sql = "SELECT id,name FROM tbl_barangay WHERE id=?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("i",$_GET['id']);
  $qry->execute();
  $qry->bind_result($id,$dbn);
  $qry->store_result();
  $qry->fetch ();
}
$pages = 'barangay/index';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
        Edit Barangay
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Barangay</a></li>
        <li class="active">Edit</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header"></div>
            <div class="box-body">
              <form method="POST" action="#">
              <div class="col-md-6">
                <label>Barangay Name <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="name" value="<?php echo $dbn; ?>" required>
                
              </div>
              
              
            </div>
            <div class="box-footer">
              <div class="pull-right">
                <a href="<?php echo $baseurl; ?>dashboard/barangay" class="btn btn-default" > Go Back</a>
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
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.18
    </div>
    <strong>Copyright &copy; 2020-2021 <a href="#">Bath & Bark Grooming and Veterinary Services Management System</a>.</strong> All rights
    reserved.
  </footer>

</div>
<!-- ./wrapper -->

<?php include('footer.php') ?>

<?php 
if(isset($_POST['btnSave'])){

    
    $sql = "UPDATE tbl_barangay SET name=? WHERE id=?";
    $qry = $connection->prepare($sql);
    $qry->bind_param("si",$_POST['name'],$_GET['id']);
  
  
    if($qry->execute()) {
      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=updated">';
    }else{
      echo '<meta http-equiv="refresh" content="0; URL=edit.php?status=error">';
    }
}
?>