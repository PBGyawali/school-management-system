<?php 
    require "../config/init.php";
    require "../inc/checklogin.php";
    $user = new User;

    if(isset($_POST) && !empty($_POST) && !empty($_POST['password']) && !empty($_POST['re_password'])){
        // form submit
        
        if($_POST['password'] != $_POST['re_password']){
            redirect("../dashboard", 'error', "Re-password does not match.");
        }


        $data = array('password' => sha1($_SESSION['email'].$_POST['password']));

        $update_status = $user->updateData($data, $_SESSION['user_id']);
        if($update_status){           
            redirect("../dashboard.php", 'success', "Your password has been updated. Please re-login.");

        } else {
            redirect("../dashboard.php", 'error', "Sorry! Error while updating password.");
        }
    } else {
        redirect("../dashboard.php", 'error', "Enter password for change.");
    }