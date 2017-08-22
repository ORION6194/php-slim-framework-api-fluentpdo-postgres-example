<?php

namespace KCTAPI\Controllers;

use KCTAPI\Models\Message;
use Exception;
use KCTAPI\Models\CustomersModel;

class CustomerController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    public function installPaths() {
        $controller = $this;

        $this->app->post('/customer/registration', function() use ($controller) {
            $controller->registration();
        });

    }

    public function registration(){
        try{
            $this->getRequestBody();
            $body = json_decode($this->requestBody);
            $customersModelObj = new CustomersModel();
            $mobile = isset($body->mobile)?trim($body->mobile):'';
            $email = isset($body->email)?trim($body->email):'';
            $full_name = isset($body->full_name)?trim($body->full_name):'';
            $address = isset($body->address)?trim($body->address):'';
            $city = isset($body->city)?trim($body->city):'';
            $customer_id = isset($body->customer_id)?trim($body->customer_id):'';
            $id = isset($body->id)?trim($body->id):$this->generateUDID();

            if(empty($mobile)){
                $this->outputRequiredError('mobile',Message::FIELD_REQUIRED);
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
            if(empty($customer_id)){
                $this->outputRequiredError('customer_id',Message::FIELD_REQUIRED);
                return;
            }

            $customersModelObj->setId($id);
            $customersModelObj->setFullName($full_name);
            $customersModelObj->setMobile($mobile);
            $customersModelObj->setEmail($email);
            $customersModelObj->setAddress($address);
            $customersModelObj->setCity($city);
            $customersModelObj->setCustomerId($customer_id);
            $customersModelObj->setCreatedBy($customersModelObj->getId());
            $customersModelObj->setUpdatedBy($customersModelObj->getId());

            $checkMobileExists = $customersModelObj->getByMobile();

            if(!empty($checkMobileExists['mobile'])){
                $this->outputRequiredError('mobile',Message::ALREADY_EXISTS);
                return;
            }

            $checkEmailExists = $customersModelObj->getByEmail();
            if(!empty($checkEmailExists['email'])){
                $this->outputRequiredError('email',Message::ALREADY_EXISTS);
                return;
            }

            $checkCustomerIdExists = $customersModelObj->getByCustomerId();
            if(!empty($checkCustomerIdExists['customer_id'])){
                $this->outputRequiredError('customer_id',Message::ALREADY_EXISTS);
                return;
            }

            $customersModelObj->save();
            $returnArr = $customersModelObj->getByMobile();
            $this->outputSuccess($returnArr,Message::SUCCESS);
        }catch(Exception $ex){
            print_r($ex);
            $this->outputInternalServerError(Message::SERVER_ERROR);
        }
    }

}