<?php

class DB{

    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbase = "todo_php";
    private $conn = false;
    private $mysqli = "";
    private $result = array();

    public function __construct()
    {
        if(!$this->conn){
            $this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->dbase);

            if($this->mysqli->connect_error){
                array_push($this->result, $this->mysqli->connect_error);
                return false;
            }
        }else{
            return true;
        }
    }

    public function __destruct(){
        if($this->conn){
            if($this->conn->close()){
                $this->conn = false;
                return true;
            }
        }else{
            return false;
        }
    }

    public function insert($table, $params=array()){
        if($this->tableExists($table)){

            $table_columns = implode(',', array_keys($params));
            $table_values = implode("','", $params);
            $query = "INSERT INTO $table ($table_columns) VALUES ('$table_values')";

            if($this->mysqli->query($query)){
                array_push($this->result, $this->mysqli->insert_id);
                return true;
            }else{
                array_push($this->result, $this->mysqli->error);
                return false;
            }
        }else{
            return false;
        }
    }

    public function update($table, $params=array(), $where=null){
        if($this->tableExists($table)){

            $args = array();
            foreach($params as $key => $value){
                $args[] = "$key = '$value'";
            }
            
            $query = "UPDATE $table SET ". implode(',',$args);
            if($where != null){
                $query .= "WHERE $where";
                if($this->mysqli->query($query)){
                    array_push($this->result, $this->mysqli->affected_rows);
                    return true;
                }else{
                    array_push($this->result, $this->mysqli->error);
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

public function delete($table, $where = null){
    if($this->tableExists($table)){
        $query = "DELETE FROM $table ";
        if($where != null){
            $query .= "WHERE $where";
            if($this->mysqli->query($query)){
                array_push($this->result, $this->mysqli->affected_rows);
                return true;
            }else{
                array_push($this->result, $this->mysqli->error);
                return false;
            }
        }else{
            return false;
        }
    }else{
        return false;
    }

}

    public function select($table, $rows="*", $join=null, $where=null, $order=null,$limit=null){

        if($this->tableExists($table)){
            $query = "SELECT $rows FROM $table";
            if($join != null){
                $query .= " JOIN $join";
            }
            if($where != null){
                $query .= " WHERE $where";
            }
            if($order != null){
                $query .= " ORDER BY $order";
            }
            if($limit != null){
                $query .= " LIMIT 0, $limit";
            }

            $sql  = $this->mysqli->query($query);
        if($sql){
            $this->result = $sql->fetch_all(MYSQLI_ASSOC);
            return true;
        }
        else{
            array_push($this->result, $this->mysqli->error);
            return false;
        }
        }else{
            return false;
        }
    }

    public function sql($sql){
        $query  = $this->mysqli->query($sql);
        if($query){
            $this->result = $query->fetch_all(MYSQLI_ASSOC);
            return true;
        }
        else{
            array_push($this->result, $this->mysqli->error);
            return false;
        }
    }

    public function tableExists($table){
        $query = "SHOW TABLES FROM $this->dbase LIKE '$table'"; 
        $tableInDB = $this->mysqli->query($query);
        if($tableInDB->num_rows == 1){
            return true;
        }else{
            array_push($this->result, $table."doesn't exist in database.");
            return false;
        }

    }

    public function getResult(){
        $val = $this->result;
        $this->result = array();
        return $val;
    }
}

?>