<?php
    require '../config/init.php';
    require "../inc/checklogin.php";
    $schedule = new Schedule;

    if(isset($_POST) && !empty($_POST)){
        $exam_id = (int)$_POST['exam_id'];
        $student_id = (int)$_POST['student_id'];

        if($exam_id <= 0 || $student_id <= 0){
            redirect("../students.php","error","Select exam for score update");
        }

        $overall_result = "pass";
        

        $obtained_total = 0;
        $full_marks_total = 0;

        if($_POST['score']){
            foreach($_POST['score'] as $sub => $obt_score){
                $sub_result = "pass";
                $schedule_info = $schedule->getSubjectByexamId($exam_id, $sub);

                $obtained_total += $obt_score;

                $full_marks_total += $schedule_info[0]->full_mark;
                
                if($schedule_info[0]->pass_mark > $obt_score){
                    $sub_result = 'fail';
                    $overall_result = 'fail';
                }

                $score_data = array(
                    'exam_id' => $exam_id,
                    'student_id' => $student_id,
                    'subject_id' => $sub,
                    'obtained_score' => $obt_score,
                    'status' => $sub_result,
                    'added_by' => $_SESSION['user_id']
                );
                $score = new Scores();

                $already = $score->getScoreByExamId($exam_id,$student_id,$sub);
                if($already) {
                    $score->updateData($score_data, $already[0]->id);
                } else {
                    $score->insertData($score_data);
                }
            }

            $per = ($obtained_total/$full_marks_total) * 100;
            $result_data = array(
                'exam_id' => $exam_id,
                'student_id' => $student_id,
                'total_obtained_score' => $obtained_total,
                'percentage' => number_format($per, 4),
                'result' => $overall_result,
            );

            $result = new Result;
            $result_exists = $result->getResultByExamStudent($exam_id, $student_id);
            if($result_exists){
                $result->updateData($result_data, $result_exists[0]->id);
            } else {
                $result->insertData($result_data);
            }
        }

        redirect("../students.php", "success", "Score added Successfully.");

    } else {
        redirect("../students.php","error","Score add first");
    }