<?php 
    final class Scores extends Database{
        use DataTrait;

        public function __construct(){
            parent::__construct();
            $this->table = "student_score";
        }

        public function getScoreByExamId($exam_id, $std_id, $sub_id){
            $attr = array(
                // 'fields' => "obtained_score",
                'where' => array(
                    'exam_id' => $exam_id,
                    'student_id' => $std_id,
                    'subject_id' => $sub_id
                )
            );
            return $this->select($attr);
        }

        public function getScroeByStudentIdAndExam($exam_id, $std_id){
            $attr = array(
                'fields' => "student_score.*, subjects.title",
                'leftJoin' => " LEFT JOIN subjects ON subjects.id = student_score.subject_id",
                'where' => array(
                    'exam_id' => $exam_id,
                    'student_id' => $std_id,
                )
            );
            return $this->select($attr);
        }

    }