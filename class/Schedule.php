<?php
    final class Schedule extends Database{
        use DataTrait;

        public function __construct()
        {
            parent::__construct();
            $this->table = "exams_schedule";
        }

        public function getScheduleByExamId($exam_id){
            $attr = array(
                'fields' => "exams_schedule.*, 
                            subjects.title",
                "leftJoin" => "
                        LEFT JOIN subjects ON subjects.id = exams_schedule.subject_id
                ",
                'where' => array(
                    'exam_id' => $exam_id 
                )
            );
            return $this->select($attr);
        }

        public function getScheduleAndScoreByExamId($exam_id, $std_id){
            $attr = array(
                'fields' => "exams_schedule.*, 
                            subjects.title",
                "leftJoin" => "
                        LEFT JOIN subjects ON subjects.id = exams_schedule.subject_id
                ",
                'where' => array(
                    'exam_schedule.exam_id' => $exam_id 
                )
            );
            return $this->select($attr);
        }

        public function checkScheduleExists($exam_id, $sub_id){
            // SELECT * FROM exam_schedule WHERE exam_id = $exam_id AND subject_id = $sub_id
            $attr = array(
                'where' => array(
                    'exam_id' => $exam_id,
                    'subject_id' => $sub_id
                )
            );
            return $this->select($attr);
        }

        public function getSubjectByexamId($exam_id, $sub){
            $attr = array(
                "where" => array(
                    'exam_id' => $exam_id,
                    "subject_id" => $sub
                )
            );
            return $this->select($attr);
        }
    }