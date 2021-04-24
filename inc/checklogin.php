<?php 
    $user = new User;

    if(!isset($_SESSION, $_SESSION['token']) || empty($_SESSION['token'])){
        if(isset($_COOKIE, $_COOKIE['_au'])){
            // session empty but not cookie
            $cookie_data = $_COOKIE['_au'];
            $user_info = $user->getUserByCookieToken($cookie_data);
            
            if($user_info){
                // valid cookie
                setSession('user_id', $user_info[0]->id);
                setSession('name', $user_info[0]->name);
                setSession('email', $user_info[0]->email);
                setSession('role', $user_info[0]->role);
                setSession('image', $user_info[0]->image);
                setSession('user_type',$user_info[0]->user_type);
                
                // random token = random string
                $token = randomString();
                setSession('token', $token);
                setcookie("_au", $token, time()+864000, "/");
                // update user with the currently generated token
                
                $data = array( 'remember_token'=> $token);
                $user->updateData($data, $user_info[0]->id);                
            } else {
                setcookie('_au', '', time()-60, '/');
                redirect('./', 'warning', "Clear your browser cookie before login.");
            }
        } else {
            // session as well as cookie both empty
            redirect('./', 'error',"Please Login First.");
        }
    }