<?php

require "../config/init.php";
$attendance=new Attendance;
if(isset($_POST["action"]))
{
	if($_POST["action"] == "fetch")
	{	
		if(isset($_POST["search"]["value"]))
		{
			$column=array(	
				'U1.name' => '%'.$_POST["search"]["value"].'%', 
				'U2.name' => '%'.$_POST["search"]["value"].'%' ,
				'students.roll_no' => '%'.$_POST["search"]["value"].'%' ,
				'attendance.attendance_status' => '%'.$_POST["search"]["value"].'%' ,
					
				'attendance.student_id' => '%'.$_POST["search"]["value"].'%',
				'attendance.attendance_date' => '%'.$_POST["search"]["value"].'%' ,	
		);
			$fields['compare']=' LIKE ';
			$fields['implode']=' OR';			
		}
		if(isset($_POST["order"]))		
			$fields['order_by']=$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		else
			$fields['order_by']= ' attendance.attendance_date DESC';

		if($_POST["length"] != -1)		
			$fields['limit']= $_POST['start'] . ', ' . $_POST['length'];
		$attendanceinfo = $attendance->getAttendanceInfoById($column,true,$fields);
		$result = $attendanceinfo['result'];
		$total_row = $attendanceinfo['count'];
		$data = array();		
		foreach($result as $row)
		{
			$sub_array = array();			
			if($row->attendance_status == "Present")			
				$status = '<label class="badge badge-success">Present</label>';			
			else			
				$status = '<label class="badge badge-danger">Absent</label>';			
			$sub_array[] = $row->studentid;
			$sub_array[] = $row->studentname;
			$sub_array[] = $row->roll_no;
			$sub_array[] = $row->section_name;
			$sub_array[] = $status;
			$sub_array[] = $row->attendance_date;
			$sub_array[] = $row->teachername;
			$data[] = $sub_array;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$total_row,
			"recordsFiltered"	=>	$attendance->get_total_records(),
			"data"				=>	$data
		);		
		echo json_encode($output);
	}

	if($_POST["action"] == "index_fetch")
	{
		if(isset($_POST["search"]["value"]))
		{
			$column=array(	
				'U1.name' => '%'.$_POST["search"]["value"].'%',
				'students.roll_no' => '%'.$_POST["search"]["value"].'%' ,
				'class_section.section_name' => '%'.$_POST["search"]["value"].'%' ,
				'U2.name' => '%'.$_POST["search"]["value"].'%',				
		);
			$fields['compare']=' LIKE ';
			$fields['implode']=' OR ';
		}
		$fields['group_by']=' students.id ';
		
		if(isset($_POST["order"]))		
			$fields['order_by']=$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		else
			$fields['order_by']= ' students.student_name ASC';

		if($_POST["length"] != -1)		
			$fields['limit']= $_POST['start'] . ', ' . $_POST['length'];

		$attendanceinfo = $attendance->getAttendanceInfoById($column,true,$fields);
		$result = $attendanceinfo['result'];
		$total_row = $attendanceinfo['count'];		
		$data = array();		
		foreach($result as $row)
		{
			$sub_array = array();
			$sub_array[] = $row->studentname;
			$sub_array[] = $row->roll_no;
			$sub_array[] = $row->section_name;
			$sub_array[] = $row->teachername;
			$sub_array[] = $attendance->get_attendance_percentage($row->student_id);
			$sub_array[] = '<button type="button" name="report_button" data-student_id="'.$row->student_id.'" class="btn btn-info btn-sm report_button">Report</button>&nbsp;&nbsp;&nbsp;
			<button type="button" name="chart_button" data-student_id="'.$row->student_id.'" class="btn btn-danger btn-sm report_button">Chart</button>
			';
			$data[] = $sub_array;
		}

		$output = array(
			'draw'				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$total_row,
			"recordsFiltered"	=>	$attendance->get_total_records('students'),
			"data"				=>	$data
		);

		echo json_encode($output);
	}
}


?>