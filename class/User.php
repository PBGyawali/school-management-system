<?php 
    final class User extends Database{
        use DataTrait;
        
        public function __construct()
        {
            parent::__construct();
            $this->table = "users";
        }

        public function getUserByEmail($email){
            $options = array(
                'where' => array(
                    'email'     => $email
                )
            );
            return $this->select($options);
            
        }

        public function getUserByCookieToken($token){
            $options = array(
                'where' => array(
                    'remember_token'     => $token
                )
            );
            return $this->select($options);
        }

        final public function getUserByType($type){
            $options = array(
                'where' => array(
                    'role'     => $type
                )
            );
            return $this->select($options);
        }
    }