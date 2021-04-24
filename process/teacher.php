<?php 
    require "../config/init.php";
    require "../inc/checklogin.php";
    
    $teacher = new Teachers;
    $user = new User;

    // debug($_POST);
    // debug($_FILES, true);

    if(isset($_POST, $_POST['name'], $_POST['class_id'], $_POST['subject_id']) && !empty($_POST) && !empty($_POST['name'])){
        $act = "add";
        
        if(isset($_POST['user_id'], $_POST['teacher_id']) && !empty($_POST['user_id']) && !empty($_POST['teacher_id'])){
            $act = "updat";
        }


        if($act== 'add'){
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                redirect("../teachers.php", "error", "Invalid email format.");
            }
    
            if($_POST['password'] != $_POST['re_password']){
                redirect("../teachers.php", "error", "Password and confirm password does not match.");
            }

            $email = sanitize($_POST['email']);
            $pwd = sha1($_POST['email'].$_POST['password']);
        }

        $user_data = array(
            'name' => sanitize($_POST['name']),
            'role'    => 'teacher',
            'status'    => sanitize($_POST['status']),
            'added_by'  => $_SESSION['user_id']
        );

        

        if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
            $image = imageUpload($_FILES['image'], "teacher");
            if($image){
                $user_data['image'] = $image;
                
                if($act != "add"){
                    $user_info = $user->getRowByRowId($_POST['user_id']);
                    imageDelete($user_info[0]->image, 'teacher');
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
            $teacher_data = array(
                'user_id'       => $user_id,
                'class_id'      => $_POST['class_id'],
                'section_id'    => $_POST['section_id'],
                'subject_id'    => $_POST['subject_id'],
                'experience'    => $_POST['experience'],
                'education'     => sanitize($_POST['education']),
                'added_by'      => $_SESSION['user_id'],

            );

            if($teacher_data['section_id'] == ''){
                unset($teacher_data['section_id']);
            }

            if($act == 'add'){
                $teacher_id = $teacher->insertData($teacher_data);
            } else {
                $teacher_id = $teacher->updateData($teacher_data, $_POST['teacher_id']);
            }

            if($teacher_id){
                // data entered
                redirect("../teachers.php", 'success', "Teachers ".$act."ed successfully.");
            } else {
                // error adding class
                redirect("../teachers.php", 'error', "Sorry! There was problem while ".$act."ing teacher.");
            }
        } else {
            redirect("../teachers.php", 'error', "Sorry! There was problem while ".$act."ing user.");
        }
    } elseif(isset($_GET, $_GET['id']) && !empty($_GET['id'])){
       
        
        $id = (int) $_GET['id'];

        if($id <= 0){
            redirect("../teachers.php", 'error', "Invalid teacher Id.");
        }

        $teacher_info = $teacher->getRowByRowId($id);
        if(!$teacher_info){
            redirect("../teachers.php", "error", "teacher does not exists.");
        }

        $status = $teacher->deleteRowByRowId($id);  // teacher table data delete
        if($status){
            $user_info = $user->getRowByRowId($teacher_info[0]->user_id);

            $del = $user->deleteRowByRowId($teacher_info[0]->user_id);     // user
            if($del){
                imageDelete($user_info[0]->image, "teacher");
            }
            redirect("../teachers.php", 'success', "teacher deleted successfully.");
        } else {
            redirect("../teachers.php", 'error', "Sorry! There was problem while deleting the teacher.");
        }
    } else {
        redirect("../teachers.php", 'error', "Add some teacher data.");
    }
    