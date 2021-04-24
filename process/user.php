<?php 
    require "../config/init.php";
    require "../inc/checklogin.php";
    $user = new User;

    if(isset($_POST) && !empty($_POST)){
        // form submit
        // debug($_POST);
        // debug($_FILES, true);

        $data = array(
            'name' => sanitize($_POST['name'])
        );

        if(isset($_FILES, $_FILES['image']) && $_FILES['image']['error'] == 0){
            // file upload
            $file_upload = imageUpload($_FILES['image'], "user",ALLOWED_IMAGES);
            if($file_upload){
                $data['image'] = $file_upload;
            }
        }

        $update_status = $user->updateData($data, $_SESSION['user_id']);
        if($update_status){
            setSession('name', $data['name']);
            
            if(isset($file_upload)){
                if($_SESSION['image'] != null){
                    imageDelete($_SESSION['image'], "user");
                }
                setSession('image', @$data['image']);
            }

            redirect("../dashboard.php", 'success', "User Updated successfully.");

        } else {
            redirect("../dashboard.php", 'error', "Sorry! Error while updating user.");
        }
    } else {
        redirect("../dashboard.php", 'error', "Update information of user first.");
    }