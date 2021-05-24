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
$pages ='patient/add';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Patient
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Patient</a></li>
        <li class="active">Add</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php 
        if(isset($_GET['status'])){
          if($_GET['status'] == 'created'){
            echo '<div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-check"></i>  Record Successfully Added.</p>
                     
                    </div>';
          }if($_GET['status'] == 'updated'){
            echo '<div class="alert alert-info alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-info"></i>  Record Successfully Updated.</p>
                     
                    </div>';
          }if($_GET['status'] == 'error'){
            echo '<div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <p><i class="icon fa fa-remove"></i>  Error: There is a problem in saving the record.</p>
                     
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
                <label>Case #<i style="color:red">*</i></label>
                <input type="number" class="form-control" name="case_no" required>
                <label>Firstname <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="fname" required>
                <label>Middlename <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="mname" required>
                <label>Lastname <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="lname" required>
                <label>Date of Birth <i style="color:red">*</i></label>
                <input type="date" class="form-control" name="dob" required>
                <label>Gender <i style="color:red">*</i></label>
                <select class="form-control" name="gender">
                  <option selected disabled value="">Select Gender</option>
                  <option>Male</option>
                  <option>Female</option>
                </select>
              </div>   
              <div class="col-md-6">
                <label>Sitio/Purok/Street<i style="color:red">*</i></label>
                <input type="text" class="form-control" name="purok" required>
                <label>Barangay<i style="color:red">*</i></label>
                <select class="form-control" name="barangay_id">
                  <option selected disabled value="">Select Barangay</option>
                  <?php 
                    $sql = "SELECT id,name FROM tbl_barangay ORDER BY name ASC";
                    $qry = $connection->prepare($sql);
                    $qry->execute();
                    $qry->bind_result($dbid,$dbn);
                    $qry->store_result();
                    while($qry->fetch ()) {
                      echo"<option value='".$dbid."'>".$dbn."</option>";
                    }
                      ?>
                </select>

                

                <label>Status<i style="color:red">*</i></label>
                <select class="form-control" name="status">
                  <option selected disabled value="">Select Status</option>
                  <option>Symptomatic</option>
                  <option>Asymptomatic</option>
                  <option>Recovered</option>
                  <option>Died</option>
                </select>

                <label>Phone <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="phone" placeholder="Ex.09123456789" required>


                <label>Case Type <i style="color:red">*</i></label>
                <select name="case_type" id="" required class="form-control">
                	<option value="">Select Case Type</option>
                	<option>LSI</option>
                	<option>ROF</option>
                	<option>APOR</option>
                	<option>Other.</option>
                </select>


            


              </div>   
            </div>
            <div class="box-footer">
              <div class="pull-right">
                <a href="<?php echo $baseurl; ?>dashboard/patient" class="btn btn-default" > Go Back</a>
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
    <strong>Copyright &copy; 2020-2021 <a href="#">CCPS</a>.</strong> All rights
    reserved.
  </footer>

</div>
<!-- ./wrapper -->

<?php include('footer.php') ?>

<?php 
if(isset($_POST['btnSave'])){

    $sql = "INSERT INTO tbl_patient(case_no,firstname,middlename,lastname,dob,gender,purok,barangay_id,status,phone,case_type) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
    $qry = $connection->prepare($sql);
    $qry->bind_param("issssssisss",$_POST['case_no'],$_POST['fname'],$_POST['mname'],$_POST['lname'],$_POST['dob'],$_POST['gender'],$_POST['purok'],$_POST['barangay_id'],$_POST['status'],$_POST['phone'],$_POST['case_type']);

    if($qry->execute()) {
    
      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=created">';
    }else{
      
      echo '<meta http-equiv="refresh" content="0; URL=add.php?status=error">';

    }
}
?>