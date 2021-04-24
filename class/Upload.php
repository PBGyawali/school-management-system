<?php 
    final class Upload extends Database{
        use DataTrait;
        
        public function __construct()
        {
            parent::__construct();
            $this->table = "uploads";
        }

     
    }