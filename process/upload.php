<?php 
    require "../config/init.php";
    require "../inc/checklogin.php";
    $upload = new Upload;

    if(isset($_POST) && !empty($_POST)){
        // form submit
        // debug($_POST);
        // debug($_FILES, true);

        $data = array();
        $data['uploader_message']=sanitize($_POST['uploader_message']);
        $data['file_description']=sanitize($_POST['file_description']);
        $data['section_id']=$_POST['section_id'];
        $data['uploader_id']=$_SESSION['user_id'];

        if(isset($_FILES, $_FILES['file']) && $_FILES['file']['error'] == 0){
            // file upload
            $file_upload = imageUpload($_FILES['file']);
            if($file_upload){
                $data['file_name'] = $file_upload;
            }
        }else
        redirect("../uploads.php", 'error', "No File was Uploaded.");
        $insert_status = $upload->insertData($data);
        if($insert_status){
            redirect("../uploads.php", 'success', "File Uploaded successfully.");

        } else {
            redirect("../uploads.php", 'error', "Sorry! Error while uploading file.");
        }
    } else {
        redirect("../uploads.php", 'error', "Please fill all info first.");
    }