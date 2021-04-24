<?php 
    require "../config/init.php";
    require "../inc/checklogin.php";
    $exam = new Exams;

    if(isset($_POST) && !empty($_POST)){
        
        $exam_data = array(
            'title' => sanitize($_POST['exam_title']),
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'added_by' => $_SESSION['user_id'],
            'status' => sanitize($_POST['status'])
        );

        if(isset($_POST['section_id']) && !empty($_POST['section_id'])){
            $exam_data['section_id'] = (int)$_POST['section_id'];
        }

        if(isset($_POST['class_id']) && !empty($_POST['class_id'])){
            $exam_data['class_id'] = (int)$_POST['class_id'];
        }


        $exam_id = isset($_POST['exam_id']) && !empty($_POST['exam_id']) ? (int)$_POST['exam_id'] : '';
        
        if($exam_id){
            $act = "updat";
            unset($exam_data['added_by']);
            $exam_id = $exam->updateData($exam_data, $exam_id);
        } else {
            $act = "add";
            $exam_id = $exam->insertData($exam_data);        
        }


        
        
        if(isset($_POST['exam_schedule']) && !empty($_POST['exam_schedule'])){
            
            foreach($_POST['exam_schedule'] as $sub_id => $exam_schedule){
                $schedule_data = array(
                    'exam_id'       => $exam_id,
                    'exam_date'     => sanitize($exam_schedule['date']),
                    'subject_id'    => $sub_id,
                    'full_mark'     => sanitize($exam_schedule['full_mark']),
                    'pass_mark'     => sanitize($exam_schedule['pass_mark']),
                );
                $schedule = new Schedule;
                
                $old_exam = $schedule->checkScheduleExists($exam_id, $sub_id);
                if($old_exam){
                    $schedule->updateData($schedule_data, $old_exam[0]->id);
                } else {
                    $schedule->insertData($schedule_data);
                }
            }

        }


        if($exam_id){
            redirect("../exams.php", "success", "Exam ".$act."ed successfully");
        } else {
            redirect("../exams.php", "error", "Sorry! Problem while ".$act."ing Exam");
        }
    } elseif(isset($_GET['id']) && !empty($_GET['id'])){
        $exam_id = (int)$_GET['id'];
        if($exam_id <=0 ){
            redirect("../exams.php", "error", "Invalid Exam Id.");
        } 
        $exam_info = $exam->getRowByRowId($exam_id);
        if($exam_info){
            $del = $exam->deleteRowByRowId($exam_id);
            if($del){
                redirect("../exams.php", 'success', "Exam deleted successfully.");
            } else {
                redirect("../exams.php", 'error', "Sorry! There was problem while deleting exam.");
            }
        } else {
            redirect("../exams.php", "error", "Exam not found.");
        }
    }  else {
        redirect("../exams.php", "error", "Add Exam data");
    }
