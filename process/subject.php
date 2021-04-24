<?php 
    require "../config/init.php";
    require "../inc/checklogin.php";
    
    $subject = new Subjects;

    if(isset($_POST, $_POST['subject_title']) && !empty($_POST) && !empty($_POST['subject_title'])){

        $data = array(
            'title' => sanitize($_POST['subject_title']),
            'class_id'    => sanitize($_POST['class_id']),
            'subject_code'    => sanitize($_POST['subject_code']),
            'description'    => sanitize($_POST['description']),
            'status'    => sanitize($_POST['status']),
            'teacher_id'    => (int)sanitize(@$_POST['teacher_id']),
            'added_by'  => $_SESSION['user_id']
        );

        if(!isset($_POST['teacher_id'])){
            unset($data['teacher_id']);
        }
        

        $subject_id = !empty($_POST['subject_id']) ? (int)$_POST['subject_id'] : null;
        
        if($subject_id){
            $act = "updat";
            unset($data['subject_code']);
            $subject_id = $subject->updateData($data, $subject_id);
        } else {
            $act = "add";
            $subject_id = $subject->insertData($data);
        }

        if($subject_id){
            // data entered
            redirect("../subjects.php", 'success', "Subject ".$act."ed successfully.");
        } else {
            // error adding class
            redirect("../subjects.php", 'error', "Sorry! There was problem while ".$act."ing subject.");
        }

    } elseif(isset($_GET, $_GET['id']) && !empty($_GET['id'])){

        $id = (int) $_GET['id'];
        if($id <= 0){
            redirect("../subjects.php", 'error', "Invalid subject Id.");
        }

        $subject_info = $subject->getRowByRowId($id);
        if(!$subject_info){
            redirect("../subjects.php", "error", "subject does not exists.");
        }

        $status = $subject->deleteRowByRowId($id);
        if($status){
            redirect("../subjects.php", 'success', "subject deleted successfully.");
        } else {
            redirect("../subjects.php", 'error', "Sorry! There was problem while deleting the subject.");
        }
    } else {
        redirect("../subjects.php", 'error', "Add some subject data.");
    }