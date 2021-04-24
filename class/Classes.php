<?php 
    final class Classes extends Database{
        use DataTrait;

        public function __construct()
        {
            parent::__construct();
            $this->table = "classes";
        }
    
        function load_class_list()
        {
            $attr = array('order by'=>'class_name ASC');            
            $result = $this->select($attr);
            $output = '';
            foreach($result as $row){
                $output .= '<option value="'.$row->id.'">'.ucwords($row->class_name).'</option>';
            }            
            return $output;
        }
    
    
    
    }