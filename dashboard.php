<?php
  require_once "config/init.php";
 //require_once "inc/checklogin.php";

  $_title = "Dashboard || ".SITE_TITLE;
  require_once "inc/header.php";  
?>
  <div id="wrapper">
    <?php require_once 'inc/sidebar.php';?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <?php require_once 'inc/top-nav.php';?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <?Php flash();?>          
        </div>
        <!-- /.container-fluid -->   
        <?php
$attendance=new Attendance;
$user=new User;
$attendanceinfo=$attendance->getAttendanceInfoById($_SESSION['user_id'],true);
$present_percentage=100;
$absent_percentage =0;
$total_present = 0;
$total_absent = 0;
$output = "";
$result = $attendanceinfo['result'];
$total_row = $attendanceinfo['count'];
foreach($result as $key =>$row)
{	
	if($row->attendance_status == "Present")	
		$total_present++;			
	else
		$total_absent++;
}
if($total_row > 0)
{
	$present_percentage = ($total_present / $total_row) * 100;
	$absent_percentage = ($total_absent / $total_row) * 100;
}
?>
<div class="container" style="margin-top:30px">
  <div class="card">
  	<div class="card-header text-center"><b>Attendance Chart</b></div>
  	<div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <tr>
            <th>Section Name</th>
            <td><?php echo @$result[0]->section_name; ?></td>
          </tr>          
        </table>
      </div>
  		<div id="attendance_pie_chart" class="col" style="width: 100%; height: 400px;">
  		</div>
  		<div class="table-responsive">
        <table class="table table-striped table-bordered">
          <tr>
            <th>Student Name</th>
            <th><?=ucwords(@$_SESSION['name'])?></th>
          </tr>
          <?php echo $output;?>
      </table></div>
  	</div>
  </div>
</div>
</body>
</html>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart()
  {
    var data = google.visualization.arrayToDataTable([
      ['Attendance Status', 'Percentage'],
      ['Present', <?php echo $present_percentage; ?>],
      ['Absent', <?php echo $absent_percentage; ?>]
    ]);

    var options = {
      title: 'Overall Attendance Analytics',
      hAxis: {
        title: 'Percentage',
        minValue: 0,
        maxValue: 100
      },
      vAxis: {title: 'Attendance Status'}
    };
    var chart = new google.visualization.PieChart(document.getElementById('attendance_pie_chart'));
    chart.draw(data, options);
  }
</script>     
      </div>
      <!-- End of Main Content -->
        <?php require_once 'inc/copy.php'; ?>
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>  
<?php   require_once "inc/footer.php";?>