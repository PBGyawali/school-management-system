<?php 
    require "../config/init.php";
    require "../inc/checklogin.php";
    
    $section = new Section;

    if(isset($_POST, $_POST['section_name']) && !empty($_POST) && !empty($_POST['section_name'])){
                $data = array(
            'section_name' => sanitize($_POST['section_name']),
            'class_id'    => sanitize($_POST['class_id']),
            'added_by'  => $_SESSION['user_id']
        );

        $section_id = !empty($_POST['section_id']) ? (int)$_POST['section_id'] : null;
        
        if($section_id){
            $act = "updat";
            $section_id = $section->updateData($data, $section_id);
        } else {
            $act = "add";
            $section_id = $section->insertData($data);
        }

        if($section_id){
            // data entered
            redirect("../classes.php", 'success', "Section ".$act."ed successfully.");
        } else {
            // error adding class
            redirect("../classes.php", 'error', "Sorry! There was problem while ".$act."ing section.");
        }

    } elseif(isset($_GET, $_GET['id']) && !empty($_GET['id'])){
        $id = (int) $_GET['id'];
        if($id <= 0){
            redirect("../classes.php", 'error', "Invalid section Id.");
        }

        $section_info = $section->getRowByRowId($id);
        if(!$section_info){
            redirect("../classes.php", "error", "section does not exists.");
        }

        $status = $section->deleteRowByRowId($id);
        if($status){
            redirect("../classes.php", 'success', "section deleted successfully.");
        } else {
            redirect("../classes.php", 'error', "Sorry! There was problem while deleting the section.");
        }
    } else {
        redirect("../classes.php", 'error', "Add some section data.");
    }