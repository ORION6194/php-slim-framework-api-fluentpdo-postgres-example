<?php

namespace KCTAPI\Controllers;

use KCTAPI\Models\SessionsModel;
use Rhumsaa\Uuid\Uuid;
use KCTAPI\Models\Message;


class BaseController {

    protected $app;
    protected $requestBody;
    protected $request;
    protected $userId;
    protected $sessionKeyObj;
    protected $isDebug = true;

    public function __construct() {
        date_default_timezone_set('Asia/Calcutta');
        $this->app = \Slim\Slim::getInstance();
    }

    protected function getSessionKey() {
        $sessionId = $this->app->request->headers->get('X-API-KEY');
        return $sessionId;
    }

    public function output($object, $status = 200) {
        $this->app->response->setStatus($status);
        $this->setNoCache();
        $this->setContentTypeToJson();
        $this->app->response->setBody(json_encode($object));
    }

    private function setNoCache() {
        $this->app->response->header('Cache-Control', 'no-cache, must-revalidate');
        $this->app->response->header('Pragma', 'no-cache');
        $this->app->response->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
    }

    private function setContentTypeToJson() {
        $this->app->response->header('Content-Type', 'application/json');
    }

    public function outputSuccess($data, $msg) {
        if ($this->isDebug === true) {
            $this->writeRequestDebugLog($data);
        }
        $obj = Message::successMessage($data, $msg, 200);
        $this->output($obj, 200);
    }

    public function outputError($msg) {
        
        $obj = Message::errorMessage($msg, 400);
        $this->output($obj, 400);
    }

    public function outputNotFoundError($msg) {
        $obj = Message::errorMessage($msg, 404);
        $this->output($obj, 404);
    }

    public function outputBadRequestError($msg) {
        $obj = Message::errorMessage($msg, 400);
        $this->output($obj, 400);
    }

    public function outputRequiredError($field, $msg) {
        $obj = Message::requiredErrorMessage($field, $msg, 400);
        $this->output($obj, 400);
    }

    public function outputInternalServerError($msg) {
        $obj = Message::errorMessage($msg, 500);
        $this->output($obj, 500);
    }

    public function outputForbidden($msg) {
        $obj = Message::errorMessage($msg, 403);
        $this->output($obj, 403);
    }

    public function outputInvalid($msg) {
        $obj = Message::errorMessage($msg, 401);
        $this->output($obj, 401);
    }
    
    public function outputErrorMessageWithResponse($data,$msg) {
        $obj = Message::errorMessageWithResult($data,$msg, 402);
        $this->output($obj, 402);
    }

    protected function getRequestBody() {
        $this->requestBody = $this->app->request->getBody();
        if ($this->isDebug === true) {
            $this->writeRequestDebugLog($this->requestBody);
        }
        return $this->requestBody;
    }

    protected function getRequest() {
        $this->request = $this->app->request();
    }

    protected function generateUDID() {
        return str_replace("-", '', Uuid::uuid4()->toString());
    }

    protected function validateSession() {
        $xApiKey = $this->getSessionKey();
        $sessionModelObj = new SessionsModel();
        $sessionModelObj->id = $xApiKey;
        $sessionRow = $sessionModelObj->getSession();
        if (!empty($sessionRow)) {
            $sessionModelObj->toObj($sessionRow);
            $this->userId = $sessionModelObj->getUserId();
            $this->sessionKeyObj = $sessionModelObj;
            return true;
        } else {
            $this->outputInvalid(Message::ERROR_INVALID_SESSION_KEY);
            return false;
        }
    }
    protected function writeRequestDebugLog($dataArray) {
        $req = $this->app->request()->getPathInfo();
        $reqMthod = $this->app->request->getMethod();
        if(file_exists("logs/request_log"."_".date("m.d.y").".log")) {
            $file = fopen("logs/request_log"."_".date("m.d.y").".log", "a");
        }
        else {
            $file = fopen("logs/request_log" ."_".date("m.d.y").".log", "w");
        }
        fwrite($file, date("m.d.y h:m:s"));
        fwrite($file, "\n");
        fwrite($file, $req);
        fwrite($file, "\n");
        fwrite($file, $reqMthod);
        fwrite($file, "\n");
        fwrite($file, json_encode($dataArray));
        fwrite($file, "\n");
        fclose($file);
    }

    protected function writeRequestResponseDebugLog($dataArray, $dataArrayResponse) {
        $req = $this->app->request()->getPathInfo();
        $reqMthod = $this->app->request->getMethod();
        if(file_exists("logs/req_res_log"."_".date("m.d.y").".log")) {
            $file = fopen("logs/req_res_log"."_".date("m.d.y").".log", "a");
        }
        else {
            $file = fopen("logs/req_res_log" ."_".date("m.d.y").".log", "w");
        }
        fwrite($file, date("m.d.y h:m:s"));
        fwrite($file, "\n");
        fwrite($file, $req);
        fwrite($file, "\n");
        fwrite($file, $reqMthod);
        fwrite($file, "\n");
        fwrite($file, "Request:\n");
        fwrite($file, json_encode($dataArray));
        fwrite($file, "\n");
        fwrite($file, "Response:\n");
        fwrite($file, json_encode($dataArrayResponse));
        fwrite($file, "\n");
        fclose($file);
    }
    /*
       protected function getHashPassword($password) {
           return password_hash($password, PASSWORD_BCRYPT);
       }

       protected function checkPassword($hash, $password) {
           return password_verify($password, $hash);
       }

       protected function getDefaultStartAndEndTime() {
           $startTime = strtotime('today midnight');
           $endTime = strtotime('tomorrow midnight');

           $defaultTime = array(
               'start_time' => $startTime,
               'end_time' => $endTime
           );
           return $defaultTime;
       }

       protected function getTimeDifferenceInMinit($cur_time, $secondTime) {
           $minsTime = ($cur_time - $secondTime) / 60;
           return $minsTime;
       }

       protected function getBaseUrl() {
           global $config,$mode;
           $baseUrl =  $config[$mode]['base_url'];
           return $baseUrl ;
       }
	   
       protected function getFile($fileName=''){
           global $config,$mode;
           if(isset($fileName) && $fileName!=''){

               $file = $config[$mode]['uploads'].$fileName;
               $checkFile = file_exists($file);
               if($checkFile){
                   $file = $config[$mode]['uploads'] .$fileName ;
                   echo file_get_contents($file);
               }
               else{
                   //$file = $config[$mode]['uploads'].$config[$mode]['default_image'];
                   //echo file_get_contents($file);
                   echo "";
               }

           }
       }*/ 
}
