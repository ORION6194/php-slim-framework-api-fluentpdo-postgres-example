<?php

namespace KCTAPI\Daos;

use Exception;

class SessionsDao extends BaseDao{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function save($sessionsModelObj){
        try{
            $this->dbConn->getPdo()->beginTransaction();
            $this->dbConn->insertInto('sessions', (array)$sessionsModelObj)->execute();
            $this->dbConn->getPdo()->commit();
        }catch(Exception $e){
            $this->dbConn->getPdo()->rollBack();
            throw $e;
        }
    }
    
    public function update($sessionsModelObj){ //print_r($sessionsModelObj); exit;
        try{
            $this->dbConn->getPdo()->beginTransaction();
            $this->dbConn->update('sessions')->set((array)$sessionsModelObj)->where('id', $sessionsModelObj->id)->execute();
            $this->dbConn->getPdo()->commit();
        }catch(Exception $e){
            $this->dbConn->getPdo()->rollBack();
            throw $e;
        }
    }
    
    public function get($sessionsModelObj){
        try{
            $result = $this->dbConn->from('sessions')->where('id', $sessionsModelObj->id)->fetch();
            return $result;
        }catch(Exception $e){
            throw $e;
        }
    }
    
     public function getSession($sessionsModelObj){
        try{

            $result = $this->dbConn->from('sessions as s')
                    ->join('users as u ON ( s.user_id = u.id )')
                    ->where(array('s.session_key'=> $sessionsModelObj->id,'s.record_status'=>'A',
                                    'u.record_status'=>'A'))
                    ->fetch();         

            return $result;
        }catch(Exception $e){
            throw $e;
        }
    }
    public function getSessionByUserId($sessionsModelObj){
        try{
            $result = $this->dbConn->from('sessions')
                    ->where(array('user_id'=> $sessionsModelObj->user_id,
                            'record_status'=>'A'
                            ))
                    ->fetch();
            return $result;
        }catch(Exception $e){
            throw $e;
        }
    }
    public function updateByUserId($sessionsModelObj){ 
        try{
            $this->dbConn->getPdo()->beginTransaction();
            $this->dbConn->update('sessions')->set((array)$sessionsModelObj)->where('user_id', $sessionsModelObj['user_id'])->execute();
            $this->dbConn->getPdo()->commit();
        }catch(Exception $e){
            $this->dbConn->getPdo()->rollBack();
            throw $e;
        }
    }
   
}