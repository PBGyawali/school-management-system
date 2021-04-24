<?php 
final class Students extends Database{
    use DataTrait;
    
    public function __construct()
    {
        parent::__construct();
        $this->table = "students";
    }


    public function getAllStudents(){
        $attr = array(
            'fields' => array(
                "students.id",
                'students.user_id',
                "students.roll_no",
                "users.name as user_name",
                "classes.class_name",
                "class_section.section_name",
                "users.status"
            ),
            'leftJoin' => "
                LEFT JOIN users ON users.id = students.user_id
                LEFT JOIN classes ON classes.id = students.class_id
                LEFT JOIN class_section ON class_section.id = students.section_id
            "
        );
        return $this->select($attr);
    }

    public function getRollno($class_id, $section_id=null){
        $attr = array(
            'fields'    => "roll_no",
            "where" => "class_id = ".$class_id,
            "order_by" => "id DESC ",
            "limit" => "0,1"
        );

        if($section_id){
            $attr['where'] .= " AND section_id = ".$section_id;
        }

        $roll_no = $this->select($attr);
        if(!$roll_no){
            $roll_no = 1;
        } else {
            $roll_no = $roll_no[0]->roll_no;
            $roll_no += 1;
        }
        
        return $roll_no;
    }

    public function getStudentInfoById($student_id){
        $attr = array(
            'fields' => "
                students.*,
                users.name,
                users.email,
                users.image,
                classes.class_name,
                class_section.section_name
            ",
            "leftJoin" => " 
                LEFT JOIN users ON users.id = students.user_id
                LEFT JOIN classes ON classes.id = students.class_id
                LEFT JOIN class_section ON class_section.id = students.section_id
            ",
            "where" => " students.id = ".$student_id
        );
        return $this->select($attr);
    }



    
function Get_student_name($student_id)
{
    $attr = array(
        'fields' => array(
            "name as student_name"           
        ),
        'leftJoin' => "
        LEFT JOIN users on students.user_id=users.id
        ",
        'where'=>'students.id='.$student_id
    );	
	$result =  $this->select($attr);
	foreach($result as $row)
	{
		return ucwords( $row->student_name);
	}
}

function Get_student_section_name($student_id)
{
    $attr = array(
        'fields' => array(
            "class_section.section_name"           
        ),
        'leftJoin' => "
        LEFT JOIN class_section ON class_section.id = students.section_id
        ",
        'where'=>'students.id='.$student_id
    );	
	$result =  $this->select($attr);
	foreach($result as $row)
	{
		return $row->section_name;
	}
}

function Get_student_teacher_name($student_id)
{	
    $attr = array(
        'fields' => array(
            "name as teacher_name"           
        ),
        'leftJoin' => "
        LEFT JOIN class_section ON class_section.id = students.section_id
        LEFT JOIN teachers 	ON teachers.section_id = class_section.id
	    LEFT JOIN users	ON users.id=teachers.user_id ",
        'where'=>'students.id='.$student_id
    );
	$result =  $this->select($attr);
	foreach($result as $row)
	{
		return ucwords($row->teacher_name);
	}
}

}