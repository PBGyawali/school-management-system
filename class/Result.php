<?php 
    final class Result extends Database{
        use DataTrait;

        public function __construct(){
            parent::__construct();
            $this->table = "student_results";
        }

        public function getResultByExamStudent($exam_id, $student_id){
            $attr = array(
                'where' => array(
                    'exam_id' => $exam_id,
                    'student_id' => $student_id
                )
            );
            return $this->select($attr);
        }

        public function getResultByExamId($exam_id){
            $attr = array(
                'where' => array(
                    'exam_id' => $exam_id
                )
            );
            return $this->select($attr);
        }
    }