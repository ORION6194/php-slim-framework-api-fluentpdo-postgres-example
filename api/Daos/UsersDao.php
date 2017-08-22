<?php

namespace KCTAPI\Daos;

use Exception;

class UsersDao extends BaseDao{
    
    public function __construct() {
        parent::__construct();
    }

    public function save($usersModelObj){
        try{
            $this->dbConn->getPdo()->beginTransaction();
            $this->dbConn->insertInto('users', (array)$usersModelObj)->execute();
            $this->dbConn->getPdo()->commit();
        }catch(Exception $e){
            $this->dbConn->getPdo()->rollBack();
            throw $e;
        }
    }
    
    public function update($usersModelObj){ //print_r($usersModelObj); exit;
        try{
            $this->dbConn->getPdo()->beginTransaction();
            $this->dbConn->update('users')->set((array)$usersModelObj)->where('id', $usersModelObj->id)->execute();
            $this->dbConn->getPdo()->commit();
        }catch(Exception $e){
            $this->dbConn->getPdo()->rollBack();
            throw $e;
        }
    }
    
    public function get($usersModelObj){
        try{
            $result = $this->dbConn->from('users')->where('id', $usersModelObj->id)->fetch();
            return $result;
        }catch(Exception $e){
            throw $e;
        }
    }
    public function getByPhoneNumber($usersModelObj){
        try{
            $result = $this->dbConn->from('users')->where('mobile', $usersModelObj->mobile)->fetch();
            return $result;
        }catch(Exception $e){
            throw $e;
        }
    }
    public function getByEmail($usersModelObj){
        try{
            $result = $this->dbConn->from('users')->where('email', $usersModelObj->email)->fetch();
            return $result;
        }catch(Exception $e){
            throw $e;
        }
    }
    public function getByEmployeeId($usersModelObj){
        try{
            $result = $this->dbConn->from('users')->where('mobile', $usersModelObj->employee_id)->fetch();
            return $result;
        }catch(Exception $e){
            throw $e;
        }
    }
    public function getByEmployeeLevel($usersModelObj){
        try{
            $result = $this->dbConn->from('users')->where('employee_id', $usersModelObj->employee_level)->fetch();
            return $result;
        }catch(Exception $e){
            throw $e;
        }
    }
    public function getByNameLike($usersModelObj){
        try{
            $result = $this->dbConn->from('users')->where('full_name like ', "%".$usersModelObj->full_name."%")->fetch();
            return $result;
        }catch(Exception $e){
            throw $e;
        }
    }
}