<?php 
    require_once "../config/init.php";
    require_once "../inc/checklogin.php";
    

    $act = (isset($_REQUEST['act'])) ? sanitize($_REQUEST['act']) : null;

    $class = new Classes;
    $section = new Section;
    $subjects = new Subjects;
    $schedule = new Schedule;


    if($act == "get-class"){
        // get class Information from id
        $class_id = (int)$_REQUEST['class_id'];
        if($class_id <= 0){
            api_response(null, false, "Invalid Class Id.");
        }
        $class_info = $class->getRowByRowId($class_id);
        if(!$class_info){
            api_response(null, false, "Class not found.");
        }
        api_response($class_info, true, "success");
    } elseif($act == "get-sections"){
        $class_id = (int)$_REQUEST['class_id'];
        if($class_id <= 0){
            api_response(null, false, "Invalid class Id.");
        } 

        $class_section = $section->getSectionByClass($class_id);

        if($class_section){
            // sections in this class
            api_response($class_section, true, "Success");
        } else {
            api_response(null, false, "No sections in this class");
        }

    } elseif($act == 'get-section-with-subject'){
        $class_id = (int)$_REQUEST['class_id'];
        if($class_id <= 0){
            api_response(null, false, "Invalid class Id.");
        } 

        $class_section = $section->getSectionByClass($class_id);
        $all_subjects = $subjects->getSubjectsByClass($class_id);

        $data = array(
            'sections_data' => $class_section,
            'subjects'      => $all_subjects
        );
        api_response($data, true, "success");
    } else if($act == 'get-exam-schedule'){
        
        $exam_id = (int)$_REQUEST['exam_id'];
        if($exam_id <= 0){
            api_response(null, false, "Invalid Exam ID");
        } 

        $schedules = $schedule->getScheduleByExamId($exam_id);

        if(!$schedules){
            api_response(null, false, "No schedules found for this exam");
        }


        api_response($schedules, true, "Success");

    } else  if($act == 'get-score-by-exam'){
        $exam_id = (int)$_REQUEST['exam_id'];
        $student_id = (int)$_REQUEST['student_id'];

        if($exam_id <= 0 || $student_id <= 0){
            api_response(null, false, "Invalid Exam or Student ID");
        } 

        $schedules = $schedule->getScheduleByExamId($exam_id);
        
        foreach($schedules as $subject_schedule){
            $score = new Scores;
            $obtain_mark = $score->getScoreByExamId($exam_id, $student_id, $subject_schedule->subject_id);
            
            $subject_schedule->obtained_score = @$obtain_mark[0]->obtained_score;
        }

        if(!$schedules){
            api_response(null, false, "No schedules found for this exam");
        }

        api_response($schedules, true, "Success");
    }else {
        api_response(null, false, "Action not specified");
    }