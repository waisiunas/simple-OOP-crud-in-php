<?php
class Database {
    private $db_host = 'localhost';
    private $db_user = 'root';
    private $db_pass = '';
    private $db_name = 'oop_crud';
    public $conn;
    

    public function __construct() {
        $this->conn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);

        if ($this->conn->connect_error) {
            die("Not Connected" . $this->conn->connect_error);
        }
    }

    public function show($table) {
        $sql = "SELECT * FROM `${table}`";
        $result = $this->conn->query($sql);
        $records = $result->fetch_all(MYSQLI_ASSOC);
        return $records;
    }

    public function show_single($table, $id) {
        $sql = "SELECT * FROM `${table}` WHERE `id` = ${id}";
        $result = $this->conn->query($sql);
        $record = $result->fetch_assoc();
        return $record;
    }

    public function insert($table, $array) {
        $keys = array_keys($array);
        $values = array_values($array);
        $keys = implode('`, `', $keys);
        $values = implode("', '", $values);

        $sql = "INSERT INTO `${table}`(`${keys}`) VALUES ('${values}')";

        if ($this->conn->query($sql)) {
            return true;
        } else {
            return false;
        }  
    }

    public function update($table, $array, $id) {
        $pairs = [];
        foreach($array as $key => $values ){
            $pairs[] = "`${key}` = '${values}'";
        }
        $pair = implode(', ', $pairs);
        $sql = "UPDATE `${table}` SET ${pair} WHERE `id` = ${id}";
        if ($this->conn->query($sql)) {
            return true;
        } else {
            return false;
        }  
    }

    public function delete($table, $id) {
        $sql = "DELETE FROM `${table}` WHERE `id` = ${id}";

        if ($this->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
        
    }

    public function is_email_exist($table, $email) {
        $sql = "SELECT * FROM `${table}` WHERE `email` = '${email}'";
        $result = $this->conn->query($sql);
        if($result->num_rows == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function update_email_exist($table, $email, $id) {
        $sql = "SELECT * FROM `${table}` WHERE `email` = '${email}' AND `id` != ${id}";
        $result = $this->conn->query($sql);
        if($result->num_rows == 0) {
            return false;
        } else {
            return true;
        }
    }
    
}

$db = new Database();
