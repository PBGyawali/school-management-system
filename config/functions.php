<?php 

    function debug($data, $is_exit = false){
        echo "<pre style='background: #ffffff;'>";
        print_r($data);
        echo "</pre>";
        if($is_exit){
            exit;
        }
    }


    function redirect($path, $session_status = null, $session_msg = null){
        
        if($session_status != null && $session_msg != null){
            setSession($session_status, $session_msg);
        }

        @header("location: ".$path);
        exit;
    }

    function setSession($key, $value){
        if(!isset($_SESSION)){
            session_start();
        }
        $_SESSION[$key] = $value;
    }

    function flash(){
        if(isset($_SESSION['success']) && !empty($_SESSION['success'])){
            echo "<p class='alert alert-success'>".$_SESSION['success']."</p>";
            unset($_SESSION['success']);
        }
        if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
            echo "<p class='alert alert-danger'>".$_SESSION['error']."</p>";
            unset($_SESSION['error']);
        }
        if(isset($_SESSION['info']) && !empty($_SESSION['info'])){
            echo "<p class='alert alert-info'>".$_SESSION['info']."</p>";
            unset($_SESSION['info']);
        }
        if(isset($_SESSION['warning']) && !empty($_SESSION['warning'])){
            echo "<p class='alert alert-warning'>".$_SESSION['warning']."</p>";
            unset($_SESSION['warning']);
        }
        if(isset($_SESSION['message']) && !empty($_SESSION['message'])){
            echo "<p class='alert alert-primary'>".$_SESSION['message']."</p>";
            unset($_SESSION['message']);
        }
    }

    function randomString($length=100){
        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $strlen = strlen($chars);
        // string is an array of chars
        $random = "";
        for($i=0; $i<$length; $i++){
            $posn = rand(0, $strlen-1);
            $random .= $chars[$posn];
        }
        return $random;
    }

    function sanitize($str){
        // str => <p>Prakhar Gyawali</p>      => &lt;p&gt;Prakhar Gyawali&lt;/p&gt;
        $str = rtrim(strip_tags($str));    //Prakhar Gyawali
        $str = htmlentities($str);      // &lt;p&gt;Prakhar Gyawali&lt;/p&gt;
        return $str;                // Prakhar Gyawali, &lt;p&gt;Prakhar Gyawali&lt;/p&gt;
    }
    
    function imageUpload($image, $dir='uploads',$types=ALLOWED_FILES){
        if($image['error'] == 0){
            // file does not have any error
            if($image['size'] <= 10000000){
                // file size is less than 10mb
                $ext = pathinfo($image['name'], PATHINFO_EXTENSION);

                if(in_array(strtolower($ext), $types)){
                    // extension is valid                  
                    $file_name = ucfirst($dir)."-".date("YmdHis").rand(0,9999).".".$ext;
                    
                    // upload_path
                    $upload_path = UPLOAD_DIR.'/'.$dir;

                    if(!is_dir($upload_path)){
                        mkdir($upload_path, 0777, true);
                    }

                    $success = move_uploaded_file($image['tmp_name'], $upload_path.'/'.$file_name);
                    if($success){
                        // file uploaded
                        return $file_name;
                    } else {
                        setSession('info', 'File could not be uploaded to the server');
                        return null;
                    }
                } else {                    
                    setSession('warning', 'File does not belong to allowed extension types');
                    return null;
                }
            } else {             
                setSession('warning', 'File size is too large');
                return null;
            }
        } else {
            setSession('warning', 'File could not be uploaded to the server');
            return null;
        }
    }

    function api_response($data, $status, $msg){

        $response = array(
            'data'      => $data,
            'status'    => $status,
            'msg'       => $msg
        );
        echo json_encode($response);
        exit;
    }

    function imageDelete($image_name, $dir_name){
        if($image_name != null && file_exists(UPLOAD_DIR.'/'.$dir_name."/".$image_name)){
            unlink(UPLOAD_DIR.'/'.$dir_name."/".$image_name);
        }
    }