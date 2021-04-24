<?php 
    require "../config/init.php";
    require "../inc/checklogin.php";
    
    $student = new Students;
    $user = new User;

    // debug($_POST);
    // debug($_FILES, true);

    if(isset($_POST, $_POST['name'], $_POST['class_id']) && !empty($_POST) && !empty($_POST['name'])){
        $act = "add";
        
        if(isset($_POST['user_id'], $_POST['student_id']) && !empty($_POST['user_id']) && !empty($_POST['student_id'])){
            $act = "updat";
        }


        if($act== 'add'){
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                redirect("../students.php", "error", "Invalid email format.");
            }
    
            if($_POST['password'] != $_POST['re_password']){
                redirect("../students.php", "error", "Password and confirm password does not match.");
            }

            $email = sanitize($_POST['email']);
            $pwd = sha1($_POST['email'].$_POST['password']);
        }

        $user_data = array(
            'name' => sanitize($_POST['name']),
            'role'    => 'student',
            'status'    => sanitize($_POST['status']),
            'added_by'  => $_SESSION['user_id']
        );

        

        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
            $image = imageUpload($_FILES['image'], "student");
            if($image){
                $user_data['image'] = $image;
                
                if($act != "add"){
                    $user_info = $user->getRowByRowId($_POST['user_id']);
                    imageDelete($user_info[0]->image, 'student');
                }
            }
        }

        if($act == 'add'){
            $user_data['email'] = $email;
            $user_data['password'] = $pwd;
            $user_id = $user->insertData($user_data);
        } else {
            $user_id = $user->updateData($user_data, $_POST['user_id']);
        }

        if($user_id){
            $student_data = array(
                'user_id'       => $user_id,
                'class_id'      => $_POST['class_id'],
                'added_by'      => $_SESSION['user_id'],
                'roll_no'       => $student->getRollno($_POST['class_id'],$_POST['section_id'])
            );

            if(isset($_POST['section_id']) && !empty($_POST['section_id'])){
                $student_data['section_id'] = $_POST['section_id'];
            }

            if($act == 'add'){
                $student_id = $student->insertData($student_data);
            } else {
                $student_id = $student->updateData($student_data, $_POST['student_id']);
            }

            if($student_id){
                // data entered
                redirect("../students.php", 'success', "Students ".$act."ed successfully.");
            } else {
                // error adding class
                redirect("../students.php", 'error', "Sorry! There was problem while ".$act."ing student.");
            }
        } else {
            redirect("../students.php", 'error', "Sorry! There was problem while ".$act."ing user.");
        }
    } elseif(isset($_GET, $_GET['id']) && !empty($_GET['id'])){
       
        
        $id = (int) $_GET['id'];

        if($id <= 0){
            redirect("../students.php", 'error', "Invalid student Id.");
        }

        $student_info = $student->getRowByRowId($id);
        if(!$student_info){
            redirect("../students.php", "error", "student does not exists.");
        }

        $status = $student->deleteRowByRowId($id);  // student table data delete
        if($status){
            $user_info = $user->getRowByRowId($student_info[0]->user_id);

            $del = $user->deleteRowByRowId($student_info[0]->user_id);     // user
            if($del){
                imageDelete($user_info[0]->image, "student");
            }
            redirect("../students.php", 'success', "student deleted successfully.");
        } else {
            redirect("../students.php", 'error', "Sorry! There was problem while deleting the student.");
        }
    } else {
        redirect("../students.php", 'error', "Add some student data.");
    }