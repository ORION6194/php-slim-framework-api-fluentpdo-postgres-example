<?php

namespace KCTAPI\Models;

class Message {

    const SUCCESS= "SUCCESS";
    const ERROR = "ERROR";
    const SERVER_ERROR = "Internal Server Error Occurred";

    const FIELD_REQUIRED = "This field is compulsory";
    const ALREADY_EXISTS = "This field already Exists";
    const INVALID_LOGIN = "Invalid Login Credentials";
    const ERROR_INVALID_SESSION_KEY = "Invalid Session Id";
    const CATEGORY_DOES_NOT_EXIST = "Category Does Not Exist";

    public static function successMessage($result, $messageText, $status) {

        $msg = new Message();
        $msg->type = Message::SUCCESS;
        $msg->result = $result;
        $msg->message = $messageText;
        $msg->status = $status;
        
        return $msg;
    }

    public static function errorMessage($messageText, $status) {
        $msg = new Message();
        $msg->type = Message::ERROR;
        $msg->message = $messageText;
        $msg->status = $status;
        return $msg;
    }

    public static function requiredErrorMessage($field, $messageText, $status) {
        $msg = new Message();
        $msg->type = Message::ERROR;
        $msg->field = $field;
        $msg->message = $messageText;
        $msg->status = $status;
        return $msg;
    }

    public static function errorMessageWithResult($result, $messageText, $status) {

        $msg = new Message();
        $msg->type = Message::ERROR;
        $msg->result = $result;
        $msg->message = $messageText;
        $msg->status = $status;
        
        return $msg;
    }

}
