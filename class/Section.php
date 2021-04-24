<?php 
    final class Section extends Database{
        use DataTrait;

        public function __construct()
        {
            parent::__construct();
            $this->table = "class_section";
        }

        public function getSectionByClass($class_id){
            $attr = array(
                'where' => array(
                    'class_id' => $class_id
                )
            );
            return $this->select($attr);
        }
        function load_grade_list()
        {
            $attr = array('order by'=>'section_name ASC');            
            $result = $this->select($attr);
            $output = '';
            foreach($result as $row){
                $output .= '<option value="'.$row->id.'">'.$row->section_name.'</option>';
            }            
            return $output;
        }



    }