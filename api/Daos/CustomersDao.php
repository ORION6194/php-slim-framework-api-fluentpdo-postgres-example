<?php

namespace KCTAPI\Daos;

use Exception;

class CustomersDao extends BaseDao{
    
    public function __construct() {
        parent::__construct();
    }

    public function save($customersModelObj){
        try{
            $this->dbConn->getPdo()->beginTransaction();
            $this->dbConn->insertInto('customers', (array)$customersModelObj)->execute();
            $this->dbConn->getPdo()->commit();
        }catch(Exception $e){
            $this->dbConn->getPdo()->rollBack();
            throw $e;
        }
    }
    
    public function update($customersModelObj){ //print_r($customersModelObj); exit;
        try{
            $this->dbConn->getPdo()->beginTransaction();
            $this->dbConn->update('customers')->set((array)$customersModelObj)->where('id', $customersModelObj->id)->execute();
            $this->dbConn->getPdo()->commit();
        }catch(Exception $e){
            $this->dbConn->getPdo()->rollBack();
            throw $e;
        }
    }
    
    public function get($customersModelObj){
        try{
            $result = $this->dbConn->from('customers')->where('id', $customersModelObj->id)->fetch();
            return $result;
        }catch(Exception $e){
            throw $e;
        }
    }
    public function getByPhoneNumber($customersModelObj){
        try{
            $result = $this->dbConn->from('customers')->where('mobile', $customersModelObj->mobile)->fetch();
            return $result;
        }catch(Exception $e){
            throw $e;
        }
    }
    public function getByEmail($customersModelObj){
        try{
            $result = $this->dbConn->from('customers')->where('email', $customersModelObj->email)->fetch();
            return $result;
        }catch(Exception $e){
            throw $e;
        }
    }
    public function getByCustomerId($customersModelObj){
        try{
            $result = $this->dbConn->from('customers')->where('customer_id', $customersModelObj->customer_id)->fetch();
            return $result;
        }catch(Exception $e){
            throw $e;
        }
    }
    public function getByNameLike($customersModelObj){
        try{
            $result = $this->dbConn->from('customers')->where('full_name like ', "%".$customersModelObj->full_name."%")->fetch();
            return $result;
        }catch(Exception $e){
            throw $e;
        }
    }
}