<?php   
    trait DataTrait{
        public function updateData($data, $row_id){
            $attr = array(
                'where' => array(
                    'id' => $row_id
                )
            );
            
            $success = $this->update($data, $attr);
            return $success;
            if($success){
                return $row_id;
            } else {
                return false;
            }
        }

        public function insertData($data, $is_exit = false){
            return $this->insert($data, $is_exit);
        }

        public function selectAllRows(){
            return $this->select();
        }

        public function getRowByRowId($id){
            $attr = array(
                'where' => array(
                    'id' => $id
                )
            );
            return $this->select($attr);
        }

        public function deleteRowByRowId($id){
            $attr = array(
                'where' => array(
                    'id' => $id
                )
            );
            return $this->delete($attr);
        }
        function get_total_records()
        {     
            $attr = array('fields' => " COUNT (*) ");   
            return $this->select($attr); 
        }
    }