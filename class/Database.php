
  <?php 
    abstract class Database{

        public $conn = "";
        protected $sql = "";
        protected $stmt = "";
        protected $table = null;

        public function __construct(){
            try{
                $this->conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";", DB_USER, DB_PWD);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->sql = "SET NAMES utf8";
                $this->stmt = $this->conn->prepare($this->sql);                
                $this->stmt->execute();
            } catch(PDOException $e){
                $this->log($e,'Connection',' PDO');                
            } catch(Exception $e){
                $this->log($e,'Connection',' General'); 
            }
        }
        function execute($data = array()){
            $this->stmt = $this->conn->prepare($this->sql);                  			
            return $this->stmt->execute($data);
        }
        function parms($string,$data) {
            $indexed=$data==array_values($data);
            foreach($data as $k=>$v) {
                if(is_string($v)) $v="'$v'";
                if($indexed) $string=preg_replace('/\?/',$v,$string,1);
                else $string=str_replace(":$k",$v,$string);
            }
            return $string;
        }

        function log($e,$transaction,$type){
            $msg = date("Y-m-d h:i:s A")." ".$transaction.", ". $type.": ".$e->getMessage()."\r\n";
                    error_log($msg, 3, ERROR_LOG);
        }
        protected final function select($attr = array(),$count=false, $is_debug = false){
            $data=array();
            try{
                $this->sql = "SELECT ";
                if(isset($attr['fields'])){                   
                    if(is_array($attr['fields']))
                        $this->sql .= implode(", ", $attr['fields']);
                    else 
                        $this->sql .= $attr['fields'];                    
                } 
                else 
                    $this->sql .= " * ";                
                $this->sql .= " FROM ";                
                if(!isset($this->table) || empty($this->table))
                    throw new PDOException("Table not set.");                             
                $this->sql .= $this->table;                
                if(isset($attr['leftJoin']) && !empty($attr['leftJoin']))
                    $this->sql .= $attr['leftJoin']; 
                if(isset($attr['implode']) && !empty($attr['implode']))
                    $implode= $attr['implode'];
                else
                    $implode=' AND '; 
                if(isset($attr['compare']) && !empty($attr['compare']))
                $compare= $attr['compare'];
                else
                $compare='='; 
                if(isset($attr['where']) && !empty($attr['where'])){
                    if(is_string($attr['where']))
                        $this->sql .= " WHERE ".$attr['where'];
                    else {
                        $temp=array();                       
                        foreach($attr['where'] as $column_name => $value) 
                            if (is_array($attr['where'][$column_name])){
                                foreach (array_slice($attr['where'][$column_name], 0, 1) as $k => $v) {
                                    $arraykey=' '.strtoupper($k).' ';
                                }
                                $temp[] = $column_name.$arraykey. implode(' AND ', array_fill(0, sizeof($attr['where'][$column_name]), '?'));
                            }   
                            else                          
                                $temp[] = $column_name.$compare.' ?';                      
                        $this->sql .= " WHERE ".implode(" $implode ", $temp);
                    }
                }   
                if(isset($attr['group_by']) && !empty($attr['group_by']))
                $this->sql .= " GROUP BY ".$attr['group_by']." ";
                if(isset($attr['order_by']) && !empty($attr['order_by']))
                    $this->sql .= " ORDER BY ".$attr['order_by'];                           
                if(isset($attr['limit']) && !empty($attr['limit']))
                    $this->sql .= " LIMIT ".$attr['limit'];                
                if($is_debug){
                    debug($attr);
                    debug($this->sql, true);
                } 
                if(isset($attr['where']) && !empty($attr['where']) && is_array($attr['where']))  {                    
                    foreach($attr['where'] as $column_name=>$value)
                        if (is_array($attr['where'][$column_name]))
                            foreach($attr['where'] [$column_name] as $key=>$value)                 
                                $data[] =$value;
                        else                      
                            $data[]=$value;  
                }                
                $this->execute($data);
                $data = $this->stmt->fetchAll(PDO::FETCH_OBJ);
                if($count)                    
                    return ['result'=>$data,'count'=>$this->stmt->rowCount()];                
                return $data;
            } catch(PDOException $e){
                $this->log($e,'SELECT',' PDO');
            } catch(Exception $e){
                $this->log($e,'SELECT',' General');                
            }
        }

        protected final function update($result= array(), $attr = array(), $is_debug = false){
            $data=array();
            try{
                $this->sql = "UPDATE ";                              
                if(!isset($this->table) || empty($this->table)){
                    throw new PDOException("Table not set.");
                }                
                $this->sql .= $this->table." SET ";
                if(isset($result) && !empty($result)){
                    if(is_string($result)){
                        $this->sql .= $result;
                    } else {
                        $temp_data = array();
                        foreach($result as $col_name => $val){
                            $temp_data[] = $col_name." = ?";
                        } 
                    $this->sql .= implode(" , " , $temp_data);
                    }
                } else 
                    throw new Exception("Resulting Data is empty"); 
                /**** WHERE clause */    
                if(isset($attr['implode']) && !empty($attr['implode']))
                    $implode= $attr['implode'];
                else
                    $implode=' AND '; 
                if(isset($attr['compare']) && !empty($attr['compare']))
                    $compare= $attr['compare'];
                else
                    $compare='=';             
                if(isset($attr['where']) && !empty($attr['where'])){
                    if(is_string($attr['where']))
                        $this->sql .= " WHERE ".$attr['where'];
                    else {
                        $temp=array();                       
                        foreach($attr['where'] as $column_name => $value) 
                            if (is_array($attr['where'][$column_name])){
                                foreach (array_slice($attr['where'][$column_name], 0, 1) as $k => $v) {
                                    $arraykey=' '.strtoupper($k).' ';
                                }
                                $temp[] = $column_name.$arraykey. implode(' AND ', array_fill(0, sizeof($attr['where'][$column_name]), '?'));
                            }   
                            else                          
                                $temp[] = $column_name.$compare.' ?';                      
                        $this->sql .= " WHERE ".implode(" $implode ", $temp);
                    }
                }                          
                if($is_debug){
                    debug($result);
                    debug($attr);
                    debug($this->sql, true);
                }                
                if(isset($result) && !empty($result) && is_array($result)){
                    foreach($result as $column_name => $value){
                        $data[]=$value;
                    }
                }
                if(isset($attr['where']) && !empty($attr['where']) && is_array($attr['where']))  {                    
                    foreach($attr['where'] as $column_name=>$value)
                        if (is_array($attr['where'][$column_name]))
                            foreach($attr['where'] [$column_name] as $key=>$value)                 
                                $data[] =$value;
                        else                      
                            $data[]=$value;  
                }                           
                return $this->execute($data);              
            } catch(PDOException $e){
                $this->log($e,'UPDATE',' PDO');                  
            } catch(Exception $e){
                $this->log($e,'UPDATE',' General'); 
            }
        }
        
        protected final function insert($attr= array(), $is_debug = false){
            $data=array();
            try{
                $this->sql = "INSERT INTO ";                              
                if(!isset($this->table) || empty($this->table)){
                    throw new PDOException("Table not set.");
                }                
                $this->sql .= $this->table." SET ";
                if(isset($attr) && !empty($attr)){
                    if(is_string($attr)){
                        $this->sql .= $attr;
                    } else {
                        $temp_data = array();
                        foreach($attr as $col_name => $val){
                            $temp_data[] = $col_name." = ?";
                        } 
                    $this->sql .= implode(" , " , $temp_data);
                    }
                } else 
                    throw new Exception("Attribute Data was found empty");                                    
                if($is_debug){
                    debug($attr);
                    debug($this->sql, true);
                }                
                if(isset($attr) && !empty($attr) && is_array($attr)){
                    foreach($attr as $column_name => $value){
                        $data[]=$value;
                    }
                }              
                $this->execute($data); 
                return $this->conn->lastInsertId();             
            } catch(PDOException $e){
                $this->log($e,'INSERT',' PDO');                
            } catch(Exception $e){
                $this->log($e,'INSERT',' General');             
            }
        }        

        protected final function delete($attr = array(), $is_debug = false){
            $data=array();
            try{  
                $this->sql = "DELETE FROM ";
                if(!isset($this->table) || empty($this->table)){
                    throw new PDOException("Table not set.");
                }                
                $this->sql .= $this->table." ";
                if(isset($attr['compare']) && !empty($attr['compare']))
                $compare= $attr['compare'];
                else
                $compare='='; 
                if(isset($attr['where']) && !empty($attr['where'])){
                    if(is_string($attr['where'])){
                        $this->sql .= " WHERE ".$attr['where'];
                    } else {
                        $temp = array();
                        foreach($attr['where'] as $column_name => $value){
                            $str = $column_name.$compare.'?';
                            $temp[] = $str;
                        }
                        $this->sql .= " WHERE ".implode(" AND ", $temp);
                    }
                }               
                if($is_debug){
                    debug($attr);
                    debug($this->sql, true);
                }
                if(isset($attr['where']) && !empty($attr['where']) && is_array($attr['where'])){                 
                    foreach($attr['where'] as $column_name=>$value)                      
                    $data[]=$value;  
                }  
                $this->execute($data);                
            } catch(PDOException $e){
                $this->log($e,'DELETE',' PDO');                
            } catch(Exception $e){
                $this->log($e,'DELETE',' General');                
            }
        }
    }

    