<?php 
session_start();
include('includes/config.php');
if(isset($_SESSION['dbu'])){ 
  header("location:".$baseurl."dashboard");
}
?>
<?php include('header.php'); ?>
<body class="hold-transition login-page" >
  
<div class="login-box">
  <div class="login-logo">
    <img src="city_logo.png" style="width:100px;height:100px;">
    <br>
    <a href="#" class="text-center">CITY COVID-19 PROFILING SYSTEM</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="login_process.php" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="form-group col-md-12">
          <button type="submit" name="btnLogin" class="btn btn-danger btn-block btn-flat">Login</button>
        </div>
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
  <?php 
    if(isset($_GET['error'])){
      echo "<br><span class='alert alert-danger col-md-12 '>Username or password does not match our records.</span>";
    }
  ?>
</div>
<!-- /.login-box -->
<?php include('footer.php'); ?>
</body>
</html>
