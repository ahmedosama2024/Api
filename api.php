<?php
require "./conn.php";
require "./employees.php";



header('Content-Type: application/json');

$employeeObj=new Employees($conn);

$methods=$_SERVER['REQUEST_METHOD'];

$endPoint= $_SERVER['PATH_INFO'];


switch ($methods) {
    case 'GET':
        $employees=$employeeObj->getAllEmployees();
        if($endPoint==='/employees') {
        echo (json_encode($employees));
        } elseif (preg_match('/^\/employees\/(\d+)$/',$endPoint,$match)) {
            $id= $match[1];
            $employee=$employeeObj->showEmployees($id);
            echo (json_encode($employee));
        }        
        break;
    case 'POST':
        if($endPoint==='/employees'){
            $data=json_decode(file_get_contents('php://input'),true);
            $employee=$employeeObj->store($data);
            echo (json_encode($employee));  
        }
        break;
    case 'PUT':
        if (preg_match('/^\/employees\/(\d+)$/',$endPoint,$match)) {
            $id= $match[1];
            $data=json_decode(file_get_contents('php://input'),true);
            $employee=$employeeObj->update($data,$id);
            echo (json_encode($employee));
        }     
        break;    
    case 'DELETE':
        if (preg_match('/^\/employees\/(\d+)$/',$endPoint,$match)) {
            $id= $match[1];
            $employee=$employeeObj->destroy($id);
            echo (json_encode($employee));
        }
        break;       
}