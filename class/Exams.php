<?php 
    final class Exams extends Database{
        use DataTrait;

        public function __construct()
        {
            parent::__construct();
            $this->table = "exams";
        }

        final public function getAllExams(){
            $attr = array(
                'fields' => array(
                    'exams.id',
                    'exams.title',
                    'exams.status',
                    'exams.start_date',
                    'exams.end_date',
                    'classes.class_name',
                    'class_section.section_name'
                ),
                'leftJoin' => "
                    LEFT JOIN classes ON classes.id = exams.class_id
                    LEFT JOIN class_section ON class_section.id = exams.section_id
                "
            );
            return $this->select($attr);
        }

        final public function getAllCompletedExams(){
            $attr = array(
                'fields' => array(
                    'exams.id',
                    'exams.title',
                    'exams.status',
                    'exams.start_date',
                    'exams.end_date',
                    'classes.class_name',
                    'class_section.section_name'
                ),
                'leftJoin' => "
                    LEFT JOIN classes ON classes.id = exams.class_id
                    LEFT JOIN class_section ON class_section.id = exams.section_id
                ",
                "where" => "
                    exams.end_date <= '".date("Y-m-d")."' 
                "
            );
            return $this->select($attr);
        }

        final public function getCompletedExamsByClass($class_id, $section_id =null){
            $attr = array(
                'fields' => array(
                    'exams.id',
                    'exams.title'
                ),
                "where" => "
                    end_date <= '".date("Y-m-d")."' 
                    AND 
                    class_id = ".$class_id
            );
            if($section_id != NULL){
                $attr['where'] .= " AND section_id =".$section_id;
            }
            return $this->select($attr);
        }
    }