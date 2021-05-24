<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="<?php echo $baseurl ?>template/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $baseurl ?>template/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->

<script src='<?php echo $baseurl ?>template/lib/raphael.min.js' ></script>
<script src='<?php echo $baseurl ?>template/lib/regression.js' ></script>
<script src='<?php echo $baseurl ?>template/lib/morris.js'></script>
<!-- AdminLTE App -->
<script src="<?php echo $baseurl ?>template/dist/js/adminlte.min.js"></script>
<!-- PACE -->
<script src="<?php echo $baseurl ?>template/bower_components/PACE/pace.min.js"></script>
<script type="text/javascript">
  // To make Pace works on Ajax calls
  $(document).ajaxStart(function () {
    Pace.restart()
  })
  $('.ajax').click(function () {
    $.ajax({
      url: '#', success: function (result) {
        $('.ajax-content').html('<hr>Ajax Request Completed !')
      }
    })
  })
</script>

</body>
</html>