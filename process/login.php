<?php 
    require_once "../config/init.php";

    $user = new User();


    if(isset($_POST, $_POST['email'], $_POST['password'])){
        // form submitted
        // text@text

        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);    // email value, null
        
        if(!$email){
            redirect("../", "error", "Invalid email Format");
        }
        // email+password
       $password = sha1($email.$_POST['password']);
     
        // validate with our db table
        $user_info  =  $user->getUserByEmail($email);
        
        if($user_info){
            // user does exists
            if($password == $user_info[0]->password){
                // password match
                if($user_info[0]->status == 'active'){
                    // let user go to dashboard

                    setSession('user_id', $user_info[0]->id);
                    setSession('name', $user_info[0]->name);
                    setSession('email', $user_info[0]->email);
                    setSession('role', $user_info[0]->role);
                    setSession('user_type', $user_info[0]->user_type);
                    setSession('image', $user_info[0]->image);

                    // random token = random string
                    $token = randomString();

                    setSession('token', $token);

                    if(isset($_POST['remember_me']) && !empty($_POST['remember_me'])){
                        setcookie("_au", $token, time()+864000, "/");
                        // update user with the currently generated token
                        
                        $data = array(
                            'remember_token'=> $token
                        );
                        $user->updateData($data, $user_info[0]->id);
                    }
                    
                    if($user_info[0]->role == 'admin'){
                        redirect("../dashboard.php", "success", "Welcome to admin Panel.");  
                    } else if($user_info[0]->role == 'teacher'){
                        redirect("../dashboard.php", "success", "Welcome to Teacher Panel.");  
                    } else {
                        redirect("../dashboard.php", "success", "Welcome to Student Panel.");  
                    }

                    
                } else {
                    redirect("../", "error", "Your account is disabled. Please contact system administration");  
                }
            } else {
                // password match
                redirect("../", "error", "Password does not match");  
            }
        } else {
            redirect("../", "error", "User does not exists.");   
        }
    } else {
        // success, error, info, warning
        redirect("../", "error", "Please Login First.");   
    }