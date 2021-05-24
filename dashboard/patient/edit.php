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
  $sql = "SELECT id,case_no,firstname,middlename,lastname,dob,gender,purok,barangay_id,status,phone,case_type FROM tbl_patient WHERE id=?";
  $qry = $connection->prepare($sql);
  $qry->bind_param("i",$_GET['id']);
  $qry->execute();
  $qry->bind_result($id,$dbcn,$dbfn,$dbmn,$dbln,$dbdob,$dbgender,$dbpurok,$dbbarangay_id,$dbst,$dbph,$dbct);
  $qry->store_result();
  $qry->fetch ();
}
$pages = 'patient/index';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
        Edit Patient
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
                <label>Case # <i style="color:red">*</i></label>
                <input type="number" class="form-control" name="case_no" value="<?php echo $dbcn ?>" required>
                <label>Firstname <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="fname" value="<?php echo $dbfn ?>" required>
                <label>Middlename <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="mname" value="<?php echo $dbmn ?>" required>
                <label>Lastname <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="lname" value="<?php echo $dbln ?>" required>
                <label>Date of Birth <i style="color:red">*</i></label>
                <input type="date" class="form-control" name="dob" value="<?php echo $dbdob ?>" required>
                <label>Gender <i style="color:red">*</i></label>
                <select class="form-control" name="gender">
                  <option selected disabled value="">Select Gender</option>
                  <option <?php if($dbgender == 'Male'){echo 'selected';} ?>>Male</option>
                  <option <?php if($dbgender == 'Female'){echo 'selected';} ?>>Female</option>
                </select>
              </div>   
              <div class="col-md-6">
                <label>Sitio/Purok/Street <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="purok" value="<?php echo $dbpurok ?>" required>
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
                      if($dbbarangay_id == $dbid){
                        echo"<option selected value='".$dbid."'>".$dbn."</option>";
                      }else{
                        echo"<option value='".$dbid."'>".$dbn."</option>";
                      }
                    }
                      ?>
                </select>

                

                <label>Status<i style="color:red">*</i></label>
                <select class="form-control" name="status">
                  <option selected disabled value="">Select Status</option>
                  <option <?php if($dbst == 'Symptomatic'){echo 'selected';} ?>>Symptomatic</option>
                  <option <?php if($dbst == 'Asymptomatic'){echo 'selected';} ?>>Asymptomatic</option>
                  <option <?php if($dbst == 'Recovered'){echo 'selected';} ?>>Recovered</option>
                  <option <?php if($dbst == 'Died'){echo 'selected';} ?>>Died</option>
                </select>

                <label>Phone <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="phone" value="<?php echo $dbph ?>" placeholder="Ex.09123456789" required>

                <label>Case Type <i style="color:red">*</i></label>
                <select name="case_type" id="" required class="form-control">
                  <option value="">Select Case Type</option>
                  <option <?php if($dbct == 'LSI'){echo 'selected';} ?>>LSI</option>
                  <option <?php if($dbct == 'ROF'){echo 'selected';} ?>>ROF</option>
                  <option <?php if($dbct == 'APOR'){echo 'selected';} ?>>APOR</option>
                  <option <?php if($dbct == 'Other.'){echo 'selected';} ?>>Other.</option>
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

    
    $sql = "UPDATE tbl_patient SET case_no=?,firstname=?,middlename=?,lastname=?,dob=?,gender=?,purok=?,barangay_id=?,status=?,phone=? WHERE id=?";
    $qry = $connection->prepare($sql);
    $qry->bind_param("issssssissi",$_POST['case_no'],$_POST['fname'],$_POST['mname'],$_POST['lname'],$_POST['dob'],$_POST['gender'],$_POST['purok'],$_POST['barangay_id'],$_POST['status'],$_POST['phone'],$_GET['id']);
  
  
    if($qry->execute()) {
      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=updated">';
    }else{
      echo '<meta http-equiv="refresh" content="0; URL=edit.php?status=error">';
    }
}
?>