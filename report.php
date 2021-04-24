<?php
//report.php
require_once "config/init.php";
$output = '';
$pdf = new Pdf();
$attendance=new Attendance;
if(isset($_GET["action"]))
{	
	$from=$_GET["from_date"];
	$to=$_GET["to_date"];
	if($_GET["action"] == 'attendance_report')
	{
		if(isset($_GET["id"], $_GET["from_date"], $_GET["to_date"]))
		{
			
			$fields['compare']=' BETWEEN ';
			$fields['group_by']=' attendance_date ';
			$fields['order_by']=' attendance_date ASC ';
			$result = $attendance->getAttendanceDate(array('attendance_date'=>array('between'=>$from,'to'=>$to)),'',$fields);
			$output .= '
				<style>
				@page { margin: 20px; }
				
				</style>
				<p>&nbsp;</p>
				<h3 align="center">Attendance Report</h3><br />
				<span align="center">From '.$_GET["from_date"].' to '.$_GET["to_date"].'</span>
				';

			foreach($result as $row)
			{
				$output .= '
				<table width="100%" border="0" cellpadding="5" cellspacing="0">
			        <tr>
			        	<td><b>Date :'.$row->attendance_date.'</b></td>
			        </tr>
			        <tr>
			        	<td>
			        		<table width="100%" border="1" cellpadding="5" cellspacing="0">
			        			<tr>
			        				<td><b>Student Name</b></td>
			        				<td><b>Roll Number</b></td>
			        				<td><b>Section</b></td>
			        				<td><b>Teacher</b></td>
			        				<td><b>Attendance Status</b></td>
			        			</tr>
				';				
				$sub_result = $attendance->getAttendanceInfoById(array('class_section.id'=>$_GET['id'],"attendance_date>"=>$row->attendance_date));
			
				foreach($sub_result as $sub_row)
				{
					$output .= '
					<tr>
						<td>'.$sub_row->studentname.'</td>
						<td>'.$sub_row->roll_no.'</td>
						<td>'.$sub_row->section_name.'</td>
						<td>'.$sub_row->teachername.'</td>
						<td>'.$sub_row->attendance_status.'</td>
					</tr>
					';
				}
				$output .= 
					'</table>
					</td>
					</tr>
				</table><br />';
			}
			
		}
	}

	if($_GET["action"] == "student_report")
	{
		if(isset($_GET["student_id"], $_GET["from_date"], $_GET["to_date"]))
		{		
			$student=new Students;			
			$result = $student->getStudentInfoById($_GET["student_id"]);;								
			foreach($result as $row)
			{
				$output .= '
				<style>
				@page { margin: 20px; }
				
				</style>
				<p>&nbsp;</p>
				<h3 align="center">Attendance Report</h3><br /><br />
				<table width="100%" border="0" cellpadding="5" cellspacing="0">
			        <tr>
			            <td width="25%"><b>Student Name</b></td>
			            <td width="75%">'.$row->name.'</td>
	        </tr>
			        <tr>
			            <td width="25%"><b>Roll Number</b></td>
						<td width="75%">'.$row->roll_no.'</td
					</tr>
			        <tr>
			            <td width="25%"><b>Grade</b></td>
			            <td width="75%">'.$row->section_name.'</td>
			        </tr>
			        <tr>
			        	<td colspan="2" height="5">
			        		<h3 align="center">Attendance Details</h3>
			        	</td>
			        </tr>
			        <tr>
			        	<td colspan="2">
			        		<table width="100%" border="1" cellpadding="5" cellspacing="0">
			        			<tr>
			        				<td><b>Attendance Date</b></td>
			        				<td><b>Attendance Status</b></td>
			        			</tr>
				';							
				$fields['order_by']=' attendance_date ASC ';
				$sub_result =$attendance->getAttendanceInfoById(array('attendance_date'=>array('between'=>$from,'to'=>$to),'student_id'=>$_GET['student_id']),'',$fields);
				foreach($sub_result as $sub_row)
				{
					$output .= '<tr>
						<td>'.$sub_row->attendance_date.'</td>
						<td>'.$sub_row->attendance_status.'</td>
					</tr>';
				}
				$output .= '
						</table>
					</td>
					</tr>
				</table>
				';				
			}
		}
	}	
	$file_name = "Attendance Report.pdf";
	$pdf->loadHtml($output);
	$pdf->render();
	$pdf->stream($file_name, array("Attachment" => false));
	exit(0);
}

?>