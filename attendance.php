<?php
require_once "config/init.php";
require_once "inc/checklogin.php";
$_title = "Attendance Manager || " . SITE_TITLE;
require_once "inc/header.php";
$section = new Section;
?>
<div id="wrapper">
<?php require_once 'inc/sidebar.php'; ?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
        <?php require_once 'inc/top-nav.php'; ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
                <?Php flash(); ?>
                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">
                      Attendance List                    
                    <button type="button" id="chart_button" class="btn btn-primary btn-sm">Chart</button>
                    <button type="button" id="report_button" class="btn btn-danger btn-sm">Report</button>
                </h1>
                <hr>
  	<div class="row">
  		<div class="col-12">
        <table class="table table-striped table-bordered  table-hover" id="attendance_table">
          <thead>
            <tr>
              <th>Student ID</th>
              <th>Student Name</th>
              <th>Roll Number</th>
              <th>Section</th>
              <th>Attendance Status</th>
              <th>Attendance Date</th>
              <th>Teacher</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
  		</div>
  	</div>
  </div>
</div>

</body>
</html>
<div class="modal" id="reportModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Make Report</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
          <select name="id" id="id" class="form-control">
            <option value="">Select Section</option>
            <?php echo $section->load_grade_list()?>
          </select>
          <span id="error_id" class="text-danger"></span>
        </div>       
        <div class="form-group"> 
        <label for="" class="col-sm-12 col-md-3">Start Date:</label>
            <input type="date" name="from_date" id="from_date" class="form-control form-control-sm" required placeholder="From Date" value="<?php echo @$exam_info[0]->start_date; ?>"/>
            <span id="error_from_date" class="text-danger"></span>
            <br />
            <label for="" class="col-sm-12 col-md-3">End Date:</label>
            <input type="date" name="to_date" id="to_date" class="form-control form-control-sm" required placeholder="To Date"  value="<?php echo @$exam_info[0]->end_date; ?>"/>
            <span id="error_to_date" class="text-danger"></span>          
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" name="create_report" id="create_report" class="btn btn-success btn-sm">Create Report</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<div class="modal" id="chartModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Create Grade Attandance Chart</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
          <select name="chart_id" id="chart_id" class="form-control">
            <option value="">Select Section</option>
            <?php echo $section->load_grade_list()?>
          </select>
          <span id="error_chart_id" class="text-danger"></span>
        </div>
        <div class="form-group">
          <div class="input-daterange">
            <input type="date" name="attendance_date" id="attendance_date" class="form-control" placeholder="Select Date"/>
            <span id="error_attendance_date" class="text-danger"></span>
          </div>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" name="create_chart" id="create_chart" class="btn btn-success btn-sm">Create Chart</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<?php
require_once "inc/footer.php";

?>
<script>
$(document).ready(function(){
	
  var dataTable = $('#attendance_table').DataTable({
    "processing":true,
    "serverSide":true,
    "order":[],
    "ajax":{
      url:"process/attendance.php",
      type:"POST",
      data:{action:'fetch'}
    }
  });

  

  $(document).on('click', '#report_button', function(){
    $('#reportModal').modal('show');
  });

  $('#create_report').click(function(){
    var id = $('#id').val();
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var error = 0;

    if(id == '')
    {
      $('#error_id').text('Grade is Required');
      error++;
    }
    else
    {
      $('#error_id').text('');
    }

    if(from_date == '')
    {
      $('#error_from_date').text('From Date is Required');
      error++;
    }
    else
    {
      $('#error_from_date').text('');
    }

    if(to_date == '')
    {
      $('#error_to_date').text("To Date is Required");
      error++;
    }
    else
    {
      $('#error_to_date').text('');
    }

    if(error == 0)
    {
      $('#from_date').val('');
      $('#to_date').val('');
      $('#formModal').modal('hide');
      window.open("report.php?action=attendance_report&id="+id+"&from_date="+from_date+"&to_date="+to_date);
    }

  });

  $('#chart_button').click(function(){
    $('#chart_id').val('');
    $('#attendance_date').val('');
    $('#chartModal').modal('show');
  });

  $('#create_chart').click(function(){
    var id = $('#chart_id').val();
    var attendance_date = $('#attendance_date').val();
    var error = 0;
    if(id == '')
    {
      $('#error_chart_id').text('Grade is Required');
      error++;
    }
    else
    {
      $('#error_chart_id').text('');
    }
    if(attendance_date == '')
    {
      $('#error_attendance_date').text('Date is Required');
      $error++;
    }
    else
    {
      $('#error_attendance_date').text('');
    }

    if(error == 0)
    {
      $('#attendance_date').val('');
      $('#chart_id').val('');
      $('#chartModal').modal('show');
      window.open("chart1.php?action=attendance_report&id="+id+"&date="+attendance_date);
    }

  });

});
</script>