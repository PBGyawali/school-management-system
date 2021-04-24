<?php 
    final class Subjects extends Database{
        use DataTrait;
        public function __construct()
        {
            parent::__construct();
            $this->table = "subjects";
        }

        final public function getClassInfo(){
            // SELECT * FROM subjects
            $attr = array(
                'fields' => array(
                    'subjects.id',
                    'subjects.title',
                    'subjects.subject_code',
                    'subjects.status',
                    'classes.class_name',
                    'users.name'
                ),
                'leftJoin' => " LEFT JOIN classes ON classes.id = subjects.class_id 
                                LEFT JOIN users ON users.id = subjects.teacher_id"
            );
            return $this->select($attr);
        }

        final public function getSubjectsByClass($class_id){
            $attr = array(
                'where' => array(
                    'class_id' => $class_id
                )
            );
            return $this->select($attr);
        }
    }