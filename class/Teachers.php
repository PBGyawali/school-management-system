<?php 
final class Teachers extends Database{
    use DataTrait;
    
    public function __construct()
    {
        parent::__construct();
        $this->table = "teachers";
    }


    public function getAllTeachers(){
        $attr = array(
            'fields' => array(
                "teachers.id",
                'teachers.user_id',
                "teachers.experience",
                "teachers.education",
                "subjects.title as sub_title",
                "users.name as user_name",
                "classes.class_name",
                "class_section.section_name",
                "users.status"
            ),
            'leftJoin' => "
                LEFT JOIN users ON users.id = teachers.user_id
                LEFT JOIN classes ON classes.id = teachers.class_id
                LEFT JOIN subjects ON subjects.id = teachers.subject_id
                LEFT JOIN class_section ON class_section.id = teachers.section_id
            "
        );
        return $this->select($attr);
    }
}