<?php 
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
date_default_timezone_set('Asia/Manila');
 ?>
<!DOCTYPE html>

<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>City COVID-19 Profiling System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Morris charts -->
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/lib/morris.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/dist/css/skins/_all-skins.min.css">
  <!-- Pace style -->
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/plugins/pace/pace.min.css">
  <link rel="icon" type="image/png" href="<?php echo $baseurl ?>city_logo.png"/>

  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo $baseurl ?>template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">CCPS</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?php echo $dbcity; ?> City</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
             
              <span class="hidden-xs"><?php echo 'Welcome, '.$_SESSION['dbg'].' '.$_SESSION['dbl'].' ('.$_SESSION['dbtype'].')' ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
             
              <!-- Menu Footer-->
              <li class="user-footer">
                <a href="<?php echo $baseurl; ?>/dashboard/settings.php" class="btn btn-block btn-default btn-flat">User Settings</a>
                  <form method="POST" action="#">
                      <button name="btnLogout" class="btn btn-block btn-default btn-flat">Logout</button>
                  </form>
              </li>
            </ul>
          </li>
         
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

    
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header text-center">MAIN NAVIGATION</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="<?php if($pages == 'dashboard/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl ?>dashboard/index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        
        <li class="treeview <?php if($pages == 'barangay/index' || $pages == 'barangay/add'){echo 'active'; } ?>">
          <a href="#"><i class="fa fa-university"></i> <span>Manage Barangay</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($pages == 'barangay/add'){echo 'active'; } ?>"><a href="<?php echo $baseurl ?>dashboard/barangay/add.php"><i class="fa fa-plus-circle"></i> Add Barangay</a></li>
            <li class="<?php if($pages == 'barangay/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl ?>dashboard/barangay/index.php"><i class="fa fa-list"></i> List of Barangay</a></li>
          </ul>
        </li>
         <li class="treeview <?php if($pages == 'patient/index' || $pages == 'patient/add'){echo 'active'; } ?>">
          <a href="#"><i class="fa fa-users"></i> <span>Manage Patient</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($pages == 'patient/add'){echo 'active'; } ?>"><a href="<?php echo $baseurl ?>dashboard/patient/add.php"><i class="fa fa-plus-circle"></i> Add Patient</a></li>
            <li class="<?php if($pages == 'patient/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl ?>dashboard/patient/index.php"><i class="fa fa-list"></i> Patient List</a></li>
          </ul>
        </li>
         <li class="treeview <?php if($pages == 'user/index' || $pages == 'user/add'){echo 'active'; } ?>" <?php if($_SESSION['dbtype'] == 'Nurse'){ echo 'style="display:none;"';} ?>>
          <a href="#"><i class="fa fa-key"></i> <span>Manage Users</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($pages == 'user/add'){echo 'active'; } ?>"><a href="<?php echo $baseurl ?>dashboard/users/add.php"><i class="fa fa-plus-circle"></i> Add User</a></li>
            <li class="<?php if($pages == 'user/index'){echo 'active'; } ?>"><a href="<?php echo $baseurl ?>dashboard/users/index.php"><i class="fa fa-list"></i> User List</a></li>
          </ul>
        </li>
        <li class="<?php if($pages == 'city/index'){echo 'active'; } ?>" <?php if($_SESSION['dbtype'] == 'Nurse'){ echo 'style="display:none;"';} ?>><a href="<?php echo $baseurl; ?>dashboard/city/index.php"><i class="fa fa-cog"></i> <span>System Settings</span></a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
