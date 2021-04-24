<?php 
    final class Attendance extends Database{
        use DataTrait;
        
        public function __construct()
        {
            parent::__construct();
            $this->table = "attendance";
        }

        public function getAllAttendance(){          	
            $attr = array(
                'fields' => array(
                    "*",
                    "U2.name as teachername",
                    'U1.name as studentname',
                ),
                'leftJoin' => "
                                LEFT JOIN students 
                                ON students.user_id = attendance.student_id 
                                LEFT JOIN class_section 
                                ON class_section.id = students.section_id
                                LEFT JOIN teachers 
                                ON teachers.id = attendance.teacher_id 
                                LEFT JOIN users U1
                                ON U1.id = attendance.student_id 
                                LEFT JOIN users U2
                                ON U2.id = attendance.teacher_id                     
                "
            );
            return $this->select($attr);
        } 
    
        public function getAttendanceInfoById($column,$count=false,$fields=array()){
           $data = array(
                'fields' => "
                        *,students.user_id as studentid,
                        U1.name as studentname,
                        U2.name as teachername                   
                ",
                "leftJoin" => " 
                            LEFT JOIN students
                            ON attendance.student_id = students.user_id 
                            LEFT JOIN class_section 
                            ON class_section.id = students.section_id 
                            LEFT JOIN users U1
                            ON U1.id = attendance.student_id		
                            LEFT JOIN users U2
                            ON U2.id = attendance.teacher_id
                ", 
            );            
                if(is_string($column)||is_int($column)){
                    $condition=" attendance.student_id = ".$column;
                } elseif (is_array($column)){
                    $condition = $column;
                }
            $totalcondition=array("where"=>$condition);
            $attr = array_merge($data, $totalcondition);
            if(!empty($fields))
            $attr = array_merge($attr, $fields);
            return $this->select($attr,$count);
        }

        public function getAttendanceDate($column,$count=false,$fields=array()){
            $data = array(
                 'fields' => " attendance_date ",
                 "where"=>$column
             );   
             if(!empty($fields))
             $attr = array_merge($data, $fields);
             return $this->select($attr,$count);
         }
    function get_attendance_percentage($student_id)
    {
        $attr = array(
            'fields' => "
                        ROUND((SELECT COUNT(*) FROM attendance 
                            WHERE attendance_status = 'Present' 
                            AND student_id = '".$student_id."') 
                        * 100 / COUNT(*)) AS percentage                         
            ",            
            "where" => " students_id = ".$student_id
        );    
            $result = $this->select($attr);
            foreach($result as $row)
            {
                if($row["percentage"] > 0)
                    return $row["percentage"] . '%';
                    return 'NA';
            }
    }
   


        
    }