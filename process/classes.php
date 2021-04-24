<?php 
    require "../config/init.php";
    require "../inc/checklogin.php";
    
    $classes = new Classes;

    if(isset($_POST, $_POST['class_name']) && !empty($_POST) && !empty($_POST['class_name'])){
        $data = array(
            'class_name' => sanitize($_POST['class_name']),
            'detail'    => sanitize($_POST['detail']),
            'status'    => sanitize($_POST['status']),
            'added_by'  => $_SESSION['user_id']
        );

        $class_id = !empty($_POST['class_id']) ? (int)$_POST['class_id'] : null;
        
        if($class_id){
            $act = "updat";
            $class_id = $classes->updateData($data, $class_id);
        } else {
            $act = "add";
            $class_id = $classes->insertData($data);
        }

        if($class_id){
            // data entered
            redirect("../classes.php", 'success', "Class ".$act."ed successfully.");
        } else {
            // error adding class
            redirect("../classes.php", 'error', "Sorry! There was problem while ".$act."ing class.");
        }

    } elseif(isset($_GET, $_GET['id']) && !empty($_GET['id'])){
        $id = (int) $_GET['id'];
        if($id <= 0){
            redirect("../classes.php", 'error', "Invalid Class Id.");
        }

        $class_info = $classes->getRowByRowId($id);
        if(!$class_info){
            redirect("../classes.php", "error", "Class does not exists.");
        }

        $status = $classes->deleteRowByRowId($id);
        if($status){
            redirect("../classes.php", 'success', "Class deleted successfully.");
        } else {
            redirect("../classes.php", 'error', "Sorry! There was problem while deleting the class.");
        }
    } else {
        redirect("../classes.php", 'error', "Add some class data.");
    }