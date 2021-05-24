<?php 
session_start();
include('../../includes/config.php');
if(isset($_POST['btnLogout'])){
  session_unset();
  header('location:'.$baseurl.'');
}if(!isset($_SESSION['dbu'])){ 
  header('location:'.$baseurl.'');
}

$pages ='patient/index';
?>

<?php include('../header.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Patient
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Patient</a></li>
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
                    <p><i class="icon fa fa-check"></i>  Record Successfully Added.</p>
                   
                  </div>';
        }if($_GET['status'] == 'updated'){
          echo '<div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p><i class="icon fa fa-info"></i>  Record Successfully Updated.</p>
                   
                  </div>';
        }if($_GET['status'] == 'deleted'){
          echo '<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p><i class="icon fa fa-remove"></i>  Record Successfully Deleted.</p>
                   
                  </div>';
        }
      }
    ?>
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <a href="add.php" class="btn btn-danger btn-md"><i class="fa fa-plus-circle"></i> Add Patient</a>
          </div>
          <div class="box-body">
            <table id="table1" class="table table-bordered">
              <thead>
                <tr>
                  <th>Case#</th>
                  <th>Firstname</th>
                  <th>Middlenae</th>
                  <th>Lastname</th>
                  <th>Age</th>
                  <th>Gender</th>
                  <th width="10%">Sitio/Prk./Str.</th>
                  <th>Barangay</th>
                  <th>Status</th>
                  <th>Date Updated</th>
                  <th width="10%">Action</th>
                </tr>
              </thead>
               <tbody>
                  <?php 
                    $sql = "SELECT p.case_no,p.id,p.firstname,p.middlename,p.lastname,p.dob,p.gender,p.phone,p.purok,b.name,p.status,p.timestamp FROM tbl_patient AS p INNER JOIN tbl_barangay AS b ON b.id = p.barangay_id ORDER BY timestamp ASC";
                    $qry = $connection->prepare($sql);
                    $qry->execute();
                    $qry->bind_result($dbcn,$id,$dbf,$dbm,$dbl,$dbd,$dbg,$dbp,$dbpurok,$dbbarangay,$dbstatus, $dbtimestamp);
                    $qry->store_result();
                    while($qry->fetch ()) {
                      echo"<tr>";
                      echo"<td>";
                      echo $dbcn;
                      echo"</td>";
                      echo"<td>";
                      echo $dbf;
                      echo"</td>";
                      echo"<td>";
                      echo $dbm;
                      echo"</td>";
                      echo"<td>";
                      echo $dbl;
                      echo"</td>";
                      echo"<td>";
                      echo $age = date_diff(date_create($dbd), date_create('now'))->y;;
                      echo"</td>";
                      echo"<td>";
                      echo $dbg;
                      echo"</td>";
                      echo"<td>";
                      echo $dbpurok;
                      echo"</td>";
                      echo"<td>";
                      echo $dbbarangay;
                      echo"</td>";
                      echo"<td class='text-center'>";
                      echo "<form method='POST' action='update_stat.php'  >";
                       if($dbstatus == 'Symptomatic'){
                         echo '<input type="hidden" name="id" value="'.$id.'">';
                         echo "<select name='chngstatus' class='form-control form-control-sm' onchange='this.form.submit()'>
                         <option value='' disabled>Select Status</option>
                         <option selected>Symptomatic</option>
                         <option>Asymptomatic</option>
                         <option>Recovered</option>
                         <option>Died</option>
                         </select>";
                       }if($dbstatus == 'Asymptomatic'){
                         echo '<input type="hidden" name="id" value="'.$id.'">';
                         echo "<select name='chngstatus' class='form-control form-control-sm' onchange='this.form.submit()'>
                         <option value='' disabled>Select Status</option>
                         <option >Symptomatic</option>
                         <option selected>Asymptomatic</option>
                         <option>Recovered</option>
                         <option>Died</option>
                         </select>";
                       }if($dbstatus == 'Recovered'){
                         echo '<input type="hidden" name="id" value="'.$id.'">';
                         echo "<select name='chngstatus' class='form-control form-control-sm' onchange='this.form.submit()'>
                         <option value='' disabled>Select Status</option>
                         <option >Symptomatic</option>
                         <option>Asymptomatic</option>
                         <option selected>Recovered</option>
                         <option>Died</option>
                         </select>";
                       }if($dbstatus == 'Died'){
                         echo '<input type="hidden" name="id" value="'.$id.'">';
                         echo "<select name='chngstatus' class='form-control form-control-sm' onchange='this.form.submit()'>
                         <option value='' disabled>Select Status</option>
                         <option >Symptomatic</option>
                         <option>Asymptomatic</option>
                         <option>Recovered</option>
                         <option selected>Died</option>
                         </select>";
                       }
                      echo "</form>";
                      echo"</td>";
                      echo"<td>";
                      echo $dbtimestamp;
                      echo"</td>";
                      echo"<td>";
                      echo '<a class="btn btn-info btn-sm" href="edit.php?id='.$id.'"><i class="fa fa-edit"></i></a>
                        <a href="delete.php?id='.$id.'" ';?>onclick="return confirm('Are you sure?')"<?php echo 'class="btn btn-danger btn-sm" ><i class="fa fa-remove"></i></a>';
                      echo"</td>";
                      echo"</tr>";
                    }

                  ?>
                </tbody>
            </table>
          </div>
        </div>
      </div>
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
