<?php

namespace KCTAPI\Controllers;

use KCTAPI\Models\SessionsModel;
use KCTAPI\Models\Message;
use Exception;
use KCTAPI\Models\UsersModel;

class UserController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    public function installPaths() {
        $controller = $this;

        $this->app->post('/user/login', function() use ($controller) {
            $controller->login();
        });

        $this->app->post('/user/registration', function() use ($controller) {
            $controller->registration();
        });

    }

    public function login() {
        try {
            
            $this->getRequestBody();
            $body = json_decode($this->requestBody);
            $mobile = isset($body->mobile) ? trim($body->mobile) : '';
            $email = isset($body->email) ? trim($body->email) : '';
            $password = isset($body->password) ? trim($body->password) : '';
            if(empty($mobile)){
                $this->outputRequiredError('mobile',Message::FIELD_REQUIRED);
                return;
            }
            if(empty($email)){
                $this->outputRequiredError('email',Message::FIELD_REQUIRED);
                return;
            }
            if(empty($password)){
                $this->outputRequiredError('password',Message::FIELD_REQUIRED);
                return;
            }

            $usersModelObj = new UsersModel();
            $usersModelObj->setMobile($mobile);
            $usersModelObj->setEmail($email);
            $usersModelObj->setPassword($password);

            $checkMobileExists = $usersModelObj->getByMobile();
            $checkEmailExists = $usersModelObj->getByEmail();
//            print_r($checkMobileExists);
            $responseArr = array();
            if(!empty($checkMobileExists['mobile'])){
                if($password == $checkMobileExists['password']){
                    $responseArr['user_details'] = $checkMobileExists;
                    $sessionsModelObj = new SessionsModel();
                    $sessionsModelObj->setUserId($checkMobileExists['id']);
                    $session_check = $sessionsModelObj->getSessionByUserId();
                    $current_time = time()*1000;
                    if (!empty($session_check) || $session_check==FALSE) {
                        $sessionsModelObj->setId($session_check['id']);
                        $sessionsModelObj->setUserId($checkMobileExists['id']);
                        $sessionsModelObj->setSessionKey($session_check['session_key']);
                        $sessionsModelObj->setUpdatedBy($checkMobileExists['id']);
                        $sessionsModelObj->setLastSeen($current_time);
                        $sessionsModelObj->setStartTime($current_time);
                        $sessionsModelObj->setCreatedBy($checkMobileExists['id']);
                        $sessionsModelObj->setRecordStatus('D');
                        $sessionsModelObj->update();

                        $sessionsModelObj->setId($this->generateUDID());
                        $sessionsModelObj->setUserId($checkMobileExists['id']);
                        $sessionsModelObj->setSessionKey($this->generateUDID());
                        $sessionsModelObj->setUpdatedBy($checkMobileExists['id']);
                        $sessionsModelObj->setLastSeen($current_time);
                        $sessionsModelObj->setStartTime($current_time);
                        $sessionsModelObj->setCreatedBy($checkMobileExists['id']);
                        $sessionsModelObj->setRecordStatus('A');
                        $sessionsModelObj->save();
                    } else {
                        $sessionsModelObj->setId($this->generateUDID());
                        $sessionsModelObj->setUserId($checkMobileExists['id']);
                        $sessionsModelObj->setSessionKey($this->generateUDID());
                        $sessionsModelObj->setUpdatedBy($checkMobileExists['id']);
                        $sessionsModelObj->setLastSeen($current_time);
                        $sessionsModelObj->setStartTime($current_time);
                        $sessionsModelObj->setCreatedBy($checkMobileExists['id']);
                        $sessionsModelObj->setRecordStatus('A');
                        $sessionsModelObj->save();
                    }
                    $responseArr['api_session_id'] = $sessionsModelObj->getSessionKey();
                    $responseArr['session'] = $sessionsModelObj;
                }
                else{
                    $this->outputError(Message::INVALID_LOGIN);
                    return;
                }
            }
            else if(!empty($checkEmailExists['email'])){
                if($password == $checkEmailExists['password']){
                    $responseArr['user_details'] = $checkEmailExists;
                    $sessionsModelObj = new SessionsModel();
                    $sessionsModelObj->setUserId($checkEmailExists['id']);
                    $session_check = $sessionsModelObj->getSessionByUserId();
                    $current_time = time()*1000;
                    if (!empty($session_check) || $session_check==FALSE) {
                        $sessionsModelObj->setId($session_check['id']);
                        $sessionsModelObj->setUserId($checkEmailExists['id']);
                        $sessionsModelObj->setSessionKey($session_check['session_key']);
                        $sessionsModelObj->setUpdatedBy($checkEmailExists['id']);
                        $sessionsModelObj->setLastSeen($current_time);
                        $sessionsModelObj->setStartTime($current_time);
                        $sessionsModelObj->setCreatedBy($checkEmailExists['id']);
                        $sessionsModelObj->setRecordStatus('D');
                        $sessionsModelObj->update();

                        $sessionsModelObj->setId($this->generateUDID());
                        $sessionsModelObj->setUserId($checkEmailExists['id']);
                        $sessionsModelObj->setSessionKey($this->generateUDID());
                        $sessionsModelObj->setUpdatedBy($checkEmailExists['id']);
                        $sessionsModelObj->setLastSeen($current_time);
                        $sessionsModelObj->setStartTime($current_time);
                        $sessionsModelObj->setCreatedBy($checkEmailExists['id']);
                        $sessionsModelObj->setRecordStatus('A');
                        $sessionsModelObj->save();
                    } else {
                        $sessionsModelObj->setId($this->generateUDID());
                        $sessionsModelObj->setUserId($checkEmailExists['id']);
                        $sessionsModelObj->setSessionKey($this->generateUDID());
                        $sessionsModelObj->setUpdatedBy($checkEmailExists['id']);
                        $sessionsModelObj->setLastSeen($current_time);
                        $sessionsModelObj->setStartTime($current_time);
                        $sessionsModelObj->setCreatedBy($checkEmailExists['id']);
                        $sessionsModelObj->setRecordStatus('A');
                        $sessionsModelObj->save();
                    }
                    $responseArr['api_session_id'] = $sessionsModelObj->getSessionKey();
                    $responseArr['session'] = $sessionsModelObj;
                }
                else{
                    $this->outputError(Message::INVALID_LOGIN);
                    return;
                }
            }
            else{
                $this->outputError(Message::INVALID_LOGIN);
                return;
            }
            $this->outputSuccess($responseArr,Message::SUCCESS);
        } catch (Exception $e) {
            print_r($e);
            $this->outputInternalServerError(Message::SERVER_ERROR);
        }
    }

    public function registration(){
        try{
            $this->getRequestBody();
            $body = json_decode($this->requestBody);
            $usersModelObj = new UsersModel();
            $mobile = isset($body->mobile)?trim($body->mobile):'';
            $id = isset($body->id)?trim($body->id):$this->generateUDID();
            $email = isset($body->email)?trim($body->email):'';
            $password = isset($body->password)?trim($body->password):'';
            $full_name = isset($body->full_name)?trim($body->full_name):'';
            $address = isset($body->address)?trim($body->address):'';
            $employee_id = isset($body->employee_id)?trim($body->employee_id):'';
            $employee_level = isset($body->employee_level)?trim($body->employee_level):'';
            $city = isset($body->city)?trim($body->city):'';

            if(empty($mobile)){
                $this->outputRequiredError('mobile',Message::FIELD_REQUIRED);
                return;
            }
            if(empty($password)){
                $this->outputRequiredError('password',Message::FIELD_REQUIRED);
                return;
            }
            if(empty($full_name)){
                $this->outputRequiredError('full_name',Message::FIELD_REQUIRED);
                return;
            }
            if(empty($city)){
                $this->outputRequiredError('city',Message::FIELD_REQUIRED);
                return;
            }
            $usersModelObj->setId($id);
            $usersModelObj->setFullName($full_name);
            $usersModelObj->setMobile($mobile);
            $usersModelObj->setEmail($email);
            $usersModelObj->setEmployeeId($employee_id);
            $usersModelObj->setEmployeeLevel($employee_level);
            $usersModelObj->setAddress($address);
            $usersModelObj->setPassword($password);
            $usersModelObj->setCity($city);
            $usersModelObj->setCreatedBy($usersModelObj->getId());
            $usersModelObj->setUpdatedBy($usersModelObj->getId());

            $checkMobileExists = $usersModelObj->getByMobile();

            if(!empty($checkMobileExists['mobile'])){
                $this->outputRequiredError('mobile',Message::ALREADY_EXISTS);
                return;
            }

            $checkEmailExists = $usersModelObj->getByEmail();
            if(!empty($checkEmailExists['email'])){
                $this->outputRequiredError('email',Message::ALREADY_EXISTS);
                return;
            }

            $checkEmployeeExists = $usersModelObj->getByEmployeeId();
            if(!empty($checkEmployeeExists['employee_id'])){
                $this->outputRequiredError('employee_id',Message::ALREADY_EXISTS);
                return;
            }

            $usersModelObj->save();
            $returnArr = $usersModelObj->getByMobile();

            $this->outputSuccess($returnArr,Message::SUCCESS);
        }catch(Exception $ex){
            print_r($ex);
            $this->outputInternalServerError(Message::SERVER_ERROR);
        }
    }

}