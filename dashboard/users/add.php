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
$pages ='user/add';
?>
<?php include('../header.php'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add User
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Barangay</a></li>
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
                <label>Firstname <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="fname" required>
                <label>Lastname <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="lname" required>
                <label>Gender <i style="color:red">*</i></label>
                <select class="form-control" name="gender">
                  <option selected disabled value="">Select Gender</option>
                  <option>Male</option>
                  <option>Female</option>
                </select>
              </div>
              <div class="col-md-6">
                <label>User Type <i style="color:red">*</i></label>
                <select class="form-control" name="type">
                  <option selected disabled value="">Select Type</option>
                  <option>Nurse</option>
                  <option>Admin</option>
                </select>
                <label>Phone <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="phone" required>
                <label>Email <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="email" required>
                <hr>
                <label>User Account</label>
                <hr>
                <label>Username <i style="color:red">*</i></label>
                <input type="text" class="form-control" name="username" required>
                <label>Password <i style="color:red">*</i></label>
                <input type="password" class="form-control" name="password" required>
              </div>
              
            </div>
            <div class="box-footer">
              <div class="pull-right">
                <a href="<?php echo $baseurl; ?>dashboard/users" class="btn btn-default" > Go Back</a>
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
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO tbl_user(firstname,lastname,gender,type,phone,email,username,password) VALUES(?,?,?,?,?,?,?,?)";
    $qry = $connection->prepare($sql);
    $qry->bind_param("ssssssss",$_POST['fname'],$_POST['lname'],$_POST['gender'],$_POST['type'],$_POST['phone'],$_POST['email'],$_POST['username'],$hashed_password);

    if($qry->execute()) {
    
      echo '<meta http-equiv="refresh" content="0; URL=index.php?status=created">';
    }else{
      
      echo '<meta http-equiv="refresh" content="0; URL=add.php?status=error">';

    }
}
?>