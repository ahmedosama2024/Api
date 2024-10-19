<?php
class Employees{
    private $conn;
    public function __construct($conn) {
        $this->conn=$conn;
    }
    public function getAllEmployees(){
        $sql= "SELECT * FROM `employees`";
        $run1=$this->conn->query($sql);
        $employees=[];
        while($row= $run1->fetch_array()){
            $employees[]=$row;
        }
        return $employees;
    }
    public function showEmployees($id){
        $sql2="SELECT * FROM `employees` WHERE `id`=$id";
        $run2=$this->conn->query($sql2);
        $employee=$run2->fetch_array();
        return $employee;
    }
    public function store($data){
        $name=$data["name"];
        $email=$data["email"];
        $phone=$data["phone"];
        $salary=$data["salary"];

        $sql="SELECT * FROM `employees` WHERE `email`='$email' ;";
        $select=$this->conn->query( $sql )->num_rows;
        if($select>=1){
        return "['Error'=>'This email is already taken']";
        }
        
        $sql2="SELECT * FROM `employees` WHERE `phone`='$phone' ;";
        $select1=$this->conn->query( $sql2 )->num_rows;
        if ($select1>=1){
            return "['Error'=>'This Phone is already taken']";
        }

        $sql3= "INSERT INTO `employees` (`name`,`email`,`phone`,`salary`) 
                VALUES ('$name','$email','$phone','$salary')";

        $run3=$this->conn->query($sql3);

        if ($run3){
            return "['success'=>'Data inserted']";
        }
    }
    public function update($data,$id){
        $name=$data["name"];
        $email=$data["email"];
        $phone=$data["phone"];
        $salary=$data["salary"];
        
        $sql="SELECT * FROM `employees` WHERE `email`='$email' AND `id`!= $id ;";
        $select=$this->conn->query( $sql )->num_rows;
        if($select>=1){
        return "['Error'=>'This email is already taken']";
        }

        $sql2="SELECT * FROM `employees` WHERE `phone`='$phone' AND `id`!= $id ;";
        $select1=$this->conn->query( $sql2 )->num_rows;
        if ($select1>=1){
            return "['Error'=>'This Phone is already taken']";
        }

        $sql3= "UPDATE `employees` SET `name`='$name',`email`='$email',`phone`='$phone',`salary`='$salary' WHERE `id`=$id";
        $run3=$this->conn->query($sql3);
        if ($run3){
            return "['success'=>'Data Updated']";
        }  

    }
    public function destroy ($id){
        $sql="DELETE FROM `employees` WHERE `id`=$id;";
        $run=$this->conn->query($sql);
        if($run){
            return "['success'=>'Data deleted successfully']";        
        }else{
            return "['Error'=>'Data can not deleted']";
        }
    }
              
}
